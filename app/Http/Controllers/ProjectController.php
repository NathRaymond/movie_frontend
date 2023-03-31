<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Stock;
use App\Models\ProjectLabour;
use App\Models\ProjectMaterial;
use App\Models\Contractor;
use App\Models\Requisition;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function project_index(Request $request)
    {
        $data['projects'] = Project::all();
        return view('project.project_page', $data);
    }

    public function add_project(Request $request)
    {
        $data['projects'] = Project::all();
        $data['stocks'] = Stock::all();
        $data['contractors'] = Contractor::all();
        return view('project.add_project', $data);
    }

    public function store_project(Request $request)
    {
        $input = $request->except('_token');
        try {
            DB::beginTransaction();
            $orders = Project::select('project_name', 'project_description', 'id')->distinct()->get();
            $count = count($orders);
            $figure = $count + 1;
            $length = strlen($figure);
            if ($length == 1) {
                $code = "000" . $figure;
            }
            if ($length == 2) {
                $code = "00" . $figure;
            }
            if ($length == 3) {
                $code = "0" . $figure;
            }
            if ($length == 4) {
                $code =  $figure;
            }
            $month = now()->format('m');
            $uuid = "PR" . '-' . $month . '-' . rand(1000, 9999) . '-' . $code;

            $project = new Project;
            $project->user_id = Auth::user()->id;

            $project->project_name = $input['project_name'];
            $project->project_description = $input['project_description'];
            $project->project_start_date = $input['project_start_date'];
            $project->project_end_date = $input['project_end_date'];
            $project->project_contractor = $input['project_contractor'];
            $project->project_estimate = $input['project_estimate'];
            $project->project_code = $uuid;
            $project->status = 0;
            $project->approval_status = 0;
            $project->save();

            $item = $input['material_stock'];

            foreach ($item as $key => $item) {
                $project_material = new ProjectMaterial;
                $project_material->user_id = Auth::user()->id;
                $project_material->material_stock = $input['material_stock'][$key];
                $project_material->material_quantity = $input['material_quantity'][$key];
                $project_material->material_price = $input['material_price'][$key];
                $project_material->project_code = $uuid;
                $project_material->project_id = $project->id;
                $project_material->save();
            }

            $labour = $input['labour_name'];
            foreach ($labour as $labour_key => $item) {
                $project_labour = new ProjectLabour;
                $project_labour->user_id = Auth::user()->id;
                $project_labour->labour_name = $input['labour_name'][$labour_key];
                $project_labour->labour_amount = $input['labour_amount'][$labour_key];
                $project_labour->project_code = $uuid;
                $project_labour->project_id = $project->id;
                $project_labour->save();
            }
            DB::commit();
            return redirect()->back()->with('success', 'project created successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function getprojectInfor(Request $request)
    {
        $project = Project::where('id', $request->id)->first();
        return response()->json($project);
    }

    public function update_project(Request $request)
    {
        $input = $request->all();
        $id = $request->id;
        try {
            $project = Project::find($request->id);
            if ($project) {
                $this->validate($request, [
                    'project_name' => 'required',
                    'project_description' => 'required',
                    'project_start_date' => 'required',
                    'project_end_date' => 'required',
                    'project_contractor' => 'required',
                    'project_estimate' => 'required',
                ]);

                $project->fill($input)->save();
            }


            $materials = $request->input('material_stock');
            $code = $project->project_code;
            ProjectMaterial::where('project_code', $code)->delete();
            foreach ($materials as $key => $row) {
                $check =  ProjectMaterial::where('project_code', $code)->where('material_stock', $row)->first();
                if($check){
                    $material = ProjectMaterial::where('project_code', $code)->where('material_stock', $row)
                    ->update(['material_quantity' => $input['material_quantity'][$key], 'material_price' =>  $input['material_price'][$key]]);
                }else{
                    $project_material = new ProjectMaterial;
                    $project_material->user_id = Auth::user()->id;
                    $project_material->material_stock = $row;
                    $project_material->material_quantity = $input['material_quantity'][$key];
                    $project_material->material_price = $input['material_price'][$key];
                    $project_material->project_code = $code;
                    $project_material->save();
                }

            }
            $labours = $request->input('labour_name');
            ProjectLabour::where('project_code', $code)->delete();
            foreach ($labours as $key => $labour_row) {
                $labour = ProjectLabour::where('project_code', $code)->where('id', $input['labour_id'][$key])->first();
                if($labour){
                    $labour->update(['labour_name' => $input['labour_name'][$key], 'labour_amount' => $input['labour_amount'][$key]]);
                }else{
                    $project_labour = new ProjectLabour;
                    $project_labour->user_id = Auth::user()->id;
                    $project_labour->labour_name = $input['labour_name'][$key];
                    $project_labour->labour_amount = $input['labour_amount'][$key];
                    $project_labour->project_code = $code;
                    $project_labour->save();
                }
            }


            return redirect()->back()->with('message', 'project updated successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function destroy_project(Request $request)
    {
        $id = $request->id;
        Project::find($id)->delete();
        return redirect()->back()
            ->with('success', 'project deleted successfully');
    }

    public function projectDetails($id)
    {
        $data['project'] = $projectId = Project::find($id);
        $data['materials'] = ProjectMaterial::where('project_code', $projectId->project_code)->get();
        // dd($data['materials']);
        $data['labours'] = ProjectLabour::where('project_code', $projectId->project_code)->get();
        $data['stocks'] = Stock::all();
        $data['contractors'] = Contractor::all();
        return view('project.edit_project', $data);
    }

    public function project_app_decline(Request $request)
    {
        $updateProject = Project::where('id', $request->id)->update([
            'approval_status' => 2,
        ]);
        return api_request_response(
            'ok',
            'Request decline successfully ',
            success_status_code(),
            $updateProject
        );
    }
    public function project_app_approve(Request $request)
    {
        $updateProject = Project::where('id', $request->id)->update([
            'approval_status' => 1,
        ]);
        return api_request_response(
            'ok',
            'Request approved successfully ',
            success_status_code(),
            $updateProject
        );
    }
}
