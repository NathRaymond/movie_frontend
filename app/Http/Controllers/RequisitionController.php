<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Stock;
use App\Models\Requisition;
use Illuminate\Support\Facades\Auth;

class RequisitionController extends Controller
{
    public function requisition_index(Request $request)
    {
        $data['contractors'] = Project::all();
        $data['stocks'] = Stock::all();
        return view('requisition.requisition', $data);
    }

    public function customerPendingrequisition(Request $request)
    {
        $pp['data']  = Project::where('id', $request->id)->where('approval_status', 1)->select('project_code')->distinct()->get();
        return json_encode($pp);
    }

    public function requistionDeliveryById(Request $request)
    {
        try {
            $value = Project::all();
            return api_request_response(
                "ok",
                "Search Complete!",
                success_status_code(),
                [$value]
            );
        } catch (\Exception $exception) {
            return api_request_response(
                'error',
                $exception->getMessage(),
                bad_response_status_code()
            );
        }
    }
}
