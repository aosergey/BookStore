<?php
namespace App\Services;
use App\Models\Book;
use App\Models\Picture;
use Illuminate\Http\Request;

class BookService{

    public function getAllBooks()
    {
        $books = Book::with('picture')->get();
        return $books;
    }

    public function getUserBooks($id)
    {
        return Book::with('picture')->where('userId', $id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveBook($validatedData)
    {
        $pictureId = 0;
        if (isset($validatedData['picture'])) {
            $picture = $validatedData['picture'];
            $pictureName = $picture->getClientOriginalName();
            $picturePath = $picture->store('picture', 'public');
            $newPicture = Picture::create([
                'name' => $pictureName,
                'path' => $picturePath
            ]);

            $pictureId = $newPicture->id;
        }
        $validatedData['pictureId'] = $pictureId;
        Book::create($validatedData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBook($validatedData, $id)
    {
        $book = Book::findOrFail($id);

        if (isset($validatedData['picture'])) {
            $picture = $validatedData['picture'];
            $oldPicture = Picture::findOrFail($book->pictureId);

            $pictureName = $picture->getClientOriginalName();
            $picturePath = $picture->store('picture', 'public');
            $oldPicture ->update([
                'name' => $pictureName,
                'path' => $picturePath
            ]);
        }

        $book->update($validatedData);
    }

    public function findById($id)
    {
        $book = Book::findOrFail($id);
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove($id)
    {
        $book = Book::findOrFail($id);
        $picture = Picture::findOrFail($book->pictureId);
        $book->delete();
        $picture->delete();
    }
}
