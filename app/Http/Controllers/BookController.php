<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\StoreUpdateBookRequest;
use App\Http\Requests\UpdateImageBookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('apiJwt');
        $this->middleware('manageBook')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(4);

        return response()->json(['books' => $books], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateBookRequest $request)
    {
        $data = $request->all();

        $book = Book::create($data);

        return response()->json(['book' => $book], 200);
    }

    public function updateImage(UpdateImageBookRequest $request, $id)
    {
        $book = Book::where('id', $id)->first();

        if(!$book){
            return response()->json(['msg' => 'O livro não existe !'], 400);
        }

        if($request->hasFile('image') && $request->image->isValid()){
            $imagePath = $request->image->store('books');

            Book::where('id', $id)->update(['image' => asset('storage/' . $imagePath)]);

            return response()->json(['msg' => 'Imagem do produto atualizada']);
        }

        return response()->json(['msg' => 'Imagem inválida !']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::where('id', $id)->first();

        if(!$book){
            return response()->json(['msg' => 'O livro não existe !'], 400);
        }

        return response()->json(['book' => $book], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateBookRequest $request, $id)
    {
        $data = $request->all();
        
        $book = Book::where('id', $id)->update($data);

        if(!$book){
            return response()->json(['msg' => 'O livro não existe']);
        }

        return response()->json(['msg' => 'Livro atualizado com sucesso !'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::where('id', $id)->delete();

        if(!$book){
            return response()->json(['msg' => 'O livro não existe !'], 400);
        }

        return response()->json(['msg' => 'O livro foi deletado !'], 200);
    }
}
