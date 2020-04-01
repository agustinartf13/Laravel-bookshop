<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Validation\Rule;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter_keyword = $request->get('name');
        $categories =Category::paginate(8);
        if($filter_keyword)
        {
          $categories = Category::where('name','LIKE',"%$filter_keyword%")->paginate(2);
        }
        return view('categories.index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        //ambil value name
        $name = $request->get('name');
        $new_category = new Category;
        $new_category->name = $name;

        //cek apakah image di upload
        if($request->file('image'))
        {
          $image_path = $request->file('image')->store('category_images','public');
          $new_category->image = $image_path;
        }
        $new_category->created_by = \Auth::user()->id;
        $new_category->slug = str_slug($name, '-');
        $new_category->save();

        return redirect()->route('categories.create')->with('status', 'Category successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $category_show = Category::findOrFail($id);
      return view('categories.show',['category'=> $category_show]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_edit = Category::findOrFail($id);
        
        return view('categories.edit',['category'=> $category_edit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $rules = [
            "name" => ["required", Rule::unique('categories')->ignore($category->name, "name")],
            "image" => "mimes:jpg,png|max:4096"
        ];
        $messages = [
            "name.required" => "nama kategori tidak boleh kosong",
            "name.unique" => "nama kategori sudah ada",
            "image.mimes" => "format file yang diijinkan adalah JPG/PNG",
            "image.max" => "maximum size file sebesar 4 MB"
        ];
        $this->validate($request, $rules, $messages);
        $name = $request->get('name');
        $slug = str_slug('name', '-');
        
        $category->name = $name;
        $category->slug = $slug;

        if($request->file('image'))
        {
          if($category->image && file_exists(storage_path('app/public/'.$category->image)))
          {
            \Storage::delete('public/'. $category->image);
          }
          $new_image = $request->file('image')->store('category_images','public');
          $category->image = $new_image;
        }
        $category->updated_by = \Auth::user()->id;
        $category->slug = str_slug($name);
        $category->save();

        return redirect()->route('categories.edit',['id'=>$id])->with('status','Category successfully edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrfail($id);

        $category->delete();

        return redirect()->route('categories.index')->with('status','Category succesfully moved to trash');
    }

    public function trash()
    {
        //ambil data category yang terhapus
        $deleted_category = Category::onlyTrashed()->paginate(10);

        return view('categories.trash',['categories'=> $deleted_category]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id); 
 
        if($category->trashed())
        {
            $category->restore();
        }
        else
        {
            return redirect()->route('categories.index')->with('status', 'Category is not in trash');
        } 
        return redirect()->route('categories.index')   ->with('status', 'Category successfully restored');
    }

    public function deletePermanent($id)
    {
        $deleted_category = Category::withTrashed()->findOrfail($id);
        //jika kategori yg diminta ada di trash
        if($deleted_category->trashed())
        {
            //jika categori memiliki gambar
            if($deleted_category->image)
            {
                \Storage::delete('public/'. $deleted_category->image);
                $deleted_category->forceDelete();  
            }
            else 
            {
                $deleted_category->forceDelete();
            }
            return redirect()->route('categories.index')->with('status','Category removed permanently');          
        }
        else
        {
            return redirect()->route('categories.index')->with('status', 'Category is not int trash')->with('status_type','alert');
        }
    }

    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');
        $categories = Category::where("name", "LIKE","%$keyword%")->get();
        // $categories = Category::all();

        return $categories;
    }
}
