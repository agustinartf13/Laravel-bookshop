<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Requests\CreateBookRequest;
use Illuminate\Validation\Rule;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = Book::paginate(10);
        $status = $request->get('status');
        $keyword = $request->get('keyword');

        if($keyword)
        {
            $books = Book::with('categories')->where('name' ,'LIKE', "%$keyword%")->paginate(10);
        }
        else if($status)
        {
            if($keyword)
            {
                $books = Book::with('categories')->where('name' ,'LIKE', "%$keyword%")->where('status', strtoupper($status))->paginate(10);
            }
            else
            {
                $books = Book::with('categories')->where('status', strtoupper($status))->paginate(10); 
            }
        }
        return view('books.index', ['books'=> $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBookRequest $request)
    {
        $new_book = new Book;
        $new_book->title = $request->get('title');
        $new_book->description = $request->get('description');
        $new_book->author = $request->get('author');
        $new_book->publisher = $request->get('publisher');
        $new_book->price = $request->get('price');
        $new_book->stock = $request->get('stock');
        $new_book->status = $request->get('save_action'); 

        $cover = $request->file('cover');
        if($cover)
        {
            $cover_path = $cover->store('book-covers','public');
            $new_book->cover = $cover_path;
        }
        $new_book->slug = str_slug($request->get('title'), '-');

        $new_book->created_by = \Auth::user()->id;

        $new_book->save();
        $new_book->categories()->attach($request->get('categories')); 
        if($request->get('save_action') == 'PUBLISH')
        {
            return redirect()->route('books.create')->with('status', 'Book successfully saved and published');
        } 
        else
        {
            return redirect()->route('books.create')->with('status', 'Book saved as draft');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book_show = Book::findOrfail($id);

        return view('books.show',['book'=>$book_show]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrfail($id);

        return view('books.edit', ['book'=>$book]);
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
        $book = Book::findOrfail($id);

        $rules = [
            "title"  => ['required', Rule::unique('books')->ignore($book->title, 'title')],
            "cover" => "image",
            "description" => "required|min:20|max:500",
            "categories" => "required",
            "stock" => "required|numeric|min:0",
            "author" => "required",
            "publisher" => "required",
            "price" => "required|numeric|min:0"
        ];

        $messages = [
            "title.required" => "judul tidak boleh kosong",
            "title.unique" => "judul sudah ada",
            "cover.image" => "file harus berupa gambar",
            "description.required" => "deskripsi tidak boleh kosong",
            "description.min" => "deskripsi minimal 20 karakter",
            "description.max" => "deskripsi maksimal 500 karakter",
            "categories.required" => "kategori tidak boleh kosong",
            "stock.required" => "stok tidak boleh kosong",
            "stock.numeric" => "stok harus angka",
            "stock.min" => "stok minimal 0",
            "author.required" => "author tidak boleh kosong",
            "publisher.required" => "publisher tidak boleh kosong",
            "price.required" => "harga tidak boleh kosong",
            "price.numeric" => "harga harus angka",
            "price.min" => "harga minimal 0"
        ];

        $this->validate($request, $rules, $messages);

        $book->title = $request->get('title');
        $book->slug = str_slug($request->get('title'),'-');
        $book->description = $request->get('description');
        $book->author = $request->get('author');
        $book->publisher = $request->get('publisher');
        $book->stock = $request->get('stock');
        $book->price = $request->get('price');

        $new_cover = $request->file('cover');

        if($new_cover)
        {
            if($book->cover && file_exists(storage_path('app/public' . $book->cover)))
            {
                \Storage::delete('public', $book->cover);
            }
            $new_book_path = $new_cover->store('book-covers', 'public');
            $book->cover = $new_book_path;
        }

        $book->updated_by = \Auth::user()->id;
        $book->status = $request->get('status');
        $book->save();

        $book->categories()->sync($request->get('categories'));
        return redirect()->route('books.edit', ['id'=>$book->id])->with('status', 'Book successfully updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrfail($id);
        $book->delete();

        return redirect()->route('books.index')->with('status','Book moved to trash');
    }

    public function trash()
    {
        $books = Book::onlyTrashed()->paginate(10);

        return view('books.trash', ['books'=>$books]);
    }

    public function restore($id)
    {
        $book = Book::withTrashed()->findOrfail($id);

        if($book)
        {
            $book->restore();
            return redirect()->route('books.trash')->with('status','Book Succesfully restored');
        }
        else
        {
            return redirect()->route('books.trash')->with('status','Book is not in trash');
        }
    }

    public function deletePermanent($id)
    {
        $book = Book::withTrashed()->findOrfail($id);
 
        if($book->trashed())
        {
            if($book->cover)
            {
                \Storage::delete('public/'. $book->cover);
                $book->categories()->detach();
                $book->forceDelete();  
            }
            else 
            {
                $book->categories()->detach();
                $book->forceDelete();
            }
            return redirect()->route('books.trash')->with('status', 'Book permanently deleted!');   
            
        }
        else
        {
            return redirect()->route('books.trash')->with('status', 'Book is not in trash!')->with('status_type', 'alert');
        } 
    }
}
