<?php

namespace App\Http\Controllers;

use App\Models\Category; // Importa el modelo
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Devuelve todas las categorías con sus subcategorías
        return Category::with('subcategories')->get();
    }

    public function store(Request $request)
    {
        // Valida los datos enviados
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', // El nombre debe ser único
            'description' => 'nullable|string',
        ], [
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.unique' => 'Ya existe una categoría con este nombre.',
            'name.max' => 'El nombre de la categoría no puede superar los 255 caracteres.',
            'description.string' => 'La descripción debe ser un texto.',
        ]);

        // Crea una nueva categoría
        return Category::create($validated);
    }

    public function show($id)
    {
        // Busca la categoría por ID y carga sus subcategorías
        return Category::with('subcategories')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        // Busca la categoría por ID
        $category = Category::findOrFail($id);
    
        // Valida los datos enviados
        $validated = $request->validate([
            'name' => 'string|max:255|unique:categories,name,' . $category->id, // Evita duplicados
            'description' => 'nullable|string',
        ], [
            'name.string' => 'El nombre debe ser un texto.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'name.unique' => 'Ya existe una categoría con este nombre.',
            'description.string' => 'La descripción debe ser un texto.',
        ]);
    
        // Actualiza la categoría
        $category->update($validated);
    
        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category,
        ]);
    }
    public function destroy($id)
    {
        // Busca la categoría por ID
        $category = Category::findOrFail($id);

        // Elimina la categoría
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
