<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Mis Proyectos</h1>
                <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    + Nuevo Proyecto
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($projects->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 mb-4">No tienes proyectos aún</p>
                    <a href="{{ route('projects.create') }}" class="text-blue-600 hover:text-blue-800">
                        Crear tu primer proyecto
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($projects as $project)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600">
                                        {{ $project->name }}
                                    </a>
                                </h2>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $project->description ?? 'Sin descripción' }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">
                                        {{ $project->tasks->count() }} tarea(s)
                                    </span>
                                    <div class="flex gap-2">
                                        <a href="{{ route('projects.edit', $project) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800" onclick="return confirm('¿Estás seguro?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
