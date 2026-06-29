<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriItemController extends Controller
{
    public function index(Request $request)
    {
        $nama = trim($request->input('nama', $request->input('filter_nama', '')));
        $kode = trim($request->input('kode', $request->input('filter_kode', '')));

        $kategoriItems = KategoriItem::withCount('masterItems')
            ->when($nama !== '', function ($query) use ($nama) {
                $query->where('nama', 'LIKE', '%' . $nama . '%');
            })
            ->when($kode !== '', function ($query) use ($kode) {
                $query->where('kode', 'LIKE', '%' . $kode . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('kategori_items.index', compact('kategoriItems', 'nama', 'kode'));
    }

    public function create()
    {
        return view('kategori_items.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:255', 'unique:kategori_items,kode'],
        ]);

        KategoriItem::create($data);

        return redirect()->route('kategori-items.index')->with('success', 'Kategori item berhasil dibuat.');
    }

    public function show(KategoriItem $kategoriItem)
    {
        $kategoriItem->load('masterItems');

        return view('kategori_items.show', compact('kategoriItem'));
    }

    public function edit(KategoriItem $kategoriItem)
    {
        return view('kategori_items.edit', compact('kategoriItem'));
    }

    public function update(Request $request, KategoriItem $kategoriItem)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kode' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori_items', 'kode')->ignore($kategoriItem->id),
            ],
        ]);

        $kategoriItem->update($data);

        return redirect()->route('kategori-items.index')->with('success', 'Kategori item berhasil diperbarui.');
    }

    public function destroy(KategoriItem $kategoriItem)
    {
        $kategoriItem->masterItems()->detach();
        $kategoriItem->delete();

        return redirect()->route('kategori-items.index')->with('success', 'Kategori item berhasil dihapus.');
    }

    public function downloadPdf(KategoriItem $kategoriItem)
    {
        $kategoriItem->load('masterItems');

        $pdf = Pdf::loadView('kategori_items.pdf', compact('kategoriItem'));

        return $pdf->download('kategori-' . $kategoriItem->kode . '.pdf');
    }
}
