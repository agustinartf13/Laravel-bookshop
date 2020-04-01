@extends("layouts.global")
@section("title") Edit User
@endsection

@section("content")
<div class="col-md-8">
    @if(session('status'))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{session('status')}}
    </div>
    @endif
    <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action=" {{route('users.update', ['id'=>$user->id])}}"
        method="POST">
        @csrf @method('PUT')
        <label for="name">Name</label>
        <input value="{{old('name') ? old('name') : $user->name}}" class="form-control
            {{$errors->first('name') ? " is-invalid " : " " }}" type="text" name="name" id="name" />
        <div class="invalid-feedback">
            {{$errors->first('name')}}
        </div>
        <br>
        <label for="">Status</label>
        <br>
        <input {{$user->status == "ACTIVE" ? "checked" : ""}} value="ACTIVE" type="radio" class="form-control" id="active"name="status">
        <label for="active">Active</label>

        <input {{$user->status == "INACTIVE" ? "checked" : ""}} value="INACTIVE" type="radio" class="form-control" id="inactive"name="status">
        <label for="inactive">Inactive</label>
        <br>
        <br>
        
        <label for="">Roles</label>
        <br>
        <input type="checkbox" {{in_array( "ADMIN", json_decode($user->roles)) ? "checked" : ""}} class="form-control {{$errors->first('roles')
        ? "is-invalid" : "" }}" name="roles[]" id="ADMIN" value="ADMIN">
        <label for="ADMIN">Administrator</label>

        <input type="checkbox" {{in_array( "STAFF", json_decode($user->roles)) ? "checked" : ""}} class="form-control {{$errors->first('roles')
        ? "is-invalid" : "" }}" name="roles[]" id="STAFF" value="STAFF">
        <label for="STAFF">Staff</label>

        <input type="checkbox" {{in_array( "CUSTOMER", json_decode($user->roles)) ? "checked" : ""}} class="form-control
        {{$errors->first('roles') ? "is-invalid" : "" }}" name="roles[]" id="CUSTOMER" value="CUSTOMER">
        <label for="CUSTOMER">Customer</label>
        <div class="invalid-feedback">
            {{$errors->first('roles')}}
        </div>

        <br>
        <label for="phone">Phone Number</label>
        <input type="text" name="phone" value="{{old('phone') ? old('phone') : $user->phone}}" class="form-control {{$errors->first('phone') ? "
            is-invalid " : " " }}" id="phone">
        <div class="invalid-feedback">
            {{$errors->first('phone')}}
        </div>

        <br>
        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control {{$errors->first('address') ? " is-invalid " : " " }}">{{old('address') ? old('address') : $user->address}}</textarea>
        <div class="invalid-feedback">
            {{$errors->first('address')}}
        </div>

        <br>
        <label for="avatar">Avatar image</label>
        <br> Current avatar:
            <br> @if($user->avatar)
                <img src="{{asset('storage/'.$user->avatar)}}" width="120px" />
            <br> @else No avatar @endif
            <br>
        <input id="avatar" name="avatar" type="file" class="form-control {{$errors->first('avatar') ? " is-invalid " : " " }}">
        <div class="invalid-feedback">
            {{$errors->first('avatar')}}
        </div>
        <small class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>

        <hr class="my-3">

        <button type="submit" name="submit" class="btn btn-primary">Save</button>
        <button type="button" name="button" class="btn btn-default" onclick="window.location.href='{{route('users.index')}}'">Lihat Daftar</button>
    </form>
</div>
@endsection
