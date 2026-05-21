<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Bienvenido, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-600 mb-6">Gestiona tus proyectos y tareas de forma eficiente</p>
            <a href="{{ route('projects.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Ir a Mis Proyectos
            </a>
        </div>

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @php
                $projectCount = auth()->user()->projects()->count();
                $taskCount = \App\Models\Task::whereIn('project_id', auth()->user()->projects()->pluck('id'))->count();
                $completedCount = \App\Models\Task::whereIn('project_id', auth()->user()->projects()->pluck('id'))->where('status', 'completed')->count();
            @endphp

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="text-3xl font-bold text-blue-600">{{ $projectCount }}</div>
                <p class="text-blue-700 text-sm mt-2">Proyecto(s)</p>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <div class="text-3xl font-bold text-yellow-600">{{ $taskCount }}</div>
                <p class="text-yellow-700 text-sm mt-2">Tarea(s) Total</p>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                <div class="text-3xl font-bold text-green-600">{{ $completedCount }}</div>
                <p class="text-green-700 text-sm mt-2">Completada(s)</p>
            </div>
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts::app>
