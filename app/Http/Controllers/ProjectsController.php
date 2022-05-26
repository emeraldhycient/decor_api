<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Projects;


class ProjectsController extends Controller
{
    //

    public function create(Request $request){
            
            $data = $request->validate(
                [
                    'slug' => 'required|string|unique:projects|max:255',
                    'project_status' => 'required|string|max:255',
                    'project_date' => 'required|string|max:255',
                    'description' => 'required|string',
                ]
            );



            $insert = [];

            if($request->hasfile('images'))
         {
            foreach($request->file('images') as $key => $file)
            {
<<<<<<< HEAD
                $name = time().$key.Str::random(5).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('images'), $name);
                $insert[$key]['path'] = $name;
                /*$path = $file->store('public/images');
=======
                $path = $file->store('images');
>>>>>>> 2d5fcc9081ba0cc5cd5889724e3e765d9156a0ea
                $name = $file->getClientOriginalName();
                $insert[$key]['name'] = $name;
                $insert[$key]['path'] = $path; */
            }
         }

            $project = Projects::create([
                'slug' => Str::slug($data['slug']),
                'project_status' => $data['project_status'],
                'project_date' => $data['project_date'],
                'images' => $insert,
                'description' => $data['description'],
            ]);
    
            return response([
                'status' => 'success',
                'project' => $project
            ] , 200);
    }


    public function update(Request $request){
        $data = $request->validate(
            [
                'slug' => 'required|string|max:255',
                'project_status' => 'required|string|max:255',
                'project_date' => 'required|string|max:255',
                'description' => 'required|string',
            ]
        );

        $project = Projects::where('slug', $data['slug'])->first();

        $project->project_status = $data['project_status'];
        $project->project_date = $data['project_date'];
        $project->description = $data['description'];

        $project->save();

        return response([
            'status' => 'success',
            'message' => 'Projects updated successfully',
            'project' => $project
        ] , 200);

    }

    public function getProjects(){
            $projects = Projects::all();
            return response([
            'status' => 'success',
             'message' => 'Projects retrieved successfully',
            'projects' => $projects
        ], 200);
       
    }

    public function getProject($slug){
        $project = Projects::where('slug', $slug)->first();

        if(!$project){
            return response([
                'status' => 'error',
                'message' => 'Project not found'
            ] , 404);
        }
        
        return response([
            'status' => 'success',
            'message' => 'Projects retrieved successfully',
            'project' => $project
        ] , 200);
    }

    public function deleteProject($slug){
        $project = Projects::where('slug', $slug)->firstOrFail();
        $project->delete();
        return response([
            'status' => 'success',
            'message' => 'Project deleted successfully'
        ] , 200);
    }

    public static function getProjectsByStatus($status){
        if ($status === 'all') {
            $projects = Projects::all();
            return response([
            'status' => 'success',
            'projects' => $projects
        ], 200);
        }else{
            $projects = Projects::where('project_status', $status)->get();
            return response([
            'status' => 'success',
            'projects' => $projects
        ], 200);
        }
    }


}
