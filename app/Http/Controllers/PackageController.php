<?php
namespace App\Http\Controllers;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        return view('packages.index', compact('packages'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('packages.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cuci_kering,cuci_setrika,express,dry_clean',
            'price' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Package::create($request->all());
        return redirect()->route('packages.index')->with('success', 'Paket berhasil ditambahkan');
    }

    public function show(Package $package)
    {
        return view('packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        $this->authorizeAdmin();
        return view('packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cuci_kering,cuci_setrika,express,dry_clean',
            'price' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $package->update($request->all());
        return redirect()->route('packages.index')->with('success', 'Paket berhasil diupdate');
    }

    public function destroy(Package $package)
    {
        $this->authorizeAdmin();
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Paket berhasil dihapus');
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }
}