<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folders extends Model
{
    use HasFactory;

    protected $fillable = ['cases_id', 'folder_name', 'type'];

    public function cases()
    {
        return $this->belongsTo(Cases::class, 'cases_id');
    }

    public function fileCases()
    {
        return $this->hasMany(Filecases::class, 'folders_id');
    }
}
