<?php

namespace App\Filament\Resources\Industries\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class IndustryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
        
            ->components([
                TextInput::make('name')
                    ->label(__('industry.name'))
                    ->required(),
                ColorPicker::make('color')
                    ->label(__('industry.color'))
                    ->default("#cccccc")
                    ->required(),
                Textarea::make('description')
                    ->label(__('industry.description'))

                    ->columnSpanFull(),
                
            ]);
    }
}
