<?php

namespace App\Models\Planning;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Planning\Status;
use App\Models\Products\Products;
use App\Models\Products\StockMove;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use App\Models\Workflow\OrderLines;
use App\Models\Workflow\QuoteLines;
use App\Models\Methods\MethodsTools;
use App\Models\Methods\MethodsUnits;
use App\Models\Methods\MethodsServices;
use App\Models\Planning\TaskActivities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Quality\QualityNonConformity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['label', 
                            'ordre',
                            'quote_lines_id',
                            'order_lines_id',
                            'products_id',
                            'methods_services_id',  
                            'component_id',
                            'seting_time', 
                            'unit_time', 
                            'remaining_time', 
                            'progress', 
                            'status_id', 
                            'type',
                            'delay',
                            'qty',
                            'qty_init',
                            'qty_aviable',
                            'unit_cost',
                            'unit_price',
                            'methods_units_id',
                            'x_size', 
                            'y_size', 
                            'z_size', 
                            'x_oversize',
                            'y_oversize',
                            'z_oversize',
                            'diameter',
                            'diameter_oversize',
                            'to_schedule',
                            'material', 
                            'thickness', 
                            'weight', 
                            'quality_non_conformities_id',
                            'methods_tools_id'];

    protected $appends = ["open"];

    public function service()
    {
        return $this->belongsTo(MethodsServices::class, 'methods_services_id');
    }

    public function QuoteLines()
    {
        return $this->belongsTo(QuoteLines::class, 'quote_lines_id');
    }

    public function OrderLines()
    {
        return $this->belongsTo(OrderLines::class, 'order_lines_id');
    }

    public function StockMove()
    {
        return $this->hasMany(StockMove::class);
    }

    public function Products()
    {
        return $this->belongsTo(Products::class, 'products_id');
    }

    public function Component()
    {
        return $this->belongsTo(Products::class, 'component_id');
    }
    
    public function Unit()
    {
        return $this->belongsTo(MethodsUnits::class, 'methods_units_id');
    }

    public function QualityNonConformity()
    {
        return $this->belongsTo(QualityNonConformity::class, 'quality_non_conformities_id');
    }

    public function MethodsTools()
    {
        return $this->belongsTo(MethodsTools::class, 'methods_tools_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function ProductTime()
    {
        return $this->qty*$this->unit_time;
    }

    public function Margin()
    {
        return (1-($this->unit_cost/$this->unit_price))*100;
    }

    public function TotalTime()
    {
        return $this->qty*$this->unit_time+$this->seting_time;
    }

    public function taskActivities()
    {
        return $this->hasMany(TaskActivities::class);
    }

    public function getTotalLogStartTime()
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        return   TaskActivities::where('task_id', $this->id)
                                ->where('type', 1)
                                ->sum(DB::raw("TIMESTAMPDIFF(SECOND, timestamp, '". $current_date_time ."')"));
    }

    public function getTotalLogEndTime()
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        return   TaskActivities::where('task_id', $this->id)
                                ->where(function (Builder $query) {
                                    return $query->where('type', 2)
                                                ->orWhere('type', 3);
                                })
                                ->sum(DB::raw("TIMESTAMPDIFF(SECOND, timestamp, '". $current_date_time ."')"));
    }

    public function getTotalLogTime()
    {
        return   round(($this->getTotalLogStartTime()-$this->getTotalLogEndTime())/3600,2);
    }

    public function progress()
    {
        return   round($this->getTotalLogTime()/$this->TotalTime()*100,2);
    }

    public function GetPrettyCreatedAttribute()
    {
        return date('d F Y', strtotime($this->created_at));
    }

    public function getOpenAttribute(){
        return true;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['code', 'quote_lines_id', 'order_lines_id', 'products_id']);
        // Chain fluent methods for configuration options
    }
}
