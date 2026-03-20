<?php

namespace App\Filament\Widgets;

use App\Models\Guest;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class InvitationLinksWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Guest::query()->latest())
            ->heading('Copy Personal Invitation Link')
            ->description('Copy the link and share directly to each guest.')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->copyable(),
                TextColumn::make('invitation_link')
                    ->label('Invitation Link')
                    ->state(fn (Guest $record): string => request()->getSchemeAndHttpHost() . '/invitation/' . $record->slug)
                    ->url(fn (Guest $record): string => request()->getSchemeAndHttpHost() . '/invitation/' . $record->slug, shouldOpenInNewTab: true)
                    ->copyable()
                    ->copyMessage('Invitation link copied')
                    ->wrap(),
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5, 10, 25]);
    }
}
