<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\ManageProducts;
use App\Models\Product;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make("name")->label(__("product.name"))->required(),
            TextInput::make("sku")->label(__("product.price"))->unique(),
            TextInput::make("price")
                ->label(__("product.price"))
                ->required()
                ->numeric()
                ->default(0)
                ->suffix(__("general.currency_unit")),

            FileUpload::make("image")
                ->label(__("product.image"))
                ->disk("public")
                ->directory("/product/")
                ->columnSpanFull(),
            Select::make("category_id")
                ->label(__("product.category_id"))
                ->relationship("category", "name")
                ->required(),
            RichEditor::make("description")
                ->label(__("product.description"))
                ->extraAttributes([
                    "class" => "h-96",
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make("name")->label(__("product.name")),
            TextEntry::make("sku")->label(__("product.sku")),
            TextEntry::make("price")
                ->label(__("product.price"))
                ->suffix(__("general.currency_unit"))
                ->formatStateUsing(
                    fn($state) => number_format($state, 0, ".", ","),
                ),
            TextEntry::make("description")
                ->label(__("product.description"))
                ->placeholder("-")
                ->columnSpanFull(),
            ImageEntry::make("image")
                ->label(__("product.image"))
                ->disk("public"),
            TextEntry::make("category_id")->numeric(),
            TextEntry::make("created_at")->dateTime()->placeholder("-"),
            TextEntry::make("updated_at")->dateTime()->placeholder("-"),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginationPageOptions([25, 50, 100, 200, 500])
            ->columns([
                TextColumn::make("#")->rowIndex(),
                ImageColumn::make("image")
                    ->label(__("product.image"))
                    ->disk("public"),
                TextColumn::make("sku")->label(__("product.sku")),

                TextColumn::make("name")->label(__("product.name")),
                TextColumn::make("price")
                    ->label(__("product.price"))
                    ->suffix(__("general.currency_unit"))
                    ->formatStateUsing(
                        fn($state) => number_format($state, 0, ".", ","),
                    ),
                TextColumn::make("category.name")
                    ->label(__("product.category_id"))
                    ->badge()
                    ->color(
                        fn($record) => match (true) {
                            $record->category_id % 3 == 0 => "primary",
                            $record->category_id % 2 == 0 => "success",
                            $record->category_id % 1 == 0 => "warning",
                        },
                    ),
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
                SelectFilter::make("category_id")
                    ->label(__("product.category_id"))
                    ->relationship("category", "name"),
            ])
            ->filtersTriggerAction(fn($action) => $action->slideOver())
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            "index" => ManageProducts::route("/"),
        ];
    }
}
