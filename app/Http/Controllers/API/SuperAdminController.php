<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    use ApiResponse;

    public function getInformation()
    {
        $todayTotal = Transaction::where('date',Carbon::now()->format('y-m-d'))->sum('total');
        $todayVisitor = Transaction::where('date',Carbon::now()->format('y-m-d'))->get('id')->count();
        $eachMonthTotal = Transaction::whereMonth('date',Carbon::now()->format('m'))->sum('total');
        $eachMonthVisit = Transaction::whereMonth('date',Carbon::now()->format('m'))->get('id')->count();
        $data = array(
            "todayTotal" => $todayTotal,
            "todayVisit" => $todayVisitor,
            "eachMonthTotal" => $eachMonthTotal,
            "eachMonthVisit" => $eachMonthVisit
        );
        return $this->successResponse("Dashboard",$data);
    }
    public function getMenu()
    {
        $data = Menu::with('categories')->get();
        return $this->successResponse('Data Menu', $data);
    }

    public function updateStatusMenu(Request $request, $id)
    {
        $status = $request->get('status');
        // dd($status);
        try {
                $menu = Menu::find($id);
                $menu->status = $menu->status == 'false' ? 'true' : 'false';
                $menu->update();
                return $this->emptyResponse("Status menu berhasil diubah");
        } catch (\Throwable $th) {
            return $this->internalErrorResponse($th->getMessage());
        }
    }

    public function updateMenu(Request $request,$id)
    {

        $input = $request->only(['price','name']);
        $menu = Menu::find($id);
        $menu->update($input);
        return $this->successResponse("Menu berhasil diubah",[$request]);
    }

    public function categoryList()
    {
        $categories = Category::all();
        return $this->successResponse("Data Kategori",$categories);
    }

    public function insertMenu(Request $request)
    {
        $input = $request->only(['name','price','category']);
        $menu = Category::where('name','LIKE','%'.$input['category'].'%')->first();
        $data = array(
            'name'=>$input['name'],
            'price' => $input['price'],
            'categories_id'=>$menu->id
        );
        Menu::create($data);
        return $this->successResponse("Data berhasil dimasukkan","");

    }
    public function insertCategory(Request $request)
    {
        $input = $request->only(['type','name']);
        Category::create($input);
        return $this->successResponse("Data berhasil dimasukkan","");
    }


}
