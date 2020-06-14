<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use LaravelRestcord\Discord;
use LaravelRestcord\Discord\ApiClient;
use Mockery;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'no_guild'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function account()
    {
        return $this->hasOne('App\SocialAccount');
    }

    public static function checkGuild()
    {
        $user = self::find(Auth::user()->id);
        $token = $user->account->token;
        $api = Mockery::mock(new ApiClient($token));
        $discord = new Discord($api);
        $guilds = $discord->guilds();
        foreach ($guilds as $guild) {
            if($guild->id == env('DISCORD_GUILD_ID')) {
                return true;
            }
        }
        $user->no_guild = 1;
        $user->save();
        $user->delete();
        return false;
    }
}
