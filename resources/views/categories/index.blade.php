@extends('layouts.global')
@section('title') Category List
@endsection

@section('pageTitle') Category List
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
                <a href="{{route('categories.index')}}" class="nav-link active">Published</a>
            </li>
            <li class="nav-item">
                <a href="{{route('categories.trash')}}" class="nav-link">Trash</a>
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
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{session('status')}}
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="{{route('categories.create')}}" class="btn btn-primary">Create category</a>
            </div>
        </div>
        <br>
        <div class=" table-responsive">
            <table class="table table-bordered table-stripped">
                <thead>
                    <tr>
                        <th><b>Name</b></th>
                        <th><b>Slug</b></th>
                        <th><b>Image</b></th>
                        <th><b>Actions</b></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td>
                            @if($category->image)
                            <img src="{{asset('storage/'. $category->image)}}" width="48px"> @else N/A @endif
                        </td>
                        <td>
                            <a href="{{route('categories.edit',['id'=>$category->id])}}" class="btn btn-info btn-sm">Edit</a>
                            <a href="{{route('categories.show',['id'=>$category->id])}}" class="btn btn-primary btn-sm">Detail</a>
                            <form action="{{ route('categories.destroy', ['id'=>$category->id]) }}" class="d-inline" method="POST" onsubmit="return confirm('Move category to trash ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Trash</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <!-- <tfoot>
            <tr>
              <td colspan="10">

              </td>
            </tr>
          </tfoot> -->
            </table>
            {{$categories->appends(Request::all())->links()}}
        </div>
    </div>
</div>
@endsection
