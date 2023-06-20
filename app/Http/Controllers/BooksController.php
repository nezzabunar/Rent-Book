<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    // public function index(Request $request) {
    //     // $request->session()->flush();
    //     return view('list-data-buku');
    // }

    public function index(Request $request)
    {
        $data = Books::all();
        if ($request->ajax()) {
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    if(Auth::user()->role_id == 1){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                        $button .= '   <button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                        return $button;
                    }
                    })
                    // ->rawColumns(['action'])
                    ->make(true);
            }
        return view('list-data-buku');
    }

    public function GetDataBook () {
        $data = Books::all();
        return response()->json([
            'books' => $data
        ],200);
    }

    public function GetDataBookUser () {
        $data = Books::all();
        // return response()->json([
        //     'books' => $data
        // ],200);
        return view('list-buku', compact('data'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'judul_buku'=>  'required',
            'stok_buku'=>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'kode_buku'=>  $request->kode_buku,
            'judul_buku'=>  $request->judul_buku,
            'tahun_terbit'=>  $request->tahun_terbit,
            'penulis'=>  $request->penulis,
            'stok_buku'=>  $request->stok_buku,
        );

        Books::create($form_data);

        return response()->json(['status' => 200 ,'success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        $data = Books::findOrFail($id);
        return response()->json(['result' => $data]);

        if(request()->ajax())
        {
            $data = Books::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = array(
            'judul_buku'=>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'kode_buku'=>  $request->kode_buku,
            'judul_buku'=>  $request->judul_buku,
            'tahun_terbit'=>  $request->tahun_terbit,
            'penulis'=>  $request->penulis,
            'tahun_terbit'=>  $request->tahun_terbit,
            'stok_buku'=>  $request->stok_buku,
        );

        Books::whereId($request->id)->update($form_data);

        return response()->json(['status' => 200 ,'success' => 'Data is successfully update']);
    }

    public function destroy($id)
    {
        $data = Books::findOrFail($id);
        $data->delete();
        return response()->json(['status' => 200 ,'success' => 'Data is successfully delete']);
    }

    public function updateBooks(Request $request, $id)
    {
        $data = Books::findOrFail($id);
        $data->update($request->all());
        return response()->json(['status' => 200 ,'success' => 'Data is successfully Update']);
    }

}
