<?php

namespace App\Filament\Resources\Industries;

use App\Filament\Resources\Industries\Pages\CreateIndustry;
use App\Filament\Resources\Industries\Pages\EditIndustry;
use App\Filament\Resources\Industries\Pages\ListIndustries;
use App\Filament\Resources\Industries\Schemas\IndustryForm;
use App\Filament\Resources\Industries\Tables\IndustriesTable;
use App\Models\Industry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class IndustryResource extends Resource
{
    protected static ?string $model = Industry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ListBullet;


    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return IndustryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IndustriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIndustries::route('/'),
            // 'create' => CreateIndustry::route('/create'),
            // 'edit' => EditIndustry::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('industry.model.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('industry.model.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('industry.model.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('general.system');
    }
}
