<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'project_models';

    // Daftar kolom yang bisa diisi (fillable)
    protected $fillable = ['name_project', 'is_active'];

    // Cast kolom 'is_active' sebagai boolean
    protected $casts = [
        'is_active' => 'boolean',
    ];
}

