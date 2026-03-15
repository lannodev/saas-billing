<?php

namespace Tests\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\Factories\UserFactory;
use VueFileManager\Subscription\App\User\Traits\Billable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use Billable;
    use HasFactory;
    use Notifiable;

    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->id = Str::uuid();

            // Create user directory for his files
            Storage::makeDirectory("files/$user->id");
        });
    }
}
