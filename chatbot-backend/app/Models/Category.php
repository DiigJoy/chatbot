<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Permitir asignación masiva para estos campos
    protected $fillable = ['name', 'description'];

    // Relación inversa con Knowledge
    public function knowledges()
    {
        return $this->hasMany(Knowledge::class);
    }

    // Relación con Subcategory
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}
