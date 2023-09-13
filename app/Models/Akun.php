<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'username',
        'password',
        'is_admin',
        'is_aktif'
    ];

    // Set nilai default untuk is_admin ke 0
    protected $attributes = [
        'is_aktif' => 1
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}

