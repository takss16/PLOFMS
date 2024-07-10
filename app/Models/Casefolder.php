<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casefolder extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'casefolders';

    // The attributes that are mass assignable.
    protected $fillable = [
        'folder_id',
        'folder_name',
    ];

    /**
     * Get the folder that owns the casefolder.
     */
    public function folder()
    {
        return $this->belongsTo(Folders::class, 'folder_id');
    }

    public function filecases()
    {
        return $this->hasMany(Filecases::class, 'casefolder_id');
    }

}
