<?php

namespace App\Filament\Shared\RelationManagers;

use App\Models\File;
use BackedEnum;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class BaseFilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    protected static string|BackedEnum|null $icon = 'heroicon-o-photo';

    public function table(Table $table): Table
    {
        return $table
            ->heading(Lang::get('admin.files.models'))
            ->modelLabel(Lang::get('admin.files.model'))
            ->pluralModelLabel(Lang::get('admin.files.models'))
            ->recordTitleAttribute('storage_path')
            ->columns([
                TextColumn::make('slug')
                    ->label(Lang::get('admin.files.labels.slug'))
                    ->toggleable(),
                TextColumn::make('storage_disk')
                    ->label(Lang::get('admin.files.labels.storage_disk'))
                    ->toggleable(),
                TextColumn::make('storage_path')
                    ->label(Lang::get('admin.files.labels.storage_path'))
                    ->toggleable(),
                TextColumn::make('mime_type')
                    ->label(Lang::get('admin.files.labels.mime_type'))
                    ->toggleable(),
                TextColumn::make('file_role')
                    ->label(Lang::get('admin.files.labels.file_role'))
                    ->toggleable(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->schema(fn (AttachAction $action) => [
                        $action->getRecordSelect(),
                        Select::make('file_role')
                            ->label(Lang::get('admin.files.labels.file_role'))
                            ->options(
                                fn () => collect(File::SUPPORTED_ROLES)
                                    ->mapWithKeys(fn (string $value) => [$value => $value])
                                    ->toArray()
                            ),
                    ]),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return Lang::get('admin.files.models');
    }
}
