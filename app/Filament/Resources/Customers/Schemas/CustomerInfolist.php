<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\CustomerStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Assets\Font;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('customer.view.label'))
                    ->description(__('customer.view.description'))
                    ->schema([
                        Section::make()
                            ->schema([
                                TextEntry::make('full_name')
                                    ->label(__('customer.full_name'))
                                    ->size(TextSize::Large)
                                    ->weight(FontWeight::Bold),                
                                TextEntry::make('email')
                                    ->label(__('customer.email')) 
                                    ->placeholder('-'),
                                TextEntry::make('phone')
                                    ->label(__('customer.phone'))
                                    ->placeholder('-'),
                                TextEntry::make('address')
                                    ->label(__('customer.address'))
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                            ]),
                        Section::make()
                            ->schema([
                                TextEntry::make('industry.name')
                                    ->label(__('customer.industry_id'))
                                    ->badge()
                                    ->color(fn($record) => Color::hex($record->industry->color)),    
                                TextEntry::make('status')
                                    ->label(__('customer.status')) 
                                    ->badge(),
                                TextEntry::make('created_at')
                                    ->label(__('general.created_at'))                                     
                                    ->dateTime('H:i d/m/Y')
                                    ->placeholder('-')
                                    ->badge()
                                    ->color('gray'),

                                TextEntry::make('updated_at')
                                    ->label(__('general.updated_at')) 
                                    ->dateTime('H:i d/m/Y')
                                    ->placeholder('-')
                                    ->badge()
                                    ->color('gray'), 
                            ])
                            
                       
                        
                    ])
                    ->columns(2),
                Section::make()
                    ->schema([
                        
                        TextEntry::make('description')
                            ->label(__('customer.description'))
                            ->html(), 
                        
                    ]),
                   
                    
                
                
                
                
            ]);
    }
}
