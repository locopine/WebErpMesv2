<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Admin\Factory;
use App\Models\Workflow\Orders;
use App\Models\Workflow\Quotes;
use App\Models\Products\Products;
use Illuminate\Support\Facades\DB;
use App\Models\Workflow\OrderLines;
use App\Models\Admin\EstimatedBudgets;
use App\Models\Methods\MethodsServices;

class HomeController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $CurentYear = Carbon::now()->format('Y');

        //DB information mustn't be empty.
        $Factory = Factory::first();
        if(!$Factory){
            return redirect()->route('admin.factory')->with('error', 'Please check factory information');
        }

        //use for liste of tasks
        $ServiceGoals = MethodsServices::withCount(['Tasks', 'Tasks' => function ($query) {
                                            $query->whereNotNull('order_lines_id');
                                        }])
                                        ->orderBy('ordre')->get();
        $Tasks = DB::table('tasks')
                    ->select('tasks.id','statuses.title', 'methods_services.id as methods_id', 'methods_services.label', DB::raw('count(*) as total_task'))
                    ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                    ->join('methods_services', 'tasks.methods_services_id', '=', 'methods_services.id')
                    ->whereNotNull('tasks.order_lines_id')
                    ->groupBy('methods_services_id')
                    ->groupBy('status_id')
                    ->orderBy('statuses.order', 'asc')
                    ->get();
        //5 last product add 
        $LastProducts = Products::orderBy('id', 'desc')->take(5)->get();
        //5 last Quotes add 
        $LastQuotes = Quotes::orderBy('id', 'desc')->take(5)->get();
        /*  
        try to obtain total price of cost
        $LastQuotes = Quotes::select("*", DB::Raw("SUM(Subtotal) AS sub_total"))
                            ->groupBy('seller_id')
                            ->orderBy('id', 'desc')
                            ->take(5)
                            ->get();*/

        //5 lastest Orders add 
        $LastOrders = Orders::orderBy('id', 'desc')->take(5)->get();

        //Order incoming end date
        // we use in future deadline trait for this
        $incomingOrdersCount = OrderLines::orderBy('id', 'desc')
                                            ->where([
                                                ['delivery_date', '>', Carbon::now()],
                                                ['delivery_date', '<', Carbon::now()->addDays(2)],
                                            ])
                                            ->where('delivery_status', '<', 3)
                                            ->groupBy('orders_id')
                                            ->get();
        $incomingOrdersCount = count($incomingOrdersCount)-4;
        
        $incomingOrders = OrderLines::orderBy('id', 'desc')
                            ->where([
                                ['delivery_date', '>', Carbon::now()],
                                ['delivery_date', '<', Carbon::now()->addDays(2)],
                            ])
                            ->where('delivery_status', '<', 3)
                            ->groupBy('orders_id')
                            ->take(4)
                            ->get();
        //late Order count
        $LateOrdersCount = OrderLines::orderBy('id', 'desc')
                            ->where('delivery_date', '<', Carbon::now())
                            ->where('delivery_status', '<', 3)
                            ->groupBy('orders_id')
                            ->get();
        $LateOrdersCount = count($LateOrdersCount)-4;

        $LateOrders = OrderLines::orderBy('id', 'desc')
                            ->where('delivery_date', '<', Carbon::now())
                            ->where('delivery_status', '<', 3)
                            ->groupBy('orders_id')
                            ->take(4)
                            ->get();
        
        // Display total customers, suppliers, quotes, orders, NC 
        $data['customers_count'] = DB::table('companies')->where('statu_customer', '=', '2')->count();
        $data['suppliers_count'] = DB::table('companies')->where('statu_supplier', '=', '2')->count();
        $data['quotes_count'] = DB::table('quotes')->count();
        $data['orders_count'] = DB::table('orders')->count();
        $data['quality_non_conformities_count'] = DB::table('quality_non_conformities')->count();
        $data['user_count'] = DB::table('users')->count();
        
        //Quote data for chart
        $data['quotesDataRate'] = DB::table('quotes')
                                    ->select('statu', DB::raw('count(*) as QuoteCountRate'))
                                    ->whereYear('created_at', $CurentYear)
                                    ->groupBy('statu')
                                    ->get();
        //Order data for chart
        $data['orderMonthlyRecap'] = DB::table('order_lines')
                                    ->selectRaw('
                                        MONTH(delivery_date) AS month,
                                        SUM((selling_price * qty)-(selling_price * qty)*(discount/100)) AS orderSum
                                    ')
                                    ->whereYear('created_at', $CurentYear)
                                    ->groupByRaw('MONTH(delivery_date) ')
                                    ->get();
        //TotalRevenue
        $orderTotalRevenue = DB::table('order_lines')
                                    ->selectRaw('
                                    ROUND(SUM((selling_price * qty)-(selling_price * qty)*(discount/100)),2) AS orderTotalRevenue
                                    ')
                                    ->where('delivery_status', '=', 3)
                                    ->whereYear('created_at', $CurentYear)
                                    ->get();

        //TotalRevenue
        $orderTotalForCast = DB::table('order_lines')
                                    ->selectRaw('
                                    ROUND(SUM((selling_price * qty)-(selling_price * qty)*(discount/100)),2) AS orderTotalForCast
                                    ')
                                    ->where('delivery_status', '=', 1)
                                    ->orwhere('delivery_status', '=', 2)
                                    ->whereYear('created_at', $CurentYear)
                                    ->get();

        

        //Estimated Budgets data for chart
        $data['estimatedBudget'] = EstimatedBudgets::where('year', $CurentYear)->get();

        //GOAL 
        $EstimatedBudgets = $data['estimatedBudget'][0]->amount1
                            +$data['estimatedBudget'][0]->amount2
                            +$data['estimatedBudget'][0]->amount3
                            +$data['estimatedBudget'][0]->amount4
                            +$data['estimatedBudget'][0]->amount5
                            +$data['estimatedBudget'][0]->amount6
                            +$data['estimatedBudget'][0]->amount7
                            +$data['estimatedBudget'][0]->amount8
                            +$data['estimatedBudget'][0]->amount9
                            +$data['estimatedBudget'][0]->amount10
                            +$data['estimatedBudget'][0]->amount11
                            +$data['estimatedBudget'][0]->amount12;

        return view('dashboard', [
            'Factory' => $Factory,
            'LastProducts' => $LastProducts,
            'LastQuotes' => $LastQuotes,
            'LastOrders' =>  $LastOrders,
            'OrderTotalRevenue' => $orderTotalRevenue,
            'orderTotalForCast' => $orderTotalForCast,
            'LateOrdersCount' =>  $LateOrdersCount,
            'incomingOrders' =>  $incomingOrders,
            'incomingOrdersCount' => $incomingOrdersCount,
            'LateOrders' =>  $LateOrders,
            'ServiceGoals' => $ServiceGoals,
            'Tasks' => $Tasks,
            'EstimatedBudgets' => $EstimatedBudgets,
        ])->with('data',$data);
    }

}
