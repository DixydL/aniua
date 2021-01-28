<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->status = 1;
        });
    }

    protected $fillable = [
        "name",
        "path",
        "url",
        "url_resize",
        "status",
    ];
}
