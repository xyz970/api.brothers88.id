<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    use ApiResponse;
    
    public function getOrder()
    {
        $date = Carbon::now()->format('y-m-d');
        $data = Transaction::where('is_ordered','=','true')->where('date','=',$date)->where('is_valid','=','false')->get();
        return $this->successResponse('Data order',$data);
    }

    public function validasi($id)
    {
        $order = Transaction::find($id);
        $order->is_valid = 'true';
        $order->update();
        return $this->emptyResponse('Data berhasil divalidasi');
    }

    public function detail($id)
    {
        $order = TransactionDetail::with(['menu'])->where('transaction_id','=',$id)->get();
        return $this->successResponse("Detail Order",$order);
    }

}
