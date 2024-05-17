<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use HasFactory;

    protected $fillable = ['case_number', 'docker_number', 'name'];

    public function folders()
    {
        return $this->hasMany(Folders::class, 'cases_id');
    }
}
