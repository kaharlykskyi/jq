<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class DiscordGuild
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!User::checkGuild()) {
            abort(403, 'Access denied because your discord account is not a member of Just Quality server.');
        }
        return $next($request);
    }
}
