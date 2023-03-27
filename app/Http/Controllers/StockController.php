<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function stock_index(Request $request)
    {
        $data['stocks'] = Stock::all();
        return view('stock.stock_page', $data);
    }

    public function store_stock(Request $request)
    {
        $input = $request->all();
        $stock = Stock::create($input);

        return redirect()->back()->with('success', 'stock created successfully');
    }

    public function getstockInfor(Request $request)
    {
        $stock = Stock::where('id', $request->id)->first();
        return response()->json($stock);
    }

    public function update_stock( Request $request ) {
        $stock = Stock::find( $request->id );
        if ( $stock ) {
            $this->validate( $request, [
                'stock_name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'categories' => 'required',
            ] );

            $input = $request->all();
            $stock->fill( $input )->save();
            return redirect()->back()->with( 'message', 'Stock updated successfully' );
        }
    }

    public function destroy_stock(Request $request)
    {
        $id = $request->id;
        Stock::find($id)->delete();
        return redirect()->back()
            ->with('success', 'stock deleted successfully');
    }
}
