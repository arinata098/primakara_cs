<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtributChecklist extends Model
{
    use HasFactory;

    protected $table = 'data_atribut_checklist';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_atribut',
        'id_list',
        'id_ruangan',
        'status',
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function validations()
    {
        return $this->hasOne(Validasi::class, 'id_atribut_checklist', 'id_atribut');
    }

    public function list()
    {
        return $this->belongsTo(CheckList::class, 'id_list', 'id_list');
    }
}

