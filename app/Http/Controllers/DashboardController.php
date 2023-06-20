<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Books;
use App\Models\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request) {
        // dd(Auth::user());
        $data = User::orderby('id', 'ASC')->limit(10)->get();
        $jml_buku = Books::count();
        $jml_user = User::count();
        $jml_peminjam = Peminjam::count();
        return view('home',[
        'jml_user' => $jml_user,
        'jml_buku' => $jml_buku,
        'jml_peminjam' => $jml_peminjam,
        'data' => $data ]);
    }
}
