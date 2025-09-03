<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    //
//   protected $casts = [
//         'created_at' => 'datetime',
//         'updated_at' => 'datetime',
//         'deadline' => 'date',
//     ];
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'deadline',
        'project_logo',
    ];


}
