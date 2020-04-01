@extends('layouts.global')
@section('footer-scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $('#categories').select2({
            ajax: {
                url:'http://127.0.0.1:8000/ajax/categories/search',
                processResults:function(data){
                    return{
                        results: data.map(function(item){
                            return {
                                id:item.id, text: item.name
                            }
                        })
                    }
                }
            }
        });
    </script>
@endsection
@section('pageTitle')
    Create Book
@endsection
@section('title')
    Create Book
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
            <form class="shadow-sm p-3 bg-white" action="{{route('books.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control {{$errors->first('title') ? "is-invalid" : ""}}" placeholder="book title" value="{{old('title')}}">
                <div class="invalid-feedback">
                    {{$errors->first('title')}}
                </div>
                <br>
                <label for="cover">Cover</label>
                <input type="file" name="cover" id="cover" class="form-control {{$errors->first('cover') ? "is-invalid" : ""}}">
                <div class="invalid-feedback">
                    {{$errors->first('cover')}}
                </div>
                <br>
                <label for="description">Description</label>
                <textarea name="description" id="" rows="6" class="form-control {{$errors->first('description') ? "is-invalid" : ""}}" placeholder="Give a description about this book">{{old('description')}}</textarea>
                <div class="invalid-feedback">
                    {{$errors->first('description')}}
                </div>
                <br>
                <label for="categories">Categories</label>
                <select name="categories[]" multiple id="categories" class="form-control {{$errors->first('categories') ? "is-invalid" : ""}}"> </select> 
                <div class="invalid-feedback">
                    {{$errors->first('categories')}}
                </div>
                <br><br>
                <label for="stock">Stock</label>
                <input type="number" name="stock" min="0" class="form-control {{$errors->first('stock') ? "is-invalid" : ""}}" id="stock" value="{{old('stock')}}">
                <div class="invalid-feedback">
                    {{$errors->first('stock')}}
                </div>
                <br>
                <label for="auhor">Author</label>
                <input type="text" name="author" id="author" class="form-control {{$errors->first('author') ? "is-invalid" : ""}}" placeholder="Book Author" value="">
                <div class="invalid-feedback">
                    {{$errors->first('author')}}
                </div>
                <br>
                <label for="publisher">Publisher</label>
                <input type="text" name="publisher" id="publisher" class="form-control {{$errors->first('publisher') ? "is-invalid" : ""}}" placeholder="Book Publisher">
                <div class="invalid-feedback">
                    {{$errors->first('publisher')}}
                </div>
                <br>
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control {{$errors->first('price') ? "is-invalid" : ""}}" placeholder="book price" min="0">
                <div class="invalid-feedback">
                    {{$errors->first('price')}}
                </div>
                <br>
                <button class="btn btn-primary" name="save_action" type="submit" value="PUBLISH">Publish</button>
                <button class="btn btn-secondary" name="save_action" type="submit" value="DRAFT">Save As Draft</button>
            </form>
        </div>
    </div>
@endsection