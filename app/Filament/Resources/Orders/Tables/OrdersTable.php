<?php

namespace App\Filament\Resources\Orders\Tables;

use App\OrderStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("customer.full_name")->numeric()->sortable(),
                TextColumn::make("order_code")->searchable(),
                TextColumn::make("ordered_at")->date()->sortable(),
                TextColumn::make("status")->badge()->sortable(),
                TextColumn::make("subtotal")->numeric()->sortable(),
                TextColumn::make("discount_total")->numeric()->sortable(),
                TextColumn::make("tax_total")->numeric()->sortable(),
                TextColumn::make("total_price")->money()->sortable(),
                TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([ViewAction::make(), EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
