<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Section::make(__("order.information"))
                ->columns([
                    "default" => 1,
                    "sm" => 2,
                    "lg" => 3,
                ])
                ->schema([
                    Select::make("customer_id")
                        ->required()
                        ->searchable()
                        ->preload()
                        ->relationship("customer", "full_name")
                        ->label(__("order.customer"))
                        ->columnSpan(2),
                    TextInput::make("customer.email")->readOnly(),
                    TextInput::make("customer.phone")->readOnly(),
                    DatePicker::make("ordered_at")
                        ->label(__("order.ordered_at"))
                        ->default(now())
                        ->date("d/m/Y")
                        ->required(),
                ]),

            Section::make(__("order.items"))
                ->columnSpanFull()
                ->columns(2)
                ->schema([
                    OrderItemRepeater::make()->columnSpanFull(),

                    Group::make()
                        ->schema([
                            TextInput::make("subtotal")
                                ->label(__("order.subtotal"))
                                ->required()
                                ->numeric()
                                ->live()
                                ->afterStateUpdated(
                                    fn(
                                        $get,
                                        $set,
                                    ) => static::updateTaxAndTotalPrice(
                                        $get,
                                        $set,
                                    ),
                                )
                                ->default(0)
                                ->suffix(__("general.currency_unit"))
                                ->extraInputAttributes([
                                    "class" => "text-right",
                                ]),
                            TextInput::make("discount_total")
                                ->label(__("order.discount_total"))
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->live(onBlur: true)
                                ->afterStateUpdated(
                                    fn(
                                        $get,
                                        $set,
                                    ) => static::updateTaxAndTotalPrice(
                                        $get,
                                        $set,
                                    ),
                                )
                                ->suffix(__("general.currency_unit"))
                                ->extraInputAttributes([
                                    "class" => "text-right",
                                ]),
                            TextInput::make("tax_total")
                                ->label(__("order.tax_total"))
                                ->required()
                                ->readOnly()
                                ->numeric()
                                ->default(0)
                                ->suffix(__("general.currency_unit"))
                                ->extraInputAttributes([
                                    "class" => "text-right",
                                ]),
                            TextInput::make("total_price")
                                ->label(__("order.total_price"))
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->suffix(__("general.currency_unit"))
                                ->extraInputAttributes([
                                    "class" => "text-right",
                                ]),
                        ])
                        ->columnSpan(1)
                        ->columnStart(2),
                ]),
        ]);
    }

    public static function updateTaxAndTotalPrice(Get $get, Set $set)
    {
        $subTotal = $get("subtotal");
        $discount = $get("discount_total") ?? 0;
        //tax 10%
        $tax = (($subTotal - $discount) * 10) / 100;
        $set("tax_total", $tax);
        $set("total_price", $subTotal - $discount + $tax);
    }
}
