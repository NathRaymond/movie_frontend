<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        'project_name',
        'project_description',
        'project_start_date',
        'project_end_date',
        'project_contractor',
        'project_estimate'

    ];


    public function contractorName(){
        return $this->belongsTo('App\Models\Contractor', 'project_contractor');
    }
}
