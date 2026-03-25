<?php

namespace App\Filament\Resources\Customers\Tables;

use App\CustomerStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\TextSize;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->defaultSort('id', 'desc')
            ->defaultPaginationPageOption(20)
            ->paginated([20, 50, 100, 200, 500])
            ->columns([
                TextColumn::make('row_index')
                    ->label('#')
                    ->rowIndex()
                    ->sortable(false),            
                TextColumn::make('full_name')
                    ->label(__('customer.full_name'))
                    ->searchable(), 
                TextColumn::make('email')
                    ->label(__('customer.email'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('customer.phone'))
                    ->searchable(),
                TextColumn::make('address')
                    ->label(__('customer.address'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('customer.status'))
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                TextColumn::make('industry.name')
                    ->label(__('customer.industry_id'))            
                    ->color(fn($record) => Color::hex($record->industry->color))
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(CustomerStatus::class),
                SelectFilter::make('industry_id')
                    ->relationship('industry', 'name')
                  
            ])->filtersTriggerAction(
                fn(Action $action) => $action->slideOver()
            )
           
            ->recordActions([
                ViewAction::make()
                    ->label(false)
                    ->tooltip(__('general.button.view'))
                    ->icon(Heroicon::Eye),
                EditAction::make()
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
