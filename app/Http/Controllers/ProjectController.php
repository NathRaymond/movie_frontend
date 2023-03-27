<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Stock;
use App\Models\ProjectLabour;
use App\Models\ProjectMaterial;
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
        return view('project.add_project', $data);
    }

    public function store_project(Request $request)
    {
        $input = $request->except('_token');

        try {
            $input['user_id'] = Auth::user()->id;
            Project::create($input);

            $item = $input['material_stock'];
            foreach ($item as $key => $item) {
                $project_material = new ProjectMaterial;
                $project_material->user_id = Auth::user()->id;
                $project_material->material_stock = $input['material_stock'][$key];
                $project_material->material_quantity = $input['material_quantity'][$key];
                $project_material->material_price = $input['material_price'][$key];
                $project_material->save();
            }

            $labour = $input['labour_name'];
            foreach ($labour as $labour_key => $item) {
                $project_labour = new ProjectLabour;
                $project_labour->user_id = Auth::user()->id;
                $project_labour->labour_name = $input['labour_name'][$labour_key];
                $project_labour->labour_amount = $input['labour_amount'][$labour_key];
                $project_labour->save();
            }

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
        $project = Project::find($request->id);
        if ($project) {
            $this->validate($request, [
                'project_name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'categories' => 'required',
            ]);

            $input = $request->all();
            $project->fill($input)->save();
            return redirect()->back()->with('message', 'project updated successfully');
        }
    }

    public function destroy_project(Request $request)
    {
        $id = $request->id;
        Project::find($id)->delete();
        return redirect()->back()
            ->with('success', 'project deleted successfully');
    }
}
