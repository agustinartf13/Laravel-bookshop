@extends("layouts.global")
@section("title") Users list
@endsection

@section("content")

<h2>Daftar User</h2>
<form action="{{route('users.index')}}">
	<div class="row">
		<div class="col-md-6">
			<input name="keyword" class="form-control col-md-10" type="text" placeholder="Filter berdasarkan email" />
		</div>
		<div class="col-md-6">
			<input {{Request::get( 'status')=='ACTIVE' ? 'checked' : ''}} value="ACTIVE" name="status" type="radio" class="form-control"
				id="active">
			<label for="active">Active</label>

			<input {{Request::get( 'status')=='INACTIVE' ? 'checked' : ''}} value="INACTIVE" name="status" type="radio" class="form-control"
				id="inactive">
			<label for="inactive">Inactive</label>
			<button type="submit" class="btn btn-primary">Filter</button>
		</div>
	</div>
</form>
<div class="row">
	<div class="col-md-12 text-right">
		<a href="{{route('users.create')}}" class="btn btn-primary">Create user</a>
	</div>
</div>
<br> @if(session('status'))
<div class="alert alert-success">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{session('status')}}
</div>
@endif
<br>
<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th><b>Name</b></th>
				<th><b>Username</b></th>
				<th><b>Email</b></th>
				<th><b>Phone Number</b></th>
				<th><b>Avatar</b></th>
				<th><b>Status</b></th>
				<th><b>Action</b></th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{$user->name}}</td>
				<td>{{$user->username}}</td>
				<td>{{$user->email}}</td>
				<td>{{$user->phone}}</td>
				<td>
					@if($user->avatar)
					<img src="{{asset('storage/'.$user->avatar)}}" width="70px"> @else N/A @endif
				</td>
				<td>
					@if($user->status=="ACTIVE")
					<span class="badge badge-success">{{$user->status}}</span> @else
					<span class="badge badge-danger">{{$user->status}}</span> @endif
				</td>
				<td>
					<a href="{{route('users.edit', ['id'=>$user->id])}}" class="btn btn-info text-white btn-sm">Edit</a>
					<form onsubmit="return confirm('Delete this user permanently?')" class="d-inline" action="{{route('users.destroy',['id' =>$user->id])}}"
						method="POST">
						@csrf @method('DELETE')
						<button type="submit" class="btn btn-danger btn-sm" name="delete">Delete</button>
					</form>
					<a href="{{route('users.show', ['id'=>$user->id])}}" class="btn btn-primary text-white btn-sm">Detail</a>
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td colspan="10">
					{{$users->appends(Request::all())->links()}}
				</td>
			</tr>
		</tfoot>
	</table>
</div>
@endsection
