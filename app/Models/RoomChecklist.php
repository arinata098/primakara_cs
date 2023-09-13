<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomChecklist extends Model
{
    use HasFactory;

    protected $table = 'checklist_ruangan';
    protected $primaryKey = 'id_checklist_ruangan';

    protected $fillable = [
        'uuid',
        'id_list',
        'id_ruangan',
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function roomInRCL()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function checklistInRCL()
    {
        return $this->belongsTo(CheckList::class, 'id_list', 'id_list');
    }


}

