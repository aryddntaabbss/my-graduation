<?php

namespace App\Filament\Resources\Guests\Tables;

use App\Models\Guest;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GuestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('invitation_link')
                    ->label('Invitation Link')
                    ->state(fn (Guest $record): string => request()->getSchemeAndHttpHost() . '/invitation/' . $record->slug)
                    ->url(fn (Guest $record): string => request()->getSchemeAndHttpHost() . '/invitation/' . $record->slug, shouldOpenInNewTab: true)
                    ->copyable()
                    ->copyMessage('Invitation link copied')
                    ->wrap(),
                TextColumn::make('guest_count')
                    ->sortable(),
                IconColumn::make('attendance')
                    ->boolean()
                    ->label('RSVP'),
                TextColumn::make('created_at')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                //
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
