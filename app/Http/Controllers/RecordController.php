<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\RecordResource;
use Carbon\Carbon;

class RecordController extends BaseController
{
    public function index (){
        $record = RecordResource::collection(Record::all());
        return $this->success($record,'all records');
    }
    public function recordByDay ($day) {
        $parsedDate = Carbon::createFromFormat('Y-m-d' , $day)->format('Y-m-d');
        $record = Record::whereDate('created_at' , $parsedDate)->get();
        return RecordResource::collection($record);
    }
    public function recordByMonth($month) {
        $record = Record::whereMonth('created_at' , $month + 1)->get();
        return RecordResource::collection($record);
    }
}
