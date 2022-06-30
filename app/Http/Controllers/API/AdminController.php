<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Menu;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use ApiResponse;
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
}
