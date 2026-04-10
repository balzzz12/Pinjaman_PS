<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayStation;
use App\Models\Category;
use Illuminate\Http\Request;

class PlayStationController extends Controller
{
    public function index()
    {
        $data = PlayStation::with('category')->latest()->get();
        $categories = Category::all();

        return view('admin.playstation.index', compact('data', 'categories'));
    }

    public function edit($id)
    {
        $ps = PlayStation::findOrFail($id);
        $categories = Category::all();

        return view('admin.playstation.edit', compact('ps', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video'       => 'nullable|mimes:mp4,mov,avi|max:20000',
        ]);

        if (!file_exists(public_path('uploads/ps'))) {
            mkdir(public_path('uploads/ps'), 0777, true);
        }

        if (!file_exists(public_path('uploads/video'))) {
            mkdir(public_path('uploads/video'), 0777, true);
        }

        $photoName = null;
        $videoName = null;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $photoName = time() . '_photo.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/ps'), $photoName);
        }

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '_video.' . $video->getClientOriginalExtension();
            $video->move(public_path('uploads/video'), $videoName);
        }

        $ps = PlayStation::create([
            'nama'        => $request->nama,
            'category_id' => $request->category_id,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'status'      => 'tersedia',
            'photo'       => $photoName,
            'video'       => $videoName,
            'deskripsi'   => $request->deskripsi
        ]);

        // ✅ LOG TAMBAH
        logAktivitas(
            'Tambah Produk',
            'Produk: ' . $ps->nama . ' | Harga: ' . $ps->harga . ' | Stok: ' . $ps->stok
        );

        return redirect()->route('admin.playstation.index')
            ->with('success', 'Data PlayStation berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'deskripsi'   => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video'       => 'nullable|mimes:mp4,mov,avi|max:20000',
        ]);

        $ps = PlayStation::findOrFail($id);

        $oldData = $ps->nama . ' | Harga: ' . $ps->harga . ' | Stok: ' . $ps->stok;

        $photoName = $ps->photo;
        $videoName = $ps->video;

        if ($request->hasFile('photo')) {

            if ($ps->photo && file_exists(public_path('uploads/ps/' . $ps->photo))) {
                unlink(public_path('uploads/ps/' . $ps->photo));
            }

            $file = $request->file('photo');
            $photoName = time() . '_photo.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/ps'), $photoName);
        }

        if ($request->hasFile('video')) {

            if ($ps->video && file_exists(public_path('uploads/video/' . $ps->video))) {
                unlink(public_path('uploads/video/' . $ps->video));
            }

            $video = $request->file('video');
            $videoName = time() . '_video.' . $video->getClientOriginalExtension();
            $video->move(public_path('uploads/video'), $videoName);
        }

        $ps->update([
            'nama'        => $request->nama,
            'category_id' => $request->category_id,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'status'      => $request->status,
            'photo'       => $photoName,
            'video'       => $videoName,
            'deskripsi'   => $request->deskripsi
        ]);

        // ✅ LOG UPDATE
        logAktivitas(
            'Update Produk',
            'Dari: ' . $oldData . ' → Menjadi: ' . $ps->nama . ' | Harga: ' . $ps->harga . ' | Stok: ' . $ps->stok
        );

        return redirect()->route('admin.playstation.index')
            ->with('success', 'Data PlayStation berhasil diupdate');
    }

    public function destroy($id)
    {
        $ps = PlayStation::findOrFail($id);

        $info = $ps->nama . ' | Harga: ' . $ps->harga;

        if ($ps->photo && file_exists(public_path('uploads/ps/' . $ps->photo))) {
            unlink(public_path('uploads/ps/' . $ps->photo));
        }

        if ($ps->video && file_exists(public_path('uploads/video/' . $ps->video))) {
            unlink(public_path('uploads/video/' . $ps->video));
        }

        $ps->delete();

        // ✅ LOG DELETE
        logAktivitas('Hapus Produk', 'Menghapus: ' . $info);

        return redirect()->route('admin.playstation.index')
            ->with('success', 'Data PlayStation berhasil dihapus');
    }
}
