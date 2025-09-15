<?php

namespace App\Models;

use App\Filters\ConversationFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = ['type', 'name'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot('last_read_at');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function messageStatuses()
    {
        return $this->hasManyThrough(MessageStatus::class, Message::class);
    }



    protected string $default_filters = ConversationFilter::class;
}
