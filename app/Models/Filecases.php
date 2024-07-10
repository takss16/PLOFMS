<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filecases extends Model
{
    use HasFactory;

    protected $fillable = ['casefolder_id', 'file_name'];

    public function casefolder()
    {
        return $this->belongsTo(Casefolder::class, 'casefolder_id');
    }
}
