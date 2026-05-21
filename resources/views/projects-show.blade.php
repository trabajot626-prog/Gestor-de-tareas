<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <a href="{{ route('projects.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                            ← Volver a Proyectos
                        </a>
                        <h1 class="text-4xl font-bold text-gray-900">{{ $project->name }}</h1>
                        @if ($project->description)
                            <p class="text-gray-600 mt-2">{{ $project->description }}</p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Editar
                        </a>
                        <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition" onclick="return confirm('¿Estás seguro de que deseas eliminar este proyecto? Se eliminarán todas sus tareas.')">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Resumen de tareas -->
                <div class="lg:col-span-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="text-2xl font-bold text-yellow-600">{{ $tasks->where('status', 'pending')->count() }}</div>
                            <p class="text-yellow-700 text-sm">Pendientes</p>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="text-2xl font-bold text-blue-600">{{ $tasks->where('status', 'in_progress')->count() }}</div>
                            <p class="text-blue-700 text-sm">En Proceso</p>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="text-2xl font-bold text-green-600">{{ $tasks->where('status', 'completed')->count() }}</div>
                            <p class="text-green-700 text-sm">Completadas</p>
                        </div>
                    </div>
                </div>

                <!-- Formulario para crear tarea -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-lg shadow p-6 mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Agregar Nueva Tarea</h2>
                        <form method="POST" action="{{ route('tasks.store', $project) }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-2">
                                    <input
                                        type="text"
                                        name="title"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                                        placeholder="Título de la tarea"
                                        required
                                    >
                                    @error('title')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Agregar Tarea
                                </button>
                            </div>
                            <textarea
                                name="description"
                                rows="2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Descripción (opcional)"
                            ></textarea>
                        </form>
                    </div>
                </div>

                <!-- Lista de tareas -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Tareas</h2>

                            @if ($tasks->isEmpty())
                                <p class="text-gray-500 text-center py-8">No hay tareas aún. Crea una para comenzar.</p>
                            @else
                                <div class="space-y-3">
                                    @foreach ($statuses as $status => $label)
                                        @php $statusTasks = $tasks->where('status', $status); @endphp
                                        @if ($statusTasks->isNotEmpty())
                                            <div class="mb-6">
                                                <h3 class="text-lg font-semibold text-gray-700 mb-3">{{ $label }}</h3>
                                                <div class="space-y-2">
                                                    @foreach ($statusTasks as $task)
                                                        <div class="bg-gray-50 rounded-lg p-4 flex items-start justify-between hover:bg-gray-100 transition">
                                                            <div class="flex-1">
                                                                <h4 class="font-semibold text-gray-900">{{ $task->title }}</h4>
                                                                @if ($task->description)
                                                                    <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
                                                                @endif
                                                                <p class="text-xs text-gray-500 mt-2">
                                                                    Creado: {{ $task->created_at->format('d/m/Y H:i') }}
                                                                </p>
                                                            </div>
                                                            <div class="flex gap-2 ml-4">
                                                                <form method="POST" action="{{ route('tasks.updateStatus', $task) }}" class="inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <select name="status" onchange="this.form.submit()" class="text-sm px-3 py-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                                                        @foreach ($statuses as $s => $l)
                                                                            <option value="{{ $s }}" {{ $task->status === $s ? 'selected' : '' }}>
                                                                                {{ $l }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </form>
                                                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-sm text-red-600 hover:text-red-800" onclick="return confirm('¿Estás seguro?')">
                                                                        Eliminar
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
