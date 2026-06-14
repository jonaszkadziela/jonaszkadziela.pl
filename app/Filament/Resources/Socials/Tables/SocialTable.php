<?php

namespace App\Filament\Resources\Socials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class SocialTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(Lang::get('admin.socials.labels.title'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('link')
                    ->label(Lang::get('admin.socials.labels.link'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('icon')
                    ->label(Lang::get('admin.socials.labels.icon'))
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state) => new HtmlString(
                        '<div class="gap-2 inline-flex items-center"><i class="' . $state . '"></i>' . $state . '</div>',
                    ))
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.socials.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.socials.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
