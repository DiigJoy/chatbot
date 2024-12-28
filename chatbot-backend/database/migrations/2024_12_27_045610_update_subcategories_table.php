<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {
            // Elimina la clave foránea si existe
            $table->dropForeign(['category_id']);
            
            // Elimina la columna si existe
            $table->dropColumn('category_id');
            
            // Vuelve a agregar la columna con la nueva definición
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {
            // Elimina la clave foránea
            $table->dropForeign(['category_id']);
            
            // Restaura la definición original
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }
};
