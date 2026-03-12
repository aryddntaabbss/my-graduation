<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Guest;

class InvitationController extends Controller
{
    public function show($slug)
{
    $guest = Guest::where('slug', $slug)->firstOrFail();

    return view('client.invitation', compact('guest'));
}
}
