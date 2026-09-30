<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Helper';
        $cari = trim((string) $request->query('cari', ''));

        $query = Helper::query();

        if ($cari !== '') {
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', '%' . $cari . '%')
                    ->orWhere('nip', 'like', '%' . $cari . '%')
                    ->orWhere('ket', 'like', '%' . $cari . '%');
            });
        }

        return view('dashboard', [
            'title' => $title,
            'data' => $query->get(),
            'cari' => $cari,
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255'],
            'ket' => ['nullable', 'string', 'max:255'],
        ]);

        Helper::create($validated);

        return redirect()->route('helper')->with('success', 'Data berhasil ditambahkan');
    }

    public function remove($id)
    {
        $helper = Helper::findOrFail($id);
        $helper->delete();

        return redirect()->route('helper')->with('success', 'Data berhasil dihapus');
    }
}
