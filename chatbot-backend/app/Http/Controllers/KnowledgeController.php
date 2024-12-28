<?php

namespace App\Http\Controllers;

use App\Models\Knowledge;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index()
    {
        return Knowledge::with(['category', 'subcategory'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255|unique:knowledges,question',
            'answer' => 'required|string',
            'language' => 'required|string|max:5',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ], [
            'question.required' => 'La pregunta es obligatoria.',
            'question.unique' => 'Ya existe una entrada con esta pregunta.',
            'question.max' => 'La pregunta no puede superar los 255 caracteres.',
            'answer.required' => 'La respuesta es obligatoria.',
            'language.required' => 'El idioma es obligatorio.',
            'language.max' => 'El idioma no puede superar los 5 caracteres.',
            'category_id.required' => 'El campo category_id es obligatorio.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'subcategory_id.exists' => 'La subcategoría seleccionada no existe.',
        ]);

        return Knowledge::create($validated);
    }

    public function show($id)
    {
        return Knowledge::with(['category', 'subcategory'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        // Busca el conocimiento por ID
        $knowledge = Knowledge::findOrFail($id);
    
        // Valida los datos enviados
        $validated = $request->validate([
            'question' => 'string|max:255|unique:knowledges,question,' . $knowledge->id, // Evita duplicados
            'answer' => 'string',
            'language' => 'string|max:5', // Asegura un código de idioma válido
            'category_id' => 'nullable|exists:categories,id', // Asegura que la categoría existe
            'subcategory_id' => 'nullable|exists:subcategories,id', // Asegura que la subcategoría existe
        ], [
            'question.string' => 'La pregunta debe ser un texto.',
            'question.max' => 'La pregunta no puede superar los 255 caracteres.',
            'question.unique' => 'Ya existe una entrada con esta pregunta.',
            'answer.string' => 'La respuesta debe ser un texto.',
            'language.string' => 'El idioma debe ser un texto.',
            'language.max' => 'El idioma no puede superar los 5 caracteres.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'subcategory_id.exists' => 'La subcategoría seleccionada no existe.',
        ]);
    
        // Actualiza el conocimiento
        $knowledge->update($validated);
    
        return response()->json([
            'message' => 'Knowledge updated successfully',
            'knowledge' => $knowledge,
        ]);
    }

    public function destroy($id)
    {
        Knowledge::findOrFail($id)->delete();

        return response()->json(['message' => 'Knowledge deleted successfully']);
    }
}