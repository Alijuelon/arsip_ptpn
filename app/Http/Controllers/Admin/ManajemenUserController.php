<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Departemen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManajemenUserController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     */
    public function index(Request $request)
    {
        // Fitur pencarian sederhana
        $query = User::with('departemen')->orderBy('created_at', 'desc');
        
        if ($request->has('cari')) {
            $query->where('nama_user', 'like', '%' . $request->cari . '%')
                  ->orWhere('nip', 'like', '%' . $request->cari . '%');
        }

        $users = $query->paginate(10); // Menampilkan 10 data per halaman
        $departemens = Departemen::all(); // Untuk form tambah/edit modal jika digabung

        return view('admin.users.index', compact('users', 'departemens'));
    }

    /**
     * Menyimpan pengguna baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:100',
            'nip' => 'required|string|max:50|unique:users,nip',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Admin,Staff,Pimpinan',
            'departemen_id' => 'nullable|exists:departemens,id'
        ]);

        User::create([
            'nama_user' => $request->nama_user,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'departemen_id' => $request->departemen_id
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama_user' => 'required|string|max:100',
            'nip' => 'required|string|max:50|unique:users,nip,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:Admin,Staff,Pimpinan',
            'departemen_id' => 'nullable|exists:departemens,id'
        ];

        // Jika password diisi, tambahkan validasi password
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6';
        }

        $request->validate($rules);

        // Update data dasar
        $user->nama_user = $request->nama_user;
        $user->nip = $request->nip;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->departemen_id = $request->departemen_id;

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Menghapus pengguna.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Mencegah admin menghapus dirinya sendiri yang sedang login
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil dihapus!');
    }
}