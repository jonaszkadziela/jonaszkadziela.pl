<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Lang;

class ProjectTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->label(Lang::get('admin.projects.labels.slug'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('title')
                    ->label(Lang::get('admin.projects.labels.title'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('body')
                    ->label(Lang::get('admin.projects.labels.body'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('link')
                    ->label(Lang::get('admin.projects.labels.link'))
                    ->limit(40)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('is_pro_bono')
                    ->label(Lang::get('admin.projects.labels.is_pro_bono'))
                    ->sortable()
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('started_at')
                    ->label(Lang::get('admin.projects.labels.started_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('finished_at')
                    ->label(Lang::get('admin.projects.labels.finished_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.projects.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.projects.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_pro_bono')
                    ->label(Lang::get('admin.projects.labels.is_pro_bono')),
                SelectFilter::make('finished_at')
                    ->label(Lang::get('admin.projects.labels.finished_at'))
                    ->options([
                        'only_finished' => Lang::get('admin.projects.labels.only_finished'),
                        'only_unfinished' => Lang::get('admin.projects.labels.only_unfinished'),
                    ])
                    ->modifyQueryUsing(fn (Builder $query, array $state) => match ($state['value']) {
                        'only_finished' => $query->whereNotNull('finished_at'),
                        'only_unfinished' => $query->whereNull('finished_at'),
                        default => $query,
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
