
@foreach ($bible->getAllBibleBooks() as $book)
    <option value="{{ $book }}">{{ $book }}</option>
@endforeach

