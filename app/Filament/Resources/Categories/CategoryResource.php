<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\ManageCategories;
use App\Models\Category;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make("name")->required(),
            Textarea::make("description")->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")
                    ->searchable()
                    ->label(__("category.name")),
                TextColumn::make("description")
                    ->label(__("category.description"))
                    ->size(20),
                TextColumn::make("products_count")
                    ->counts("products")
                    ->label(__("category.products_count"))
                    ->sortable(),
            ])

            ->filters([
                //
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            "index" => ManageCategories::route("/"),
        ];
    }

    public static function getModelLabel(): string
    {
        return __("category.model.label");
    }

    public static function getPluralModelLabel(): string
    {
        return __("category.model.plural");
    }

    public static function getNavigationLabel(): string
    {
        return __("category.model.label");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("general.system");
    }
}
