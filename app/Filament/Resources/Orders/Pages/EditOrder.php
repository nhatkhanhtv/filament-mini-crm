<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\OrderStatus;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
                // ViewAction::make(),
                // DeleteAction::make()
            ];
    }

    protected function getAllRelationManagers(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' =>$this->record]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['status'] = OrderStatus::new;
        return $data;
    }
}
