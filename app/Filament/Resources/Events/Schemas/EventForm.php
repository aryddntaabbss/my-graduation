<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->required(),

            DatePicker::make('event_date')
                ->required(),

            TimePicker::make('event_time'),

            TextInput::make('location')
                ->required(),

            Textarea::make('description'),

            TextInput::make('maps_url')
                ->label('Google Maps Link'),
        ]);
    }
}