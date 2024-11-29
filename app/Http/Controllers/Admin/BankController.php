<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class BankController extends Controller
{
    private $folder = "admin.bank.";

    // Menampilkan halaman index bank
    public function index()
    {
        return view($this->folder . 'index', [
            'get_data' => route($this->folder . 'getData'),
        ]);
    }

    // Mengambil data bank
    public function getData()
    {
        return view($this->folder . 'content', [
            'add_new' => route($this->folder . 'create'),
            'getDataTable' => route($this->folder . 'getDataTable'),
            'banks' => Bank::get(),
        ]);
    }

    // Mengambil data bank untuk DataTables
    public function getDataTable()
    {
        $banks = Bank::get();
        return DataTables::of($banks)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                $image = "<img src='" . asset('storage/bank_images/' . $data->image_name) . "' class='table-image'>";
                return $image;
            })
            ->addColumn('action', function ($data) {
                $btn = "<div class='table-actions'>
                            <a href='" . route($this->folder . 'edit', ['bank_id' => $data->bank_id]) . "'><i class='ik ik-edit-2 text-dark'></i></a>
                            <a data-href='" . route($this->folder . 'destroy', ['id' => $data->bank_id]) . "' class='delete cursor-pointer'><i class='ik ik-trash-2 text-danger'></i></a>
                        </div>";
                return $btn;
            })
            ->rawColumns(['action', 'image'])
            ->toJson();
    }

    // Menampilkan form untuk menambah bank baru
    public function create()
    {
        return view($this->folder . 'create', [
            'form_store' => route($this->folder . 'store'),
        ]);
    }

    // Menyimpan data bank baru
    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'image_name' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'bank_name' => $request->bank_name,
        ];

        if ($request->hasFile('image_name')) {
            $file = $request->file('image_name');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bank_images', $filename);
            $data['image_name'] = $filename;
        }

        Bank::create($data);

        return redirect()->route($this->folder . 'index')->with('success', 'Bank created successfully.');
    }

    // Menampilkan form edit bank
    public function edit($bank_id)
    {
        $bank = Bank::findOrFail($bank_id);
        return view($this->folder . 'edit', [
            'bank' => $bank,
            'form_update' => route($this->folder . 'update', ['bank_id' => $bank_id]),
        ]);
    }

    // Memperbarui data bank
    public function update(Request $request, $bank_id)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'image_name' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $bank = Bank::findOrFail($bank_id);

        $data = [
            'bank_name' => $request->bank_name,
        ];

        if ($request->hasFile('image_name')) {
            // Hapus file lama
            if ($bank->image_name && file_exists(storage_path('app/public/bank_images/' . $bank->image_name))) {
                unlink(storage_path('app/public/bank_images/' . $bank->image_name));
            }
            // Simpan file baru
            $file = $request->file('image_name');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bank_images', $filename);
            $data['image_name'] = $filename;
        }

        $bank->update($data);

        return redirect()->route($this->folder . 'index')->with('success', 'Bank updated successfully.');
    }

    // Menghapus data bank
    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);

        // Hapus file gambar jika ada
        if ($bank->image_name && file_exists(storage_path('app/public/bank_images/' . $bank->image_name))) {
            unlink(storage_path('app/public/bank_images/' . $bank->image_name));
        }

        $bank->delete();

        return response()->json([
            'status' => true,
            'message' => 'Bank deleted successfully.',
        ]);
    }
}
