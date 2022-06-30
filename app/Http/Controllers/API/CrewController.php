<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    use ApiResponse;
    
    public function getOrder()
    {
        $date = Carbon::now()->format('y-m-d');
        $data = Transaction::where('is_ordered','=','true')->where('date','=',$date)->where('is_valid','=','false')->get();
        $this->successResponse('Data order',$data);
    }

    public function finalisasi($id)
    {
        $order = Transaction::where('id','=',$id)->first();
        $order->is_valid = 'true';
        $order->update();
        $this->emptyResponse('Data berhasil divalidasi');
    }

}
