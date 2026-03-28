<?php
namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;

class OrderItemRepeater
{
    public static function make(): Repeater
    {
        return Repeater::make("orderItems")
            ->relationship()
            ->table([
                TableColumn::make(__("order.items.product_id")),
                TableColumn::make(__("order.items.quantity"))->wrapHeader(),
                TableColumn::make(__("order.items.unit_price")),
                TableColumn::make(__("order.items.subtotal")),
            ])
            ->compact()
            ->schema([
                Select::make("product_id")
                    ->relationship("product", "name")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live(onBlur: true, debounce: "1s")
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Lấy thông tin sản phẩm từ state
                        $product = Product::find($state);

                        $set(
                            "unit_price",
                            $product?->price ?? 0,
                            shouldCallUpdatedHooks: true,
                        );
                    }),

                TextInput::make("quantity")
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->live(onBlur: true, debounce: 500)
                    ->afterStateUpdated(
                        fn($get, $set) => static::updateCalculateRow(
                            $get,
                            $set,
                        ),
                    )
                    ->extraInputAttributes([
                        "class" => "text-right w-20",
                    ]),

                TextInput::make("unit_price")
                    ->required()
                    ->readOnly()
                    ->live(onBlur: true, debounce: 500)
                    ->afterStateHydrated(
                        fn($get, $set) => static::updateCalculateRow(
                            $get,
                            $set,
                        ),
                    )
                    ->afterStateUpdated(
                        fn($get, $set) => static::updateCalculateRow(
                            $get,
                            $set,
                        ),
                    )
                    ->extraInputAttributes([
                        "class" => "text-right",
                    ]),

                TextInput::make("subtotal")
                    ->readOnly()
                    ->extraInputAttributes([
                        "class" => "text-right",
                    ]),
                // ->reactive()

                // ->afterStateHydrated(
                //     fn($get, $set) => static::updateCalculateRow(
                //         $get,
                //         $set,
                //     ),
                // )
                // ->afterStateUpdated(
                //     fn($get, $set) => static::updateCalculateRow(
                //         $get,
                //         $set,
                //     ),
                // ),
            ])
            ->live(onBlur: true)

            ->afterStateUpdated(function ($record, $state, $set, $get) {
                $total = collect($state)->sum(
                    fn($item) => $item["subtotal"] ?? 0,
                );
                $set("subtotal", $total, shouldCallUpdatedHooks: true);
            })
            ->itemNumbers()

            ->defaultItems(1)
            ->addActionAlignment(Alignment::Start)
            ->compact()
            ->reorderable()
            ->cloneable()
            // ->itemHeaders(false)
            ->collapsible();
    }

    public static function updateCalculateRow(Get $get, Set $set): void
    {
        $unitPrice = $get("unit_price");
        $quantity = $get("quantity");

        $set("subtotal", $unitPrice * $quantity);
    }
}
