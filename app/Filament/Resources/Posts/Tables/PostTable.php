<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Lang;

class PostTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(Lang::get('admin.posts.labels.user'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('slug')
                    ->label(Lang::get('admin.posts.labels.slug'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('title')
                    ->label(Lang::get('admin.posts.labels.title'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('body')
                    ->label(Lang::get('admin.posts.labels.body'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_at')
                    ->label(Lang::get('admin.posts.labels.published_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.posts.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.posts.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('published_at')
                    ->label(Lang::get('admin.posts.labels.published_at'))
                    ->options([
                        'only_published' => Lang::get('admin.posts.labels.only_published'),
                        'only_unpublished' => Lang::get('admin.posts.labels.only_unpublished'),
                    ])
                    ->modifyQueryUsing(fn (Builder $query, array $state) => match ($state['value']) {
                        'only_published' => $query->whereNotNull('published_at'),
                        'only_unpublished' => $query->whereNull('published_at'),
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
