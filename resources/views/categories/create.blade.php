@extends('layouts.global')
@section('title') Create Category @endsection
@section('pageTitle')
    Create New Category
@endsection
@section('content')
  <div class="col-md-8">
    @if(session('status'))
    <div class="alert alert-success">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {{session('status')}}
    </div>
    @endif
    <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{route('categories.store')}}" method="post">
      @csrf
      <label for="">Category Name</label>
      <input type="text" name="name" class="form-control {{$errors->first('name') ? "is-invalid" : ""}}" value="{{old('name')}}">
      <div class="invalid-feedback">
        {{$errors->first('name')}}
      </div>
      <br>
      <label for="">Category Image</label>
      <input type="file" name="image" class="form-control {{$errors->first('image') ? "is-invalid" : ""}}">
      <div class="invalid-feedback">
        {{$errors->first('image')}}
      </div>
      <br>
      <button type="submit" name="submit" class="btn btn-primary">Save</button>
    </form>
  </div>
@endsection
