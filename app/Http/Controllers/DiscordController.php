<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiscordController extends Controller
{
    public function redirect()
    {
        return view('discord.redirect');
    }
}
