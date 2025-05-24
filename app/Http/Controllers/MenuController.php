<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // Tampilkan semua menu
    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    // Tampilkan form tambah menu
    public function create()
    {
        $kategoris = Kategori::all();
        return view('menu.create', compact('kategoris'));
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama'       => 'required|string|max:225',
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi'  => 'required|string',
            'harga'      => 'required|numeric',
            'stok'       => 'required|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('menu', 'public');
            $validated['gambar'] = $path;
        }

        Menu::create($validated);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // Detail menu
    public function show($id)
    {
        $menu = Menu::with('kategori')->findOrFail($id);
        return view('menu.show', compact('menu'));
    }

    // Form edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $kategoris = Kategori::all();
        return view('menu.edit', compact('menu', 'kategoris'));
    }

    // Update menu
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->fill($request->only(['nama', 'kategori_id', 'harga', 'stok', 'deskripsi']));

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar', 'public');
            $menu->gambar = $gambarPath;
        }

        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    // Hapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
            Storage::disk('public')->delete($menu->gambar);
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    // Dashboard (opsional)
    public function dashboard()
    {
        return view('dashboard');
    }

    // Tampilkan detail satu pesanan
    public function detailPesanan($id)
    {
        $order = Order::with('items.menu')->findOrFail($id);
        return view('detailpesanan', compact('order'));
    }

    // Tampilkan semua pesanan (urut status + waktu)
    public function allOrders()
    {
        $orders = Order::with('items.menu')
            ->orderByRaw("FIELD(status_pesanan, 'Menunggu Pembayaran', 'Diproses', 'Selesai')")
            ->orderByDesc('created_at')
            ->get();

        return view('detailpesanan', compact('orders'));
    }

    // Status pesanan tunggal
    public function statusPesanan(Order $order)
    {
        $order->load(['items.menu']);
        return view('statuspesanan', compact('order'));
    }

    // Form konfirmasi pembayaran
    public function showKonfirmasiPembayaran($id)
    {
        $order = Order::with('items.menu')->findOrFail($id);
        return view('konfirmasi_pembayaran', compact('order'));
    }

    // Proses konfirmasi pembayaran
    public function prosesKonfirmasiPembayaran(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,qris,debit card,credit card',
        ]);

        $order = Order::findOrFail($id);
        $order->status_pesanan = 'Diproses';
        $order->tanggal_konfirmasi_pembayaran = now();
        $order->metode_pembayaran = $request->metode_pembayaran;
        $order->save();

        return redirect()->route('detailpesanan')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    // Form konfirmasi selesai
    public function showKonfirmasiSelesai($id)
    {
        $order = Order::with('items.menu')->findOrFail($id);
        return view('konfirmasi_selesai', compact('order'));
    }

    // Proses konfirmasi selesai
    public function prosesKonfirmasiSelesai(Request $request, $id)
    {
        $request->validate([
            'disajikan' => 'required|array',
        ]);

        $order = Order::findOrFail($id);

        if (count($order->items) !== count($request->disajikan)) {
            return back()->with('error', 'Semua menu harus dikonfirmasi telah disajikan.');
        }

        $order->status_pesanan = 'Selesai';
        $order->tanggal_selesai = now();
        $order->save();

        return redirect()->route('detailpesanan')->with('success', 'Pesanan selesai dikonfirmasi.');
    }

    // Tampilkan halaman riwayat pesanan
    public function riwayatPesanan($id)
    {
        $order = Order::with('items.menu')->findOrFail($id);
        return view('riwayat_pesanan', compact('order'));
    }
    
}
