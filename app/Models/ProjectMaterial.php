<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMaterial extends Model
{
    use HasFactory;
    protected $table = 'project_materials';
    protected $fillable = [
        'material_stock',
        'material_quantity',
        'material_price',
        'project_id',
    ];
}
