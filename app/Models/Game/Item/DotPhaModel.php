<?php

namespace App\Models\Game\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DotPhaModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'item_dotpha';
}
