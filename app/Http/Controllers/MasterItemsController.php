<?php

namespace App\Http\Controllers;

use App\Exports\MasterItemsExport;
use App\Models\KategoriItem;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::with('kategoriItems');

        if ($request->filled('kode')) {
            $data_search = $data_search->where('kode', $kode);
        }

        if ($request->filled('nama')) {
            $data_search = $data_search->where(function ($query) use ($nama) {
                $query->where('nama', 'LIKE', '%' . $nama . '%')
                    ->orWhere('supplier', 'LIKE', '%' . $nama . '%');
            });
        }

        if ($request->filled('hargamin')) {
            $data_search = $data_search->where('harga_beli', '>=', $hargamin);
        }

        if ($request->filled('hargamax')) {
            $data_search = $data_search->where('harga_beli', '<=', $hargamax);
        }

        $data_search = $data_search->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = new MasterItem;
        } else {
            $item = MasterItem::with('kategoriItems')->findOrFail($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategoriItems'] = KategoriItem::orderBy('nama')->get();
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('kategoriItems')->where('kode', $kode)->firstOrFail();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga_beli' => ['required', 'integer', 'min:0'],
            'laba' => ['required', 'integer', 'min:0'],
            'supplier' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'kategori_items' => ['nullable', 'array'],
            'kategori_items.*' => ['exists:kategori_items,id'],
        ]);

        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
        } else {
            $data_item = MasterItem::findOrFail($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;

        if ($request->hasFile('foto')) {
            if ($data_item->foto) {
                Storage::disk('public')->delete($data_item->foto);
            }

            $data_item->foto = $request->file('foto')->store('master-items', 'public');
        }

        $data_item->save();
        $data_item->kategoriItems()->sync($request->kategori_items ?? []);

        return redirect('master-items');
    }

    public function delete($id)
    {
        $item = MasterItem::findOrFail($id);

        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->kategoriItems()->detach();
        $item->delete();
        return redirect('master-items');
    }

    public function exportExcel()
    {
        if (!extension_loaded('zip')) {
            return Excel::download(new MasterItemsExport, 'master-items.xls', \Maatwebsite\Excel\Excel::XLS);
        }

        return Excel::download(new MasterItemsExport, 'master-items.xlsx');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }
}
