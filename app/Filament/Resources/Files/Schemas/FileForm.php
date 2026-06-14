<?php

namespace App\Filament\Resources\Files\Schemas;

use App\Filament\Resources\Files\FileResource;
use App\Models\File;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class FileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->label(Lang::get('admin.files.labels.slug'))
                    ->default(fn () => Str::uuid()->toString())
                    ->maxLength(255)
                    ->required()
                    ->unique(),
                Select::make('mime_type')
                    ->label(Lang::get('admin.files.labels.mime_type'))
                    ->options(
                        fn () => collect(Config::get('app.allowed_mime_types', []))
                            ->mapWithKeys(fn (string $value) => [$value => $value])
                            ->toArray()
                    )
                    ->in(Config::get('app.allowed_mime_types', []))
                    ->required(),
                Select::make('storage_disk')
                    ->options(
                        fn () => collect(Config::get('filesystems.disks', []))
                            ->keys()
                            ->mapWithKeys(fn (string $value) => [$value => Lang::get('admin.files.disks.' . $value)])
                            ->toArray()
                    )
                    ->required(fn (string $operation) => $operation === 'create')
                    ->disabledOn(['edit', 'view'])
                    ->label(Lang::get('admin.files.labels.storage_disk')),
                TextInput::make('storage_path_readonly')
                    ->label(Lang::get('admin.files.labels.storage_path'))
                    ->placeholder(fn (?File $record) => $record?->storage_path)
                    ->readOnly()
                    ->disabled(),
                Tabs::make('upload')
                    ->tabs([
                        Tab::make(Lang::get('admin.files.labels.image_upload'))
                            ->schema([
                                FileUpload::make('image_upload')
                                    ->label(Lang::get('admin.files.labels.image_upload'))
                                    ->acceptedFileTypes(Config::get('app.allowed_mime_types', []))
                                    ->disk(fn (Get $get) => $get('storage_disk'))
                                    ->downloadable()
                                    ->getUploadedFileUsing(fn (?File $record, BaseFileUpload $component, string $file, string|array|null $storedFileNames) => FileResource::customGetUploadedFileUsing(...func_get_args()))
                                    ->image()
                                    ->imageEditor()
                                    ->openable()
                                    ->preserveFilenames()
                                    ->statePath('storage_path')
                                    ->storeFileNamesIn('storage_path'),
                            ]),
                        Tab::make(Lang::get('admin.files.labels.document_upload'))
                            ->schema([
                                FileUpload::make('document_upload')
                                    ->label(Lang::get('admin.files.labels.document_upload'))
                                    ->acceptedFileTypes(Config::get('app.allowed_mime_types', []))
                                    ->disk(fn (Get $get) => $get('storage_disk'))
                                    ->downloadable()
                                    ->getUploadedFileUsing(fn (?File $record, BaseFileUpload $component, string $file, string|array|null $storedFileNames) => FileResource::customGetUploadedFileUsing(...func_get_args()))
                                    ->openable()
                                    ->preserveFilenames()
                                    ->previewable(false)
                                    ->statePath('storage_path')
                                    ->storeFileNamesIn('storage_path'),
                        ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
