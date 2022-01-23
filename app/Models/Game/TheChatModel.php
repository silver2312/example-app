<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheChatModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'the_chat';
}
