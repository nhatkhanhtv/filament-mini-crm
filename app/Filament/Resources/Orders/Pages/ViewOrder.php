<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\OrderStatus;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::Pencil)
                ->color(Color::Yellow),
            Action::make('approved')
                ->label(__('order.button.approve'))
                ->requiresConfirmation()
                ->icon(Heroicon::CheckBadge)
                ->action(function($record) {
                    $record->update([
                        'status' => OrderStatus::processing
                    ]);
                    
                })
        ];
    }

    protected function getAllRelationManagers(): array
    {
        return [];
    }

    protected function resolveRecord(int|string $key): Model
    {
        return parent::resolveRecord($key)
            ->load(['orderItems', 'orderItems.product']);
    }
}
