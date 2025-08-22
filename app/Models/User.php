<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Filters\UserFilter;
use App\Notifications\VerifyEmailCustom;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'profile_picture',
        'fname',
        'mi',
        'lname',
        'suffix',
        'gender',
        'mobile_number',
        'birthday',
        'address',
        'username',
        'email',
        'password',
        'role_type',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)
            ->withTimestamps()
            ->withPivot('last_read_at');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }


    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailCustom());
    }

    protected string $default_filters = UserFilter::class;
}
