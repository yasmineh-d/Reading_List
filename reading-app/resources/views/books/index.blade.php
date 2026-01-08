@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">📚 Liste des livres</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
@foreach ($books as $book)
    <div class="bg-white shadow rounded-lg p-4">

        <h3 class="text-lg font-semibold mb-2">
            {{ $book->title }}
        </h3>

        <p class="text-sm text-gray-600">
            {{ $book->author }}
        </p>

        <p class="text-xs mt-2 text-gray-500">
            Catégorie : {{ $book->category->name ?? '—' }}
        </p>

        <a href="/books/{{ $book->id }}"
           class="mt-4 inline-flex items-center text-blue-600 hover:underline">
            Voir détails
        </a>
    </div>
@endforeach
</div>
@endsection
