<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\Guest;
use App\Models\Wish;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function show(string $slug)
    {
        $guest = Guest::where('slug', $slug)->firstOrFail();

        $event = Event::query()->orderBy('event_date')->first();
        $galleries = Gallery::query()->latest()->take(8)->get();
        $wishes = Wish::query()->with('guest')->latest()->get();

        return view('client.invitation', [
            'guest' => $guest,
            'event' => $event,
            'galleries' => $galleries,
            'wishes' => $wishes,
        ]);
    }

    public function submitRsvp(Request $request, string $slug): RedirectResponse
    {
        $guest = Guest::where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'attendance' => ['nullable', 'boolean'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $guest->update([
            'attendance' => $data['attendance'] ?? null,
        ]);

        Wish::create([
            'guest_id' => $guest->id,
            'message' => $data['message'],
        ]);

        return redirect()
            ->to(route('invitation.show', $guest->slug) . '?open=1#guestbook')
            ->with('success', 'Thank you, your RSVP and message have been saved.');
    }
}
