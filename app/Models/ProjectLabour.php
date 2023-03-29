<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLabour extends Model
{
    use HasFactory;
    protected $table = 'project_labour';
    protected $fillable = [
        'labour_name',
        'labour_amount',
    ];
}
