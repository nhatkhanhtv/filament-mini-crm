<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Customer;
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
use Illuminate\Support\Onceable;

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
                    Group::make()
                        ->columns([
                            "default" => 1,
                            "md" => 2,
                        ])
                        ->schema([
                            Select::make("customer_id")
                                ->relationship("customer", "full_name")
                                ->searchable()
                                ->preload() 
                                ->required()
                                ->label(__("order.customer"))->columnSpan(2)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $customer = Customer::find($state);
                                    $set("customer.email", $customer?->email);
                                    $set("customer.phone", $customer?->phone);
                                }),
                            TextInput::make("customer.email")->readOnly()->columnSpan(1),
                            TextInput::make("customer.phone")->readOnly()->columnSpan(1),
                        ])
                        ->columnSpan(2),
                        Group::make()->schema([
                            DatePicker::make("ordered_at")
                                ->label(__("order.ordered_at"))
                                ->default(now())
                                ->date("d/m/Y")
                                ->required(),
                        ])
                   
                        ->columnSpan(1)
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
