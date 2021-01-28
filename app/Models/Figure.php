<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Figure extends Model
{

    public const VOICER = 1;
    public const TRANSLATOR = 2;

    protected $fillable = [
        "name",
        "type",
    ];
}
