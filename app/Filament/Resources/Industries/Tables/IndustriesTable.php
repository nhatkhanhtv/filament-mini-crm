<?php

namespace App\Filament\Resources\Industries\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IndustriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->deferLoading()
            ->columns([
                TextColumn::make('index')
                    ->label('#')
                    ->rowIndex()
                    ->sortable(),
                    ColorColumn::make('color')
                    ->label(__('industry.color'))
                    ->tooltip(fn($record) => $record->color),
                TextColumn::make('name')
                    ->label(__('industry.name'))
                    ->searchable(),
                TextColumn::make('description')
                    ->label(__('industry.description'))
                    ->limit(60)     
                    ->action(
                        Action::make('modal')
                            ->schema([
                                TextEntry::make('description')
                                ->label(__('industry.description'))
                            ])
                        ->modalHeading(fn($record)=> __('industry.description').":" . $record->name)
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)                        
                    ) 
                    ->searchable(),
                
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver()
                    ->label(false)
                    ->tooltip(__('general.button.edit'))
                    ->icon(Heroicon::PencilSquare),
                DeleteAction::make()
                    ->icon(Heroicon::Trash)
                    ->tooltip(__('general.button.delete'))
                    ->label(false)
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
