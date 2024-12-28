<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Knowledge extends Model
{
    use HasFactory;

    // Define el nombre de la tabla si es necesario
    protected $table = 'knowledges';

    // Define los campos que pueden ser rellenados
    protected $fillable = ['question', 'answer', 'language', 'category_id', 'subcategory_id'];

    // Relaciones
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}