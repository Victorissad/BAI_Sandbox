@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    <h1 class="text-2xl font-bold">Journaux d'actions</h1>

    @if(session('status'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded">
            {{ session('status') }}
        </div>
    @endif

    {{-- Filtre --}}
    <form method="GET" action="{{ route('logs.index') }}" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
            <input type="date" name="date" value="{{ $date }}"
                   class="border rounded px-3 py-1.5 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Action</label>
            <input type="text" name="keyword" value="{{ $keyword }}" placeholder="Rechercher une action..."
                   class="border rounded px-3 py-1.5 text-sm w-64">
        </div>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-700">
            Filtrer
        </button>
        <a href="{{ route('logs.index') }}"
           class="text-sm text-gray-500 hover:underline self-center">
            Réinitialiser
        </a>
    </form>

    {{-- Purge --}}
    <form method="POST" action="{{ route('logs.purge') }}" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit"
                onclick="return confirm('Supprimer les logs de plus de 12 mois ?')"
                class="bg-red-600 text-white px-4 py-1.5 rounded text-sm hover:bg-red-700">
            Purger les logs &gt; 12 mois
        </button>
    </form>

    {{-- Tableau --}}
    <table class="w-full text-sm border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1 text-left">Date/Heure</th>
                <th class="border px-2 py-1 text-left">Utilisateur</th>
                <th class="border px-2 py-1 text-left">Action</th>
                <th class="border px-2 py-1 text-left">Idée</th>
                <th class="border px-2 py-1 text-left">Commentaire</th>
                <th class="border px-2 py-1 text-left">IP</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr class="odd:bg-white even:bg-gray-50">
                    <td class="border px-2 py-1">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td class="border px-2 py-1">{{ $log->user?->name ?? 'Visiteur' }}</td>
                    <td class="border px-2 py-1">{{ $log->action }}</td>
                    <td class="border px-2 py-1">{{ $log->idea_id ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $log->comment_id ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $log->ip_address ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border px-2 py-3 text-center text-gray-500">
                        Aucun journal trouvé.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $logs->appends(request()->query())->links() }}

</div>

@endsection
