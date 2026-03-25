<?php

namespace App\Filament\Resources\Industries\Pages;

use App\Filament\Resources\Industries\IndustryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIndustries extends ListRecords
{
    protected static string $resource = IndustryResource::class;

    public function getBreadcrumbs(): array
    {
        return [
            "#" => __('general.system'),
            __('industry.model.plural')
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver(),
        ];
    }

    
}
