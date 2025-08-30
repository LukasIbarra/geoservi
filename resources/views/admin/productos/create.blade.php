@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-white">Agregar Nuevo Producto</h1>
        <a href="{{ route('admin.productos.index') }}" class="text-gray-300 hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i> Volver
        </a>
    </div>

    <div class="bg-zinc-800 rounded-xl shadow-lg p-6">
        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Columna izquierda -->
                <div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nombre *</label>
                        <input type="text" id="name" name="name" required
                               class="w-full px-4 py-2 bg-zinc-700 border border-zinc-600 rounded-lg text-white focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Precio *</label>
                        <input type="number" id="price" name="price" min="0" step="0.01" required
                               class="w-full px-4 py-2 bg-zinc-700 border border-zinc-600 rounded-lg text-white focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div class="mb-4">
                        <label for="categoria" class="block text-sm font-medium text-gray-300 mb-2">Categoría *</label>
                        <input type="text" id="categoria" name="categoria" required
                               class="w-full px-4 py-2 bg-zinc-700 border border-zinc-600 rounded-lg text-white focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>

                <!-- Columna derecha -->
                <div>
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-300 mb-2">Imagen *</label>
                        <input type="file" id="image" name="image" accept="image/*" required
                               class="w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600">
                    </div>

                    <div class="mb-4 flex items-center">
                        <input type="checkbox" id="featured" name="featured" value="1"
                               class="w-4 h-4 text-orange-500 bg-zinc-700 border-zinc-600 rounded focus:ring-orange-500">
                        <label for="featured" class="ml-2 text-sm font-medium text-gray-300">Producto Destacado</label>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Descripción *</label>
                <textarea id="description" name="description" rows="4" required
                          class="w-full px-4 py-2 bg-zinc-700 border border-zinc-600 rounded-lg text-white focus:ring-orange-500 focus:border-orange-500"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i> Guardar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection