@extends('layouts.global')
@section('title')
    Edit Order
@endsection
@section('pageTitle')
    Edit Order
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            @if (session('status'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{session('status')}}
            </div>
            @endif
            <form action="{{route('orders.update',['id'=>$order->id])}}" method="POST" class="shadow-sm bg-white p-3">
                @csrf
                @method('PUT')
                <label for="invoice_number">Invoice number</label>
                <br>
                <input type="text" class="form-control" value="{{$order->invoice_number}}" disabled>
                <br>
                <label for="">Buyer</label>
                <br>
                <input type="text" disabled class="form-control" value="{{$order->user->name}}">
                <br>
                <label for="created_at">Order date</label>
                <br>
                <input type="text" class="form-control" value="{{$order->created_at}}" disabled >
                <br>
                <label for="">Total Books = {{$order->totalQuantity}}</label>
                <br>
                <ul>
                    @foreach ($order->books as $book)
                    <li>{{$book->title}} = {{$book->pivot->quantity}}</li>
                    @endforeach
                </ul>
                <br>
                <label for="">Total price</label>
                <br>
                <input type="text" value="{{$order->total_price}}" class="form-control" disabled>
                <br>
                <label for="">Status</label>
                <br>
                <select name="status" class="form-control">
                    <option {{$order->status == "SUBMIT" ? "selected" : ""}} value="SUBMIT">SUBMIT</option>
                    <option {{$order->status == "PROCESS" ? "selected" : "" }}value="PROCESS">PROCESS</option>
                    <option {{$order->status == "FINISH" ? "selected" : ""}}value="FINISH">FINISH</option>
                    <option {{$order->status == "CANCEL" ? "selected" : ""}}value="CANCEL">CANCEL</option>
                </select>
                <br>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection