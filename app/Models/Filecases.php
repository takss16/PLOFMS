<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filecases extends Model
{
    use HasFactory;

    protected $fillable = ['folders_id', 'file_name'];

    public function folders()
    {
        return $this->belongsTo(Folders::class, 'folders_id');
    }
}
