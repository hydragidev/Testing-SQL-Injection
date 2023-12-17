<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectEndpointModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'project_endpoint_models';

    // Daftar kolom yang bisa diisi (fillable)
    protected $fillable = [
        'project_id',
        'name_url',
        'method',
        'url',
        'post_data',
        'headers',
        'taskID',
        'is_active',
    ];

    // Cast kolom 'project_id' sebagai integer
    protected $casts = [
        'project_id' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relasi dengan model ProjectModel (jika diperlukan)
    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'project_id');
    }
}
