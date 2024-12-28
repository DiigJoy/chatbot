<?php

namespace App\Http\Controllers;

use App\Models\Subcategory; // Importa el modelo
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    // Listar todas las subcategorías
    public function index()
    {
        return Subcategory::with('category')->get(); // Carga la categoría asociada
    }

    // Crear una subcategoría
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subcategories,name,NULL,id,category_id,' . $request->category_id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id', // category_id debe existir en la tabla categories
        ], [
            'name.required' => 'El nombre de la subcategoría es obligatorio.',
            'name.unique' => 'Ya existe una subcategoría con este nombre en esta categoría.',
            'name.max' => 'El nombre de la subcategoría no puede superar los 255 caracteres.',
            'description.string' => 'La descripción debe ser un texto.',
            'category_id.required' => 'El campo category_id es obligatorio.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ]);
    
        return Subcategory::create($validated);
    }

    // Mostrar una subcategoría específica
    public function show($id)
    {
        return Subcategory::with('category')->findOrFail($id);
    }

    // Actualizar una subcategoría
    public function update(Request $request, $id)
    {
        // Busca la subcategoría por ID
        $subcategory = Subcategory::findOrFail($id);
    
        // Valida los datos enviados
        $validated = $request->validate([
            'name' => 'string|max:255|unique:subcategories,name,' . $subcategory->id . ',id,category_id,' . $subcategory->category_id, // Evita duplicados por categoría
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id', // Asegura que la categoría existe
        ], [
            'name.string' => 'El nombre debe ser un texto.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'name.unique' => 'Ya existe una subcategoría con este nombre en esta categoría.',
            'description.string' => 'La descripción debe ser un texto.',
            'category_id.required' => 'El campo category_id es obligatorio.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ]);
    
        // Actualiza la subcategoría
        $subcategory->update($validated);
    
        return response()->json([
            'message' => 'Subcategory updated successfully',
            'subcategory' => $subcategory,
        ]);
    }

    // Eliminar una subcategoría
    public function destroy($id)
    {
        Subcategory::findOrFail($id)->delete();

        return response()->json(['message' => 'Subcategory deleted successfully']);
    }
}
