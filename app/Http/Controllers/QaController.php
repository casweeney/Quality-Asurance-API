<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Qa;

class QaController extends Controller
{
    public function submitProject(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'project_name'  => 'required|string',
            'project_url' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->first()
            ], 406);
        }

        $project = new Project;
        $project->project_name = $request->project_name;
        $project->user_id = auth()->user()->id;
        $project->project_url = $request->project_url;
        $project->status = "pending";
        $project->save();

        return response()->json($project, 200);

    }

    public function fetchUserProjects()
    {
        $projects = Project::where('user_id', auth()->user()->id)->latest()->get();

        if(count($projects) > 0){
            return response()->json([
                'status' => 'success',
                'projects' => $projects
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'projects' => [],
                'message' => 'No project added'
            ]);
        }
    }

    public function fetchAllProjects()
    {
        $projects = Project::latest()->get();

        if(count($projects) > 0){
            return response()->json([
                'status' => 'success',
                'projects' => $projects
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'projects' => [],
                'message' => 'No project added'
            ]);
        }
    }

    public function fetchProjectDetails($id)
    {
        $project = Project::with('qas')->where(['id' => $id])->first();

        return response()->json($project);
    }

    public function submitQa(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'qa_url'  => 'required|string',
            'qa_comment' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->first()
            ], 406);
        }

        $qa = new Qa;
        $qa->user_id = auth()->user()->id;
        $qa->project_id = $request->project_id;
        $qa->qa_url = $request->qa_url;
        $qa->qa_comment = $request->qa_comment;
        $qa->status = 'Pending';
        $qa->save();

        return response()->json($qa, 200);
    }

    public function addDevComment(Request $request, $qaID)
    {
        $validator = \Validator::make($request->all(), [
            'dev_comment'  => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->first()
            ], 406);
        }

        $qa = Qa::where(['id' => $qaID])->first();
        $qa->developer_comment = $request->dev_comment;
        $qa->status = $request->status;
        $qa->save();

        return response()->json($qa, 200);        
    }

    public function updateProjectStatus(Request $request, $project_id)
    {
        $project = Project::where(['id' => $project_id])->first();
        $project->status = $request->status;
        $project->save();

        return response()->json($project, 200);
    }
}
