<?php

namespace App\Models\Categoria;

use App\Models\Equipos\Equipos;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'alias',
    ];
    public function equipos()
    {
        return $this->belongsToMany(Equipos::class, 'categoria_equipo', 'equipo_id', 'categoria_id');
    }
}
