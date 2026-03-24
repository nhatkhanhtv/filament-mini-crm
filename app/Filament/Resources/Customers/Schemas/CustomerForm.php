<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\CustomerStatus;
use App\Models\Industry;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('company_name')
                    ->columnSpanFull(),
                Textarea::make('full_name')
                    ->required()
                    ->columnSpanFull(),
                DatePicker::make('birthday'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('tax_code')
                    ->required(),
                Select::make('status')
                    ->options(CustomerStatus::class)
                    ->required()
                    ->default(0),
                Select::make('industry_id')
                    ->relationship('industry', 'name')
                    ->required(),
            ]);
    }
}
