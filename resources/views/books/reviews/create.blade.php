@extends('layouts.app')
@section('content')
<h1 class="mt-10 text-2x1">Add Review for {{ $book->title}}</h1>
<form method ="POST" action="{{ route('books.review.store',$book) }}">
@csrf
<label for="review">Review</label>
<textarea name="review" id="review" required class="input mb-4"></textarea>
<label for="rate">Rating</label>
<select name="rate" id="rate" class="input mb-4" required>
    <option value="">select a Rating</option>
    @for ($i=1;$i<=5;$i++)
        <option value="{{ $i }}">{{ $i }}</option>
    @endfor
</select>
<button type="submit" class="btn">Add Review</button>
</form>
@endsection
