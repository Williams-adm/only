<?php

namespace App\Http\Controllers\Api\Movil;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Movil\SaveSaleRequest;
use App\Http\Resources\Api\Movil\SaleAllResource;
use App\Models\Sale;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function completeSale(SaveSaleRequest $request)
    {
        $validated = $request->validated();

        try{
            DB::beginTransaction();

            Cart::instance('shoppingPOS');

            // Restaurar carrito previo (para no sobrescribir)
            if (Auth::check()) {
                Cart::restore(Auth::id());
            }
-
            $total = Cart::total();
            Sale::create([
                'employee' => Auth::user()->name,
                'content' => Cart::content(),
                'total' => $total,
                'date_transaction' => now()->format('H:i:s'),
                'type_voucher' => $validated['type_voucher'],
                'type_document' => $validated['type_document'],
                'n_document' => $validated['n_document'],
                'names' => $validated['names'] ?? null,
                'razon_social' => $validated['razon_social'] ?? null,
                'dirección fiscal' => $validated['dirección fiscal'] ?? null,
                'type_emision' => $validated['type_emision'],
                'methd_payment' => $validated['methd_payment'],
                'paid_amount' => $validated['paid_amount'],
            ]);

            DB::commit();

            Cart::destroy();

            if (Auth::check()) {
                Cart::store(Auth::id());
            }

            return response()->json(['message' => 'Venta registrada correctamente']);

        }catch (Exception $e){
            return response()->json([
                'message' => 'Error al registrar la venta.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAll()
    {
        return SaleAllResource::collection(Sale::all());
    }

    public function getByID($id)
    {
        $sale = Sale::findOrFail($id);

        return response()->json($sale);
    }
}
