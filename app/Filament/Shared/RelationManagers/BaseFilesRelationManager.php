<?php

namespace App\Filament\Shared\RelationManagers;

use App\Models\File;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class BaseFilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    protected static ?string $icon = 'heroicon-o-photo';

    public function table(Table $table): Table
    {
        return $table
            ->heading(Lang::get('admin.files.models'))
            ->modelLabel(Lang::get('admin.files.model'))
            ->pluralModelLabel(Lang::get('admin.files.models'))
            ->recordTitleAttribute('storage_path')
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->label(Lang::get('admin.files.labels.slug'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('storage_disk')
                    ->label(Lang::get('admin.files.labels.storage_disk'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('storage_path')
                    ->label(Lang::get('admin.files.labels.storage_path'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('mime_type')
                    ->label(Lang::get('admin.files.labels.mime_type'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('file_role')
                    ->label(Lang::get('admin.files.labels.file_role'))
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action) => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('file_role')
                            ->label(Lang::get('admin.files.labels.file_role'))
                            ->options(
                                fn () => collect(File::SUPPORTED_ROLES)
                                    ->mapWithKeys(fn (string $value) => [$value => $value])
                                    ->toArray()
                            ),
                    ]),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return Lang::get('admin.files.models');
    }
}
