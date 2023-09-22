<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';
    protected $primaryKey = 'id_ruangan';
    protected $keyType = 'string';

    protected $fillable = [
        'nama_ruangan',
        'lantai',
        'kategori'
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function checklistOnRoom()
    {
        return $this->hasMany(RoomChecklist::class, 'id_ruangan', 'id_ruangan');
    }

    public function roomCate()
    {
        return $this->belongsTo(RoomCategory::class, 'kategori', 'id_ketegori');
    }
}

