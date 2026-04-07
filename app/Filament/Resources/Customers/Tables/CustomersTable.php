<?php

namespace App\Filament\Resources\Customers\Tables;

use App\CustomerStatus;
use App\Models\Customer;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\TextSize;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(Customer::query()->with(["industry"]))
            ->deferLoading()
            ->defaultSort("id", "desc")
            ->defaultPaginationPageOption(20)
            ->paginated([20, 50, 100, 200, 500])
            ->columns([
                TextColumn::make("row_index")
                    ->label("#")
                    ->rowIndex()
                    ->sortable(false),
                TextColumn::make("full_name")
                    ->label(__("customer.full_name"))
                    ->searchable(),
                TextColumn::make("email")
                    ->label(__("customer.email"))
                    ->searchable()
                    ->copyable()
                    ->copyMessage("Copied")
                    ->copyMessageDuration(1500),
                TextColumn::make("phone")
                    ->label(__("customer.phone"))
                    ->searchable(),
                TextColumn::make("address")
                    ->label(__("customer.address"))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make("status")
                    ->label(__("customer.status"))
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                TextColumn::make("industry.name")
                    ->label(__("customer.industry_id"))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->badge()
                    ->color(fn($record) => Color::hex($record->industry->color))
                    ->searchable()
                    ->sortable(),
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
                SelectFilter::make("status")
                    ->label(__("customer.status"))
                    ->options(CustomerStatus::class)
                    ->multiple(),
                SelectFilter::make("industry_id")
                    ->label(__("customer.industry_id"))
                    ->relationship("industry", "name"),
                Filter::make("created_at")
                    ->schema([
                        DatePicker::make("created_from")->label(
                            __("general.filter.created_from"),
                        ),
                        DatePicker::make("created_until")->label(
                            __("general.filter.created_until"),
                        ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data["created_from"],
                                fn(
                                    Builder $query,
                                    $date,
                                ): Builder => $query->whereDate(
                                    "created_at",
                                    ">=",
                                    $date,
                                ),
                            )
                            ->when(
                                $data["created_until"],
                                fn(
                                    Builder $query,
                                    $date,
                                ): Builder => $query->whereDate(
                                    "created_at",
                                    "<=",
                                    $date,
                                ),
                            );
                    }),
            ])
            ->filtersTriggerAction(fn(Action $action) => $action->slideOver())

            ->recordActions([
                ViewAction::make()
                    ->label(false)
                    ->tooltip(__("general.button.view"))
                    ->icon(Heroicon::Eye),
                EditAction::make()
                    ->label(false)
                    ->tooltip(__("general.button.edit"))
                    ->icon(Heroicon::PencilSquare),
                DeleteAction::make()
                    ->icon(Heroicon::Trash)
                    ->tooltip(__("general.button.delete"))
                    ->label(false),
            ])

            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
