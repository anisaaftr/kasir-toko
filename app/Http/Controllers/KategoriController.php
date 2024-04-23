<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $kategoris = Kategori::orderBy('id')
            ->when($search, function ($q, $search) {
                return $q->where('nama_kategori', 'like', "%{$search}%");
            })
            ->paginate();

        if ($search) $kategoris->appends(['search' => $search]);
        
        return view('kategori.index', [
            'kategoris' => $kategoris
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => ['required', 'max:100'],
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')->with('store', 'success');

    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', [
            'kategori' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => ['required', 'max:100'],
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('update', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return back()->with('destroy', 'success');
    }
}
