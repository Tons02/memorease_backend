<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['conversation_id', 'sender_id', 'body', 'attachments', 'created_at'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Optional: for per-user status like read/delivered
    public function statuses()
    {
        return $this->hasMany(MessageStatus::class);
    }

    protected $casts = [
        'attachments' => 'array',
    ];
}
