<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFeedback extends Model
{
    protected $table = 'event_feedback';

    protected $fillable = ['event_id', 'user_id', 'registration_id', 'rating', 'comment'];

    public function event() { return $this->belongsTo(Event::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function registration() { return $this->belongsTo(Registration::class); }
}
