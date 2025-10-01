<?php

namespace App\Http\Controllers;

use App\Models\Helper;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Helper';
        return view('dashboard', ['title' => $title, 'data' => Helper::all()]);
    }

    public function create(\Illuminate\Http\Request $request){
        Helper::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'ket' => $request->ket
        ]);

        return redirect(route('helper'))->with('success', 'Data berhasil ditambahkan');
    }

    public function remove($id)
    {
        $helper = Helper::find($id);
        $helper->delete();
        return redirect(route('helper'))->with('success', 'Data berhasil dihapus');
    }
}
