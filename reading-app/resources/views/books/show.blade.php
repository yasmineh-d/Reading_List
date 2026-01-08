@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-xl mx-auto">

<h2 class="text-2xl font-bold mb-4">{{ $book->title }}</h2>

<p><strong>Auteur :</strong> {{ $book->author }}</p>
<p><strong>Date :</strong> {{ $book->publication_date }}</p>
<p><strong>ISBN :</strong> {{ $book->ISBN }}</p>
<p class="mt-3 text-gray-700">{{ $book->description }}</p>

<a href="/books"
   class="mt-6 inline-flex items-center gap-2 text-blue-600 hover:underline">
    <i data-lucide="arrow-left"></i> Retour
</a>

</div>

<script>
    lucide.createIcons();
</script>
@endsection
