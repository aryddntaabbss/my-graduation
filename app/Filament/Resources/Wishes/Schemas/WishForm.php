<?php

namespace App\Filament\Resources\Wishes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class WishForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required(),

            Textarea::make('message')
                ->required(),

            Toggle::make('is_approved')
                ->label('Approve Message')
                ->default(true),
        ]);
    }
}