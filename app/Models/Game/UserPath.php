<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPath extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'user_path';
}
