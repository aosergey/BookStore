<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Logger;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = $this->getUser();
        $books = $this->bookService->getUserBooks($userId);
        return view('getBook', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createBook');
    }


    private function getUser(){
        $token = session("jwt_token");
        $jwtParts = explode('.', $token);
        $payload = base64_decode($jwtParts[1]);
        $payload = json_decode($payload, true);
        return $payload['sub'];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'picture' => 'nullable|mimes:jpeg,png,jpg'
        ]);

        $userId = $this->getUser();
        $validatedData['userId'] = $userId;
        $this->bookService->saveBook($validatedData);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'picture' => 'nullable|mimes:jpeg,png,jpg'
        ]);

        $this->bookService->updateBook($validatedData, $id);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = $this->bookService->findById($id);
        return view('bookById', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = $this->bookService->findById($id);
        return view('editBook', compact('book'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->bookService->remove($id);
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

}
