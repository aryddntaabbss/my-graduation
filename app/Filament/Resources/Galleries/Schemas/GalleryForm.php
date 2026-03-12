<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('image')
                ->image()
                ->directory('gallery')
                ->required(),

            TextInput::make('caption')
                ->maxLength(255),
        ]);
    }
}