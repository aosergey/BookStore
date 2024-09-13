<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4" style="color: red">Books List</h1>

    <!-- Buttons for Dashboard and Logout -->
    <div class="mb-3">
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
        <a href="{{ route('logout') }}" class="btn btn-secondary btn-sm">Logout</a>
    </div>

    <!-- Search Form and Sort Filter -->
    <form action="{{ route('books.index') }}" method="GET" class="mb-3">
        <div class="row">
            <!-- Search input -->
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by title" value="{{ request()->get('search') }}">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
            </div>

            <!-- Sort filter -->
            <div class="col-md-6">
                <div class="input-group">
                    <label class="input-group-text" for="sort">Sort by:</label>
                    <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Select</option>
                        <option value="author_asc" {{ request()->get('sort') == 'author_asc' ? 'selected' : '' }}>Author (A-Z)</option>
                        <option value="author_desc" {{ request()->get('sort') == 'author_desc' ? 'selected' : '' }}>Author (Z-A)</option>
                        <option value="title_asc" {{ request()->get('sort') == 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                        <option value="title_desc" {{ request()->get('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                    </select>
                </div>
            </div>
        </div>
    </form>


    <a href="{{ route('books.create') }}" class="btn btn-warning btn-sm mb-3">Add a book</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($books->isEmpty())
        <p>No books available.</p>
    @else
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Author</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    @if($book->picture)
                        <td><img src="{{ asset($book->picture->path) }}" alt="Image" style="height: 100px; width: auto"></td>
                    @else
                        <td>No Image</td>
                    @endif
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->description }}</td>
                    <td>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>
