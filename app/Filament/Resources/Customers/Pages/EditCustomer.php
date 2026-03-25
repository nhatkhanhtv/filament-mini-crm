<?php

namespace App\Filament\Resources\Customers\Pages;

use App\Filament\Resources\Customers\CustomerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            // DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            "#" => __('general.system'),
            CustomerResource::getUrl('index')=> __('customer.model.plural'),
            __('general.page.edit').": ".$this->record->full_name
        ];
    }
}
