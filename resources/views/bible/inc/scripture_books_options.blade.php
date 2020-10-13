
@foreach ($bible->getAllBibleBooks() as $book)
    <option value="none" selected hidden>Book</option>
    <option value="{{ $book }}">{{ $book }}</option>
@endforeach

