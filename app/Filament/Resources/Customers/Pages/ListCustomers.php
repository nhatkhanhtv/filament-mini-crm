<?php

namespace App\Filament\Resources\Customers\Pages;

use App\CustomerStatus;
use App\Filament\Resources\Customers\CustomerResource;
use App\Models\Customer;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        $counts = Customer::query()
            ->selectRaw('status, COUNT(*) as count_status')
            ->groupBy('status')
            ->pluck('count_status', 'status');

        $tabArray = [];
        $tabArray[null] = Tab::make('Tất cả')
            ->icon('heroicon-m-user-group')
            ->badgeColor('success')
            ->badge(array_sum($counts->toArray()));
        foreach(CustomerStatus::cases() as $customerStatus) {
            $tabArray[$customerStatus->value] =  Tab::make($customerStatus->getLabel())
                ->badgeColor($customerStatus->getColor())
                ->modifyQueryUsing(function ($query) use ($customerStatus) {
                    $query->where('status', $customerStatus->value);
                })
                ->badge($counts[$customerStatus->value] ?? 0);
                // ->deferBadge();
        }
        // dd(CustomerStatus::cases());
        return $tabArray;
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return null;
    }
}
