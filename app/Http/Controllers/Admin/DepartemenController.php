<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departemen;
use Illuminate\Database\QueryException;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::orderBy('nama_departemen', 'asc')->get();
        return view('admin.departemen.index', compact('departemens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departemens,nama_departemen',
            'keterangan' => 'nullable|string'
        ]);

        Departemen::create($request->all());

        return redirect()->route('admin.departemen.index')
            ->with('success', 'Departemen baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $departemen = Departemen::findOrFail($id);

        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departemens,nama_departemen,' . $id,
            'keterangan' => 'nullable|string'
        ]);

        $departemen->update($request->all());

        return redirect()->route('admin.departemen.index')
            ->with('success', 'Data departemen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $departemen = Departemen::findOrFail($id);
            $departemen->delete();

            return redirect()->route('admin.departemen.index')
                ->with('success', 'Departemen berhasil dihapus!');
        } catch (QueryException $e) {
            // Mencegah error jika departemen masih dipakai oleh User (Foreign Key Constraint)
            return back()->with('error', 'Gagal menghapus! Departemen ini masih memiliki data pengguna yang terkait.');
        }
    }
}