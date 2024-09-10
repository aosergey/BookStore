<!-- resources/views/books/show.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Book Details</h1>

    @if ($book)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $book->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">By {{ $book->author }}</h6>
                <p class="card-text">{{ $book->description }}</p>

                <a href="{{ route('books.index') }}" class="btn btn-primary">Back to Books List</a>
            </div>
        </div>
    @else
        <p>Book not found.</p>
    @endif
</div>
</body>
</html>
