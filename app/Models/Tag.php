<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    
    // habilito la carga masiva
    protected $fillable=['name','slug','color'];

     // ?este metodo es para que no se muestre el id de las categorias sino usando el slug de la misma
     public function getRouteKeyName()
     {
         return "slug";
     }


    // ?Relacion de muchos a muchos
    public function posts(){
        return $this->belongsToMany(Post::class);
    }
    // llegue hasta el minuto 30
}
