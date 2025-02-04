<?php

namespace App\Http\Controllers\Products;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Products\Stocks;
use App\Models\Products\Products;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Products\StockLocation;
use App\Models\Products\StockLocationProducts;
use App\Http\Requests\Products\StoreStockLocationRequest;
use App\Http\Requests\Products\UpdateStockLocationRequest;

class StockLocationController extends Controller
{
    //
    public function show($id)
    {
        $StockLocation = StockLocation::findOrFail($id);
        $Stock = Stocks::findOrFail($StockLocation->stocks_id);
        $StockLocationsProducts = StockLocationProducts::where('stock_locations_id', '=', $id)->get();
        $userSelect = User::select('id', 'name')->get();
        $ProductSelect = Products::select('id', 'code')->get();
        $LastStockLocationProduct =  DB::table('stock_location_products')->orderBy('id', 'desc')->first();
        
        return view('products/stockLocation-show', [
            'Stock' => $Stock,
            'StockLocation' => $StockLocation,
            'StockLocationsProducts' => $StockLocationsProducts,
            'userSelect' => $userSelect,
            'ProductSelect' => $ProductSelect,
            'LastStockLocationProduct' => $LastStockLocationProduct
        ]);
    }

    public function store(StoreStockLocationRequest $request)
    {
        $StockLocation = StockLocation::create($request->only('code',
                                                'label', 
                                                'stocks_id',
                                                'user_id',
                                                'end_date',
                                                'comment',
                                            ));

        return redirect()->route('products.stocklocation.show', ['id' => $StockLocation->id])->with('success', 'Successfully created new location stock');
    }

    /**
     * @param $request
     * @return View
     */
    public function update(UpdateStockLocationRequest $request)
    {
        $StockLocation = StockLocation::find($request->id);
        $StockLocation->label=$request->label;
        $StockLocation->user_id=$request->user_id;
        $StockLocation->comment=$request->comment;
        $StockLocation->save();
        return redirect()->route('products.stock.show', ['id' => $request->stocks_id])->with('success', 'Successfully updated stock location'.  $StockLocation->label);
    }
}
