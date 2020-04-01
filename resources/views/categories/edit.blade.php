@extends('layouts.global') 
@section('title') Edit Category
@endsection
 
@section('pageTitle') Edit Category
@endsection
 
@section('content')
<div class="col-md-8">
  @if(session('status'))
  <div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{session('status')}}
  </div>
  @endif
  <form class="" action="{{route('categories.update', ['id'=> $category->id])}}" method="POST" class="bg-white shadow-sm p-3"
    enctype="multipart/form-data">
    @csrf @method('PUT')
    <label for="">Category Name</label>
    <input class="form-control {{$errors->first('name') ? " is-invalid " : " " }}" type="text" name="name" value="{{old('name') ? old('name') : $category->name}}">
    <div class="invalid-feedback">
      {{$errors->first('name')}}
    </div>
    <br>
    <br> @if($category->image)
    <span>Current image</span>
    <br>
    <img src="{{asset('storage/'.$category->image)}}" width="120px">
    <br><br> @else No Image @endif
    <input type="file" name="image" class="form-control {{$errors->first('image') ? " is-invalid " : " " }}">
    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
    <div class="invalid-feedback">
      {{$errors->first('image')}}
    </div>
    <br>
    <br>
    <button type="submit" name="submit" class="btn btn-primary">Update</button>
    <button type="button" name="button" class="btn btn-default" onclick="window.location.href='{{route('categories.index')}}'">Batal</button>
  </form>
</div>
@endsection