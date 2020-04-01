@extends('layouts.global')
@section('title')
    Trashed Categories
@endsection
@section('pageTitle')
    Category Trashed
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{route('categories.index')}}">
            <div class="input-group">
                <input type="text" name="name" value="{{Request::get('name')}}" placeholder="Filter by category name" class="form-control">
                <div class="input-group-append">
                    <button class="btn btn-primary">Filter</button>
                </div>   
            </div>
            </form>
        </div>
        <div class="col-md-6">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link" href=" {{route('categories.index')}}">Published</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href=" {{route('categories.trash')}}">Trash</a>
                </li>
            </ul>
        </div> 
    </div>
    <hr class="my-3"> 

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td>
                            @if($category->image)
                            <img src="{{asset('storage/'.$category->image)}}" width="48px">
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{route('categories.restore', ['id' => $category->id])}}" class="btn btn-success btn-sm">Restore</a>
                            <form action="{{route('categories.delete-permanent',['id'=>$category->id])}}" class="d-inline"
                                onsubmit="return confirm('Delete this permanently ?')" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanent</button>
                            </form>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$categories->appends(Request::all())->links()}}
            </div>
        </div>
    </div>
@endsection