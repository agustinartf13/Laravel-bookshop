<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::paginate(10);
        //ambil value dari request
        $filter_keyword = $request->get('keyword');
        $status = $request->get('status');

        if($filter_keyword && $status)
        {
          $users = User::where('email','LIKE',"%$filter_keyword%")
          ->where('status', $status)->paginate(10);
        }
          else if($status)
          {
            $users = User::where('status',$status)
            ->paginate(10);
          }
          else
          {
            $users = User::where('email','LIKE',"%$filter_keyword%")->paginate(10);
          }
          //berlaku jika kondisi hanya satu tapi diatas kondisinya dua :v
          //$users->appends(['keyword' => $filter_keyword]);
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     *@return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
      $new_user = new User;
      $new_user->name = $request->get('name');
      $new_user->username = $request->get('username');
      $new_user->roles = json_encode($request->get('roles'));
      $new_user->address = $request->get('address');
      $new_user->phone = $request->get('phone');
      $new_user->email = $request->get('email');
      $new_user->status = "ACTIVE";
      $new_user->password = \Hash::make($request->get('password'));

      //cek gambar diupload
      if ($request->file('avatar')) {
        /*jika up masuk ke direktori yg dibuat(param 1 store) jika direktori belum ada
         akan auto dibuat*/
        $file = $request->file('avatar')->store('avatars','public');
        $new_user->avatar = $file;
      }
      $new_user->save();

      return redirect()->route('users.create')->with('status', 'User successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $user = User::findOrFail($id);
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = User::findOrFail($id);

      return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->get('name');
        $user->roles = json_encode($request->get('roles'));
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->status = $request->get('status');

        //file handling
        if($request->file('avatar'))
        {
          //jika gambar awal ada & direktori di public, hapus gambar awal
          if($user->avatar && file_exists(storage_path('app/public/' . $user->avatar)))
          {
            \Storage::delete('public/'.$user->avatar);
          }
          $file = $request->file('avatar')->store('avatars', 'public');
          $user->avatar = $file;
        }
        $user->save();
        return redirect()->route('users.edit', ['id'=>$id])->with('status', 'User succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_user = User::findOrFail($id);

        if($delete_user->avatar)
        {
          \Storage::delete('public/'.$delete_user->avatar);
          $delete_user->delete();
        }
        else
        {
          $delete_user->delete();
        }
        return redirect()->route('users.index')->with('status','User succesfully Deleted');
    }
}