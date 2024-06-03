<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryLog extends Model
{
    use HasFactory;

    protected $table = 'history_logs';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
