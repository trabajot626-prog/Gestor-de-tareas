@props(['task', 'statuses'])

<div class="bg-gray-50 rounded-lg p-4 flex items-start justify-between hover:bg-gray-100 transition">
    <div class="flex-1">
        <h4 class="font-semibold text-gray-900">{{ $task->title }}</h4>
        @if ($task->description)
            <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
        @endif
        @if ($task->due_date)
            <p class="text-xs text-gray-500 mt-2">
                Vencimiento: {{ $task->due_date->format('d/m/Y') }}
            </p>
        @endif
        <p class="text-xs text-gray-500 mt-1">
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
