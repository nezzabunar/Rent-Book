<?php

namespace App\Http\Controllers;

use Validator;
use DataTables;
use App\Models\User;
use App\Models\Books;
use App\Models\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Peminjam::with('buku')->with('user')->get();

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    if(Auth::user()->role_id == 1){
                        // $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="fa fa-pencil-square"></i>Edit</button>';
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="fa fa-backspace-reverse-fill"></i> Delete</button>';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="approve btn btn-success btn-sm"> <i class="fa fa-backspace-reverse-fill"></i> Approve</button>';
                        return $button;
                    }
                    })
                    // ->rawColumns(['action'])
                    ->make(true);
            }
            $list_users = User::all();
            $list_books = Books::all();
            return view('list-peminjam', compact('list_books','list_users'));
    }

    public function getDataPeminjaman(){
            $id = Auth::user()->id;
            $data = Peminjam::with('buku')->where('user_id', $id)->get();
            $list_users = User::all();
            $list_books = Books::all();
            return view('list-peminjaman', compact('data','list_books','list_users'));
    }

    public function store(Request $request)
    {

        $user_id = Auth::user()->id;
        $rules = array(
            'status'=>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'buku_id'=>  $request->buku_id,
            'user_id'=>  $user_id,
            'tanggal_peminjaman'=>  $request->tanggal_peminjaman,
            'tanggal_pengembalian'=>  $request->tanggal_pengembalian,
            'status'=>  $request->status,
        );

        Peminjam::create($form_data);

        return response()->json(['status' => 200 ,'success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Peminjam::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'user_id'=> 'required',
            'status'=>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'buku_id'=>  $request->buku_id,
            'user_id'=>  $request->user_id,
            'tanggal_peminjaman'=>  $request->tanggal_peminjaman,
            'status'=>  $request->status,
        );

        try {
            DB::beginTransaction();
            //code...
            $book = Books::findOrFail($request->buku_id);

            if($book->stok_buku !== 0){
                if($request->status == 'Approve') {
                    $book->stok_buku -= 1;
                    $book->save();
                }elseif($request->status == 'Done'){
                    $book->stok_buku += 1;
                    $book->save();
                }
            }else{
                DB::rollback();
                return response()->json(['status' => 400 ,'failed' => 'Data Book invalid']);
            }

            Peminjam::whereId($request->hidden_id)->update($form_data);

            DB::commit();

            return response()->json(['status' => 200 ,'success' => 'Data is successfully updated']);
        } catch (\Throwable $th) {
            DB::rollback();
        }


    }

    public function destroy($id)
    {
        $data = Peminjam::findOrFail($id);
        $data->delete();
        return response()->json(['status' => 200 ,'success' => 'Data is successfully deleted']);
    }
}
