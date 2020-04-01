@extends('layouts.global')
@section('title')
    Book Detail
@endsection
@section('pageTitle')
    Book Detail
@endsection
@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <label><b>Book Title</b></label>
                <br>
                {{$book->name}}
                <br><br>
                <label><b>Category : </b></label>
                @foreach ($book->categories as $category)
                    <ul>
                    <li>{{$category->name}}</li>
                    </ul>
                @endforeach
                <br>
                <label><b>Cover</b></label>
                <br>
                @if($book->cover)
                <img src="{{asset('storage/'.$book->cover)}}" alt="" width="600px">
                @else
                No image cover
                @endif
                <br><br>
                <label><b>Author</b></label>
                {{$book->author}}
                <br>
                <label><b>Publisher</b></label>
                {{$book->publisher}}
            </div>
        </div>
    </div>
@endsection