<?php

namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;

use Validator;
use DataTables;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function index(Request $request) {

    //     if($request -> ajax()){
    //         $data = User::orderby('id', 'ASC')->get();
    //     }

    //     $data = User::orderby('id', 'ASC')->get();
    //     // dd($data);
    //     return view('list-users',['data'=> $data]);
    // }

    // public function store(Request $request) {
    //     $data = [
    //         'username' => $request->username,
    //         'name' => $request->name,
    //         'password' => Hash::make($request->password),
    //         'phone' => $request->phone,
    //         'role_id' => $request->role_id,
    //     ];
    //     // $request['password'] = Hash::make($request->password);

    //     User::create($data);
    //     return response()->json([
    //         'status' => 200
    //     ]);
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::with('role')->select('id','name','username','phone','role_id')->get();

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                        $button .= '   <button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                        return $button;
                    })
                    // ->rawColumns(['action'])
                    ->make(true);
            }

        $roles = Role::all();
        return view('list-users', compact('roles'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'name'=>  'required',
            'password'=>  'required',
            'username'=>  'required',
            'role_id'=>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $pass = $request->password;
        $postpass = Hash::make($pass);

        $form_data = array(
            'name'=>  $request->name,
            'username'=>  $request->username,
            'phone'=>  $request->phone,
            'role_id'=>  $request->role_id,
            'password' =>  $postpass
        );

        User::create($form_data);

        return response()->json(['status' => 200 ,'success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = User::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'name'=>  'required',
            'username'=>  'required',
            'role_id'=>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'=>  $request->name,
            'username'=>  $request->username,
            'phone'=>  $request->phone,
            'role_id'=>  $request->role_id,
        );

        User::whereId($request->hidden_id)->update($form_data);

        return response()->json(['status' => 200 ,'success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
    }
}
