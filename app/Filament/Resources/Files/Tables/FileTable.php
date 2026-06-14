<?php

namespace App\Filament\Resources\Files\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;

class FileTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->label(Lang::get('admin.files.labels.slug'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('storage_disk')
                    ->label(Lang::get('admin.files.labels.storage_disk'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('storage_path')
                    ->label(Lang::get('admin.files.labels.storage_path'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('mime_type')
                    ->label(Lang::get('admin.files.labels.mime_type'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label(Lang::get('admin.files.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Lang::get('admin.files.labels.updated_at'))
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
