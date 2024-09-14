<?php

namespace App\Models\Roles;

use App\Models\Menu\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nombre','descripcion','vigente'];

    function Menu() {
        return $this->belongsToMany(Menu::class, 'role_menu','role_id', 'menu_id');

    }
}
