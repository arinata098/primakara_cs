<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    use HasFactory;

    protected $table = 'kategori_ruangan';
    protected $primaryKey = 'id_ketegori';

    protected $fillable = [
        'kategori',
        'dibersihkanPerhari',
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function cateRooms()
    {
        return $this->belongsTo(Ruangan::class, 'id_ketegori', 'id_ketegori');
    }

}

