<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Crear Nuevo Proyecto</h1>

                <form method="POST" action="{{ route('projects.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del Proyecto
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                            placeholder="Ej: Proyecto Personal"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción (Opcional)
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Describe el propósito de este proyecto..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Crear Proyecto
                        </button>
                        <a href="{{ route('projects.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
