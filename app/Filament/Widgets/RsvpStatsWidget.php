<?php

namespace App\Filament\Widgets;

use App\Models\Guest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RsvpStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = Guest::count();
        $attending = Guest::where('attendance', true)->count();
        $notAttending = Guest::where('attendance', false)->count();
        $pending = Guest::whereNull('attendance')->count();

        return [
            Stat::make('Total Invitees', (string) $total),
            Stat::make('RSVP: Attending', (string) $attending)
                ->description($total > 0 ? round(($attending / $total) * 100) . '% of invitees' : 'No invitees yet')
                ->color('success'),
            Stat::make('RSVP: Not Attending', (string) $notAttending)
                ->color('danger'),
            Stat::make('RSVP: Pending', (string) $pending)
                ->color('warning'),
        ];
    }
}
