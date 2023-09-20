<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validasi extends Model
{
    use HasFactory;

    protected $table = 'validasi_data';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_atribut_checklist',
        'tgl_check',
        'jam',
        'id_cs',
        'keterangan',
        'validasi',
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function atributDetails()
    {
        return $this->hasMany(AtributChecklist::class, 'id_atribut', 'id_atribut_checklist');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_cs', 'id');
    }
}

