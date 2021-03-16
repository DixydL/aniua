<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cooperation extends Model
{
    public $table = "cooperation";
    protected $fillable = [
        "html",
    ];
}
