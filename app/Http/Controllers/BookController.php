<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title=$request->input('title');
        $filter=$request->input('filter','');
        $books=Book::when($title,
        fn($query,$title)=>$query->title($title)
    );
    $books = match ($filter) {
        'populer_last_month' => $books->populerLastMonth(),
        'populer_last_6months' => $books->populerLast6Months(),
        'hight_rate_last_month' => $books->hightRateLastMonth(),
        'hight_rate_last_6months' => $books->hightRateLast6Months(),
        default => $books->latest()->withAvgRate()->withReviewsCount()
    };
      $books = $books->get();

//    $cachekey='books:'. $filter . ":" . $title;
//     $books=cache()->remember($cachekey,3600,fn()=>$books->get());

        return view('books.index',['books'=>$books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {

        $cachekey='book:' . $id;
        $book=cache()->remember(
            $cachekey,
            3600,
            fn()=>
            Book::with([
               'review'=>fn($query)=>$query->latest()
            ])->withAvgRate()->withReviewsCount()->findOrFail($id)
         );
        return view('books.show',['book'=>$book  ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
