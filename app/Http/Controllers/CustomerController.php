<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function landing(Request $request)
{
    if ($request->has('meja')) {
        session(['meja' => $request->meja]);
    }
    return view('customer.landing');
}


    public function menu(Request $request)
    {
        // Simpan nomor meja dari parameter ?meja=... ke session
        if ($request->has('meja')) {
            $nomorMeja = $request->query('meja');

            // Validasi nomor meja antara 1-10
            if (is_numeric($nomorMeja) && $nomorMeja >= 1 && $nomorMeja <= 10) {
                session(['meja' => $nomorMeja]);
            }
        }

        $menus = Menu::all();
        $cart = session()->get('cart', []);
        return view('customer.menu', compact('menus', 'cart'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $menus = Menu::where('nama', 'like', '%' . $query . '%')->get();
        return view('customer.search', compact('menus', 'query'));
    }

    public function makanan()
    {
        $menus = Menu::where('kategori_id', 1)->get();
        return view('customer.kategori', ['menus' => $menus, 'kategori' => 'Makanan']);
    }

    public function minuman()
    {
        $menus = Menu::where('kategori_id', 2)->get();
        return view('customer.kategori', ['menus' => $menus, 'kategori' => 'Minuman']);
    }

    public function makananRingan()
    {
        $menus = Menu::where('kategori_id', 3)->get();
        return view('customer.kategori', ['menus' => $menus, 'kategori' => 'Makanan Ringan']);
    }

    public function makananPenutup()
    {
        $menus = Menu::where('kategori_id', 4)->get();
        return view('customer.kategori', ['menus' => $menus, 'kategori' => 'Makanan Penutup']);
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);

        $items = collect($cart)->map(function ($item) {
            $menu = Menu::find($item['id']);
            if (!$menu) return null;

            return (object) [
                'id' => $menu->id,
                'nama' => $menu->nama,
                'harga' => $menu->harga,
                'gambar' => $menu->gambar,
                'qty' => $item['qty'],
                'stok' => $menu->stok,
            ];
        })->filter();

        $total = $items->sum(fn($item) => $item->harga * $item->qty);

        return view('customer.keranjang', compact('items', 'total'));
    }

    public function addToCart(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);
        $currentQty = isset($cart[$id]) ? $cart[$id]['qty'] : 0;

        if ($currentQty < $menu->stok) {
            $cart[$id] = [
                'id' => $menu->id,
                'qty' => $currentQty + 1,
            ];
            session()->put('cart', $cart);
            return response()->json(['status' => 'success', 'cart' => $cart]);
        }

        return response()->json(['status' => 'failed', 'message' => 'Stok tidak mencukupi'], 400);
    }

    public function updateCart(Request $request)
    {
        $id = $request->input('id');
        $qty = (int) $request->input('qty');

        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['status' => 'failed', 'message' => 'Menu tidak ditemukan'], 404);
        }

        $cart = session()->get('cart', []);

        if ($qty <= 0) {
            unset($cart[$id]);
        } elseif ($qty <= $menu->stok) {
            $cart[$id] = [
                'id' => $menu->id,
                'qty' => $qty,
            ];
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Melebihi stok tersedia'], 400);
        }

        session()->put('cart', $cart);
        return response()->json(['status' => 'updated', 'cart' => $cart]);
    }

    public function storeOrder(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.menu')->with('error', 'Keranjang kosong.');
        }

        $total = 0;
        foreach ($cart as $id => $item) {
            $menu = Menu::find($id);
            if ($menu) {
                $qty = $item['qty'] ?? 0;
                $total += $menu->harga * $qty;
            }
        }

        $order = Order::create([
            'meja' => session('meja', '08'), // Ambil dari session, default ke '08' jika tidak ada
            'total_harga' => $total,
        ]);

        foreach ($cart as $id => $item) {
            $qty = $item['qty'] ?? 0;

            // Simpan item ke tabel order_items
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $id,
                'qty' => $qty,
            ]);

            // Kurangi stok menu
            $menu = Menu::find($id);
            if ($menu && $menu->stok >= $qty) {
                $menu->stok -= $qty;
                $menu->save();
            }
        }

        Session::forget('cart');

        return redirect()->route('customer.bill', ['order' => $order->id]);
    }

    public function bill(Order $order)
    {
        $order->load(['items.menu']);
        return view('customer.bill', compact('order'));
    }

    public function logoRedirect()
    {
        session()->forget('cart'); // Kosongkan keranjang
        return redirect()->route('customer.landing');
    }
}
