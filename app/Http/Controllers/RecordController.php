<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class RecordController extends BaseController
{
    public function index (Request $request){
        $record = Record::all();
        return $this->success($record,'all records');
    }
}
