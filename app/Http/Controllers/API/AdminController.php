<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use ApiResponse;
    public function orderList()
    {
        $date = Carbon::now()->format('y-m-d');
        $menu = Menu::where('status', '=', 'true')->get();
        $order = Transaction::where('is_ordered', '=', 'true')->where('date', '=', $date)->where('is_payed', '=', 'false')->get();
        return $this->successResponse("Data order ".$date,$order);
    }

    public function tableList()
    {
        $table = Table::all();
        return $this->successResponse("Data Meja",$table);
    }

    public function tableDetail($table_id)
    {
        $order = TransactionDetail::with('menu')->where('table_id','=',$table_id)->where('is_payed', '=', 'false')->get();
        return $this->successResponse("Detail Pesanan Meja ".$table_id,$order);
    }

    public function orderDetail($trans_id)
    {
        $detail = TransactionDetail::with('menu')->where('transaction_id','=',$trans_id)->where('is_payed', '=', 'false')->get();
        return $this->successResponse("Detail Pesanan",$detail);
    }

    public function getTotal($table_id)
    {
        $date = Carbon::now()->format('y-m-d');
        $total = Transaction::where('table_id','=',$table_id)->where('date', '=', $date)->where('is_payed', '=', 'false')->sum('total');
        return $this->successResponse("Total Transaksi",array('total'=>$total));

    }

    public function tablePay(Request $request,$table_id)
    {
        $date = Carbon::now()->format('y-m-d');
        $input = $request->only(['pay']);
        $total = TransactionDetail::where('table_id','=',$table_id)->where('is_payed', '=', 'false')->sum('total');
        if ($input['pay'] >= $total) {
            $data = array(
                'total'=>$total,
                'pay'=>$input['pay'],
                'back'=>$input['pay']-$total
            );
            Transaction::where('date', '=', $date)->where('is_payed', '=', 'false')->where('table_id','=',$table_id)->update(['is_payed'=>'true']);
            // TransactionDetail::where('table_id','=',$table_id)->update(['is_payed'=>'true']);
            return $this->successResponse('Pesanan berhasil dibayar',$data);
        }else {
            return $this->successResponse("Maaf, uang tidak cukup","",402);
        }

    }
}
