<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
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
