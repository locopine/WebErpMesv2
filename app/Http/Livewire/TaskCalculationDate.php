<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Planning\Task;
use Illuminate\Support\Facades\DB;
use App\Models\Workflow\OrderLines;
use Illuminate\Database\Eloquent\Builder;

class TaskCalculationDate extends Component
{
    public $Tasklists = [];
    public $progress = 0;
    public $toBeCalculate = true;
    public $countTaskCalculate = 0;

    public function render()
    {
        return view('livewire.task-calculation-date', [
            'Tasklists' =>  $this->Tasklists,
            'countTaskCalculate' =>  $this->countTaskCalculate,
        ]);
    }

    public function calculate()
    {
        $countLines = DB::table('order_lines')
                                ->join('orders', 'order_lines.orders_id', '=', 'orders.id')
                                ->where('orders.statu', '=', 1)
                                ->Orwhere('orders.statu', '=', 2)
                                ->orderBy('order_lines.internal_delay')
                                ->count();

        $OrderLines = OrderLines::with('order')
                                ->join('orders', 'order_lines.orders_id', '=', 'orders.id')
                                ->where('orders.statu', '=', 1)
                                ->Orwhere('orders.statu', '=', 2)
                                ->orderBy('order_lines.internal_delay')
                                ->select('order_lines.*')
                                ->get();

        //value to substrac
        $totalTaskLineTime = 0;
        foreach($OrderLines as $Line){
            //get timetamps for substract hours in decimal, dont forge for 1h = 3600 sec
            $DatetimeLine = strtotime(Carbon::parse($Line->internal_delay)->toDatetimeString());
        
            //check if internal delay is weekend
            //2 day substrac
            if(date('N', strtotime($Line->internal_delay)) == 1) $totalTaskLineTime+=3600*48;
            //1 day substrac
            if(date('N', strtotime($Line->internal_delay)) == 7) $totalTaskLineTime+=3600*24;

            // first substrac not working time from 18:00 to 0:00
            $totalTaskLineTime += 3600*7;
            $Tasks = Task::where('order_lines_id', '=', $Line->id)
                        ->where(function (Builder $query) {
                            return $query->where('tasks.type', 1)
                                        ->orWhere('tasks.type', 7);
                        })
                        ->orderByDesc('ordre')
                        ->get();

                $order = 0;
                $addfirsthour = 1;
                foreach($Tasks as $Task){
                    $UpdateTask = Task::find($Task->id);
                    $UpdateTask->end_date = date("Y-m-d H:i:s", $DatetimeLine-$totalTaskLineTime);
                    $UpdateTask->save();
                    
                    if($order ==  $Task->order_lines_id){
                        $addfirsthour = 0;
                    }
                    else{
                        $addfirsthour = 1;
                    }

                    //the range working hour, is 8h per day, so for each step of 8h from total time task, we must be add 16h
                    $loopDayCount = floor($Task->TotalTime()/8);
                    $loopWeekendCount = floor($loopDayCount/5);
                    //add 16h per day
                    $addTime = $loopDayCount*16;
                    //add 48h per weekend
                    $addTime += $loopWeekendCount * 48;
                    
                    //now we add time in sec
                    $totalTaskLineTime += ($Task->TotalTime()+$addfirsthour+$addTime)*3600;
                    $order = $Task->order_lines_id;

                    $this->countTaskCalculate += 1;
                }
            
            $totalTaskLineTime = 0;
            $this->progress  += (1/$countLines)*100; 
        }     

        $this->toBeCalculate = false;
    }
    
}
