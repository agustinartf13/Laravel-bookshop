@extends('layouts.global')
@section('title')
    Trash Books
@endsection
@section('content')
<div class="row">
        <div class="col-md-6">
            <form action="{{route('categories.index')}}">
                <div class="input-group">
                    <input type="text" class="form-control" name="name" placeholder="Filter by name" value="{{Request::get('name')}}">
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
            <div class="table-responsive">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th><b>Cover</b></th>
                            <th><b>Title</b></th>
                            <th><b>Categories</b></th>
                            <th><b>Stock</b></th>
                            <th><b>Price</b></th>
                            <th><b>Action</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                         <tr>
                            <td>
                            @if ($book->cover)
                            <img src="{{asset('storage/'. $book->cover)}}" alt="" width="96px">
                            @else
                            N/A
                            @endif    
                            </td>
                            <td>{{$book->name}}</td>
                            <td>
                                <ul class="pl-3">
                                    @foreach ($book->categories as $category)
                                        <li>{{$category->name}}</li>
                                    @endforeach
                                </ul>    
                            </td>
                            <td>{{$book->stock}}</td>     
                            <td>{{$book->price}}</td>
                            <td>
                                <a href="{{route('books.restore', ['id' => $book->id])}}" class="btn btn-success">Restore</a>
                            <form class="d-inline" onsubmit="return confirm('delete this book permanently ?')" action="{{route('books.delete-permanent', ['id'=>$book->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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