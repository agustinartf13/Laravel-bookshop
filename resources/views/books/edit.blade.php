@extends('layouts.global')
@section('title')
    Book List
@endsection
@section('pageTitle')
    Edit Book
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
                @if(session('status'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{session('status')}}
                </div>
                @endif 
            <form action="{{route('books.update', ['id'=>$book->id])}}" class="p-3 shadow-sm bg-white" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
                <label for="title">Title</label>
                <input type="text" class="form-control {{$errors->first('title') ? "is-invalid" : ""}}" name="title" id="title" value="{{old('title') ? old('title') : $book->title}}" placeholder="Book Title">
                <div class="invalid-feedback">
                    {{$errors->first('title')}}
                </div>
                <br>
                <small class="text-muted">Current cover</small><br>
                @if($book->cover)
                <img src="{{asset('storage/'. $book->cover)}}" alt="" width="96px">
                @endif
                <br><br>
                <input type="file" name="cover" class="form-control {{$errors->first('cover') ? "is-invalid" : ""}}">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah cover</small>
                <div class="invalid-feedback">
                    {{$errors->first('cover')}}
                </div>
                <br><br>
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="6" class="form-control {{$errors->first('description') ? "is-invalid" : ""}}">{{old('description') ? old('description') : $book->description}}</textarea>
                <div class="invalid-feedback">
                    {{$errors->first('description')}}
                </div>
                <br>
                <label for="categories">Categories</label>
                <select name="categories[]" id="categories" multiple class="form-control {{$errors->first('categories') ? "is-invalid" : ""}}"></select>
                <div class="invalid-feedback">
                    {{$errors->first('categories')}}
                </div>
                <br>
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" min="0" value="{{old('stock') ? old('stock') : $book->stock}}" class="form-control {{$errors->first('stock') ? "is-invalid" : ""}}">
                <div class="invalid-feedback">
                    {{$errors->first('stock')}}
                </div>
                <br>
                <label for="author">Author</label>
                <input type="text" name="author" id="author" value="{{$book->author}}" placeholder="book author" class="form-control {{$errors->first('author') ? "is-invalid" : ""}}">
                <div class="invalid-feedback">
                    {{$errors->first('author')}}
                </div>
                <br>
                <label for="publisher">Publisher</label>
                <input type="text" name="publisher" id="publisher" value="{{old('publisher') ? old('publisher') : $book->publisher}}" placeholder="book publisher" class="form-control {{$errors->first('publisher') ? "is-invalid" : ""}}">
                <div class="invalid-feedback">
                    {{$errors->first('publisher')}}
                </div>
                <br>
                <label for="price">Price</label>
                <input type="number" min="0" class="form-control {{$errors->first('price') ? "is-invalid" : ""}}" name="price" placeholder="Price" id="price" value="{{old('price') ? old('price') : $book->price}}">
                <div class="invalid-feedback">
                    {{$errors->first('price')}}
                </div>
                <br>
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option {{$book->status == 'PUBLISH' ? 'selected' : ''}} value="PUBLISH">PUBLISH</option>
                    <option {{$book->status == 'DRAFT' ? 'selected' : ''}} value="DRAFT">DRAFT</option>
                </select>
                <br>
                <button type="submit" class="btn btn-primary" name="submit">Update</button>
                <button type="button" class="btn btn-default" onclick="window.location.href='{{route('books.index')}}'">Batal</button>
            </form>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> 
    <script>
    $('#categories').select2({
        ajax: {
            url: 'http://127.0.0.1:8000/ajax/categories/search',
            processResults: function(data){
                return{
                    results: data.map(function(item){return{id: item.id, text:
                    item.name} })
                }
            }
        }
    });

    var categories = {!! $book->categories !!}

    categories.forEach(function(category){
        var option = new Option(category.name, category.id, true, true);
        $('#categories').append(option).trigger('change');
    });
    </script>
@endsection