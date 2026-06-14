<?php

namespace App\Filament\Resources\Files;

use App\Filament\Resources\Files\Pages\CreateFile;
use App\Filament\Resources\Files\Pages\EditFile;
use App\Filament\Resources\Files\Pages\ListFiles;
use App\Filament\Resources\Files\Schemas\FileForm;
use App\Filament\Resources\Files\Tables\FileTable;
use App\Models\File;
use BackedEnum;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Lang;
use League\Flysystem\UnableToCheckFileExistence;
use Throwable;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    public static function form(Schema $schema): Schema
    {
        return FileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FileTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFiles::route('/'),
            'create' => CreateFile::route('/create'),
            'edit' => EditFile::route('/{record}/edit'),
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
            } catch (UnableToCheckFileExistence) {
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
            } catch (Throwable) {
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
