<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\CustomerStatus;
use App\Models\Industry;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([  
                Section::make()
                    ->schema([
                        TextInput::make('full_name')
                        ->label(__('customer.full_name'))
                        ->required()
                       ,
                        TextInput::make('email')
                            ->label(__('customer.email'))
                            ->email(),
                        TextInput::make('phone')
                            ->label(__('customer.phone'))
                            ->required(),
                        Textarea::make('address')
                            ->label(__('customer.address'))
                            ->columnSpanFull()
                        ])              
                ,
                Section::make()
                    ->schema([
                        Select::make('industry_id')
                            ->label(__('customer.industry_id'))
                            ->relationship('industry', 'name')
                            // ->searchable()                    
                            ->required(),
                        Radio::make('status')
                            ->options(CustomerStatus::class)
                            ->label(__('customer.status'))
                            ->required()
                            ->default(0)
                        
                        
                    ]),   
                    Section::make()
                    ->schema([            
                        RichEditor::make('description')
                            ->label(__('customer.description'))
                            ->extraAttributes([
                                'style'=>'height:300px'
                            ])
                    ->columnSpanFull()
                ])->columnSpanFull()
            ]);
    }
}
