<?php

namespace App\Http\Controllers\Api\movil;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Movil\StoreSaleRequest;
use App\Http\Resources\Api\Movil\FeatureResource;
use App\Models\Variant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addSummary(StoreSaleRequest $request)
    {
        $validated = $request->validated();

        $variant = Variant::find($validated['variant_id']);
        if (!$variant) {
            return response()->json(['message' => 'Variante no encontrada'], 404);
        }

        Cart::instance('shoppingPOS');

        // Restaurar carrito previo (para no sobrescribir)
        if (Auth::check()) {
            Cart::restore(Auth::id());
        }

        // Buscar item existente
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($variant) {
            return $cartItem->options->sku == $variant->sku;
        })->first();

        $cantidadActual = $cartItem ? $cartItem->qty : 0;
        $stockDisponible = $variant->stock;

        if (($cantidadActual + $validated['quantity']) > $stockDisponible) {
            return response()->json([
                'message' => 'No hay suficiente stock para la cantidad seleccionada',
            ], 400);
        }

        if ($cartItem) {
            Cart::update($cartItem->rowId, $cartItem->qty + $validated['quantity']);
        } else {
            Cart::add([
                'id' => $variant->product->id, // ✅ igual que en Livewire
                'name' => $variant->product->name,
                'qty' => $validated['quantity'],
                'price' => $variant->price,
                'options' => [
                    'image' => $variant->images->first() ? asset('storage/' . $variant->images->first()->path) : null,
                    'stock' => $variant->stock,
                    'model' => $variant->product->model,
                    'sku' => $variant->sku,
                ],
            ]);
        }

        if (Auth::check()) {
            Cart::store(Auth::id()); // ✅ guarda el carrito ya restaurado + actualizado
        }

        return response()->json([
            'message' => 'Producto añadido al carrito',
        ]);
    }

    public function contentSummary()
    {
        Cart::instance('shoppingPOS');
        if (Auth::check()) {
            Cart::restore(Auth::id());
        }

        return response()->json([
            'items' => Cart::content(),
            'subtotal' => Cart::subtotal(),
            'total' => Cart::total(),
            'count' => Cart::count(),
        ]);
    }

    public function updateSummary(Request $request, $rowId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        Cart::instance('shoppingPOS');
        if (Auth::check()) {
            Cart::restore(Auth::id());
        }

        $cartItem = Cart::get($rowId);
        if (!$cartItem) {
            return response()->json(['message' => 'Producto no encontrado en el carrito'], 404);
        }

        // Validar stock de la variante
        $variant = Variant::where('sku', $cartItem->options->sku)->first();
        if ($request->quantity > $variant->stock) {
            return response()->json(['message' => 'Stock insuficiente'], 400);
        }

        Cart::update($rowId, $request->quantity);

        if (Auth::check()) {
            Cart::store(Auth::id());
        }

        return response()->json(['message' => 'Cantidad actualizada']);
    }

    public function destroySummary()
    {
        Cart::instance('shoppingPOS');
        Cart::destroy();

        if (Auth::check()) {
            Cart::store(Auth::id());
        }

        return response()->json(['message' => 'Carrito vaciado']);
    }

    public function removeSummary($rowId)
    {
        Cart::instance('shoppingPOS');
        if (Auth::check()) {
            Cart::restore(Auth::id());
        }

        $cartItem = Cart::get($rowId);
        if (!$cartItem) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        Cart::remove($rowId);

        if (Auth::check()) {
            Cart::store(Auth::id());
        }

        return response()->json(['message' => 'Producto eliminado del carrito']);
    }
}
