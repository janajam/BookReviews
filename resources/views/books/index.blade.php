@extends('layouts.app')
@section('content')
  <h1 class="mb-10 text-2xl">Books</h1>

  
  <form method="GET" action="{{ route('books.index') }}" class="mb-4 flex items-center space-x-2">
    <input type="text" name="title" placeholder="Search by title"
      value="{{ request('title') }}" class="input h-10" />
    <input type="hidden" name="filter" value="{{ request('filter') }}" />
    <button type="submit" class="btn h-10">Search</button>
    <a href="{{ route('books.index') }}" class="btn h-10">Clear</a>
  </form>

  <div class="filter-container mb-4 flex">
    @php
      $filters = [
          '' => 'Latest',
          'populer_last_month' => 'Populer Last Month',
          'populer_last_6months' => 'Populer Last 6 Months',
          'hight_rate_last_month' => 'Hight Rate Last Month',
          'hight_rate_last_6months' => 'Hight Rate Last 6 Months',
      ];
    @endphp

    @foreach ($filters as $key => $label)
      <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}"
        class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}">
        {{ $label }}
      </a>
    @endforeach
  </div>


  <ul>
    @forelse ($books as $book)
      <li class="mb-4">
        <div class="book-item">
            <div class="flex flex-wrap items-center justify-between">
              <div class="w-full flex-grow sm:w-auto">
                <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
               <br>
                <span class="book-auther">by {{ $book->auther }}</span>
              </div>
              <div>
                <div class="book-rating">
                  <x-star-rating :rating="$book->review_avg_rate" />
                </div>
                <div class="book-review-count">
                  out of {{ $book->review_count }} {{ Str::plural('review', $book->review_count) }}
                </div>
              </div>
            </div>
          </div>
        </li>
      @empty
        <li class="mb-4">
            <div class="empty-book-item">
                <p class="empty-text">No books found</p>
                <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
            </div>
        </li>
          @endforelse
     </ul>
      @endsection
  
