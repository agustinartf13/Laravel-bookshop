@extends('layouts.global')
@section('title')
    Book List
@endsection
@section('pageTitle')
    Book List
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{route('books.index')}}">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" value="{{Request::get('keyword')}}" placeholder="Filter by title">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a href="{{route('books.index')}}" class="nav-link {{Request::get('status')==NULL && Request::path() == 'books' ? 'active' : ''}}">All</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('books.index',['status'=>'publish'])}}" class="nav-link {{Request::get('status')=='publish' ? 'active' : ''}}">Publish</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('books.index',['status'=>'draft'])}}" class="nav-link {{Request::get('status')=='draft' ? 'active' : ''}}">Draft</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('books.trash')}}" class="nav-link {{Request::path() == 'books/trash' ? 'active' : ''}}">Trash</a>
                </li>
            </ul>
        </div>
    </div>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
                @if(session('status'))
                <div class="col-md-6">
                    <div class="alert alert-success">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      {{session('status')}}
                    </div>
                  </div>
                @endif
            <div class="row mb-3">
                <div class="col-md-12 text-right"><a href="{{route('books.create')}}" class="btn btn-primary">Create Book</a></div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <td><b>No.</b></td>
                            <td><b>Cover</b></td>
                            <td><b>Title</b></td>    
                            <td><b>Author</b></td>
                            <td><b>Status</b></td>
                            <td><b>Categories</b></td>
                            <td><b>Stock</b></td>
                            <td><b>Price</b></td>
                            <td><b>Action</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($books as $book)
                        <tr>
                        <td>{{$no++}}</td>
                            <td>
                            @if($book->cover)
                            <img src="{{asset('storage/' . $book->cover)}}" width="92px">
                            @else
                            N/A
                            @endif
                            </td>
                            <td>{{$book->title}}</td>
                            <td>{{$book->author}}</td> 
                            <td>
                            @if($book->status == "DRAFT")
                                <span class="badge bg-dark text-white">{{$book->status}}</span>
                            @else
                            <span class="badge badge-success">{{$book->status}}</span>
                            @endif
                            </td>
                            <td>
                            @foreach($book->categories as $category)
                                <ul>
                                <li>{{$category->name}}</li>    
                                </ul>
                            @endforeach        
                            </td>
                            <td>{{$book->stock}}</td>
                            <td>{{$book->price}}</td>
                            <td>
                            <a href="{{route('books.edit',['id'=>$book->id])}}" class="btn btn-info btn-sm">Edit</a>
                            <a href="{{route('books.show',['id'=>$book->id])}}" class="btn btn-primary btn-sm">Detail</a>
                            <form action="{{route('books.destroy',['id'=>$book->id])}}" class="d-inline" method="POST" onsubmit="return confirm('Move book to trash')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Trash</button>
                            </form>
                            </td>
                        </tr> 
                        @endforeach
                    </tbody>
                </table>
                {{$books->appends(Request::all())->links()}}
            </div>
        </div>
    </div>
@endsection