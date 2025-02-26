<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use League\Flysystem\UnableToCheckFileExistence;
use Throwable;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('slug')
                    ->label(Lang::get('admin.files.labels.slug'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('mime_type')
                    ->label(Lang::get('admin.files.labels.mime_type'))
                    ->options(
                        fn () => collect(Config::get('app.allowed_mime_types', []))
                            ->mapWithKeys(fn (string $value) => [$value => $value])
                            ->toArray()
                    )
                    ->in(Config::get('app.allowed_mime_types', []))
                    ->required(),
                Forms\Components\Select::make('storage_disk')
                    ->options(
                        fn () => collect(Config::get('filesystems.disks', []))
                            ->keys()
                            ->mapWithKeys(fn (string $value) => [$value => Lang::get('admin.files.disks.' . $value)])
                            ->toArray()
                    )
                    ->required(fn (string $operation) => $operation === 'create')
                    ->disabledOn(['edit', 'view'])
                    ->label(Lang::get('admin.files.labels.storage_disk')),
                Forms\Components\TextInput::make('storage_path_readonly')
                    ->label(Lang::get('admin.files.labels.storage_path'))
                    ->placeholder(fn (?File $record) => $record?->storage_path)
                    ->readOnly()
                    ->disabled(),
                Forms\Components\FileUpload::make('image_upload')
                    ->label(Lang::get('admin.files.labels.image_upload'))
                    ->statePath('storage_path')
                    ->image()
                    ->imageEditor()
                    ->downloadable()
                    ->openable()
                    ->preserveFilenames()
                    ->storeFileNamesIn('storage_path')
                    ->getUploadedFileUsing(fn (?File $record, BaseFileUpload $component, string $file, string|array|null $storedFileNames) => FileResource::customGetUploadedFileUsing(...func_get_args()))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->label(Lang::get('admin.files.labels.slug'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('storage_disk')
                    ->label(Lang::get('admin.files.labels.storage_disk'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('storage_path')
                    ->label(Lang::get('admin.files.labels.storage_path'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('mime_type')
                    ->label(Lang::get('admin.files.labels.mime_type'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(Lang::get('admin.files.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(Lang::get('admin.files.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return Lang::get('admin.files.model');
    }

    public static function getPluralModelLabel(): string
    {
        return Lang::get('admin.files.models');
    }

    public static function customGetUploadedFileUsing(?File $record, BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array
    {
        /** @var FilesystemAdapter $storage */
        $storage = $component->getDisk();

        $shouldFetchFileInformation = $component->shouldFetchFileInformation();

        if ($shouldFetchFileInformation) {
            try {
                if (!$storage->exists($file)) {
                    return null;
                }
            } catch (UnableToCheckFileExistence $exception) {
                return null;
            }
        }

        $url = null;

        if ($component->getVisibility() === 'private') {
            try {
                $url = $storage->temporaryUrl(
                    $file,
                    now()->addMinutes(5),
                );
            } catch (Throwable $exception) {
                // This driver does not support creating temporary URLs.
            }
        }

        $url ??= $record->getUrl();

        return [
            'name' => ($component->isMultiple() ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? basename($file),
            'size' => $shouldFetchFileInformation ? $storage->size($file) : 0,
            'type' => $shouldFetchFileInformation ? $storage->mimeType($file) : null,
            'url' => $url,
        ];
    }
}
