<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\OrderStatus;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('customer.view.label'))
                    ->description(__('customer.view.description'))
                    ->columns([
                        'md'=>2
                    ])
                    ->schema([
                        TextEntry::make('customer.full_name')
                            ->label(__('customer.full_name'))
                            ->columnSpanFull(),
                        TextEntry::make('customer.phone')
                            ->label(__('customer.full_name')),
                        TextEntry::make('customer.email')
                            ->label(__('customer.full_name')),
                        TextEntry::make('customer.address')
                            ->label(__('customer.full_name'))
                            ->columnSpanFull(),                       
                        
                    ]),
                Section::make(__('order.view.label'))
                    ->description(__('order.view.description'))
                    ->columns([
                        'md'=>2
                    ])
                    ->schema([
                        TextEntry::make('order_code')
                            ->label(__('order.order_code')),
                        TextEntry::make('status')
                            ->label(__('order.status'))
                                ->badge(OrderStatus::class),
                        TextEntry::make('ordered_at')
                            ->label(__('order.ordered_at'))
                            ->date('d/m/Y')
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->dateTime('H:i d/m/Y')
                            ->placeholder('-')
                            ->label(__('general.created_at')),
                        TextEntry::make('updated_at')
                            ->dateTime('H:i d/m/Y')
                            ->placeholder('-')
                            ->label(__('general.updated_at')),
                    ]),
                RepeatableEntry::make('orderItems')                    
                    ->table([
                        TableColumn::make('#'),
                        TableColumn::make(__('product.sku')),
                        TableColumn::make(__('product.name')),
                        TableColumn::make(__('order.items.unit_price')),
                        TableColumn::make(__('order.items.quantity')),
                        TableColumn::make(__('order.items.subtotal')),
                    ])
                    ->schema([
                        TextEntry::make('#')
                            ->getStateUsing(fn($record)=>$record->id),
                        TextEntry::make('product.sku'),
                        TextEntry::make('product.name'),
                        TextEntry::make('unit_price')
                            ->formatCurrency(),
                        TextEntry::make('quantity')
                            ->formatCurrency(),
                        TextEntry::make('subtotal')
                            ->formatCurrency()   
                    ])
                    ->columnSpanFull(),
                Section::make('')                    
                        ->schema([
                            Group::make()
                                ->schema([
                                    TextEntry::make('subtotal')
                                        ->label(__('order.subtotal'))
                                        ->formatOrderCurrency(),
                                    TextEntry::make('discount_total')
                                        ->label(__('order.discount_total'))
                                        ->formatOrderCurrency(),
                                    TextEntry::make('tax_total')
                                        ->label(__('order.tax_total'))
                                        ->formatOrderCurrency(),
                                    TextEntry::make('total_price')
                                        ->label(__('order.total_price'))
                                        ->formatOrderCurrency()
                                ])
                                ->extraAttributes([
                                    'class'=>"text-right"
                                ])
                                ->columnStart(3)
                            
                        ])
                        ->columns([
                            'md'=>2,
                            'lg'=>3
                        ])
                        ->columnSpanFull()                
            ]);
    }
}
