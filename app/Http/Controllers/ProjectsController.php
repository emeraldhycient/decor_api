<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Projects;


class ProjectsController extends Controller
{
    //

    public function createProject(Request $request){
            
            $data = $request->validate(
                [
                    'slug' => 'required|string|unique:Projects|max:255',
                    'project_status' => 'required|string|max:255',
                    'project_date' => 'required|string|max:255',
                    'images' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                    'description' => 'required|string',
                ]
            );

            $images =[];
            if($request->hasfile('images'))
            {
               foreach($request->file('images') as $file)
               {
                $imageName = rand().'.'.$file->extension();  
                $file->move(public_path('images'), $imageName);
                $images[] = $imageName;
               }
            }else{
                return response([
                    'message' => 'No file selected'
                ], 401);
            }

            /*if($request->hasfile('filename'))
            {
   
               foreach($request->file('filename') as $image)
               {
                   $name=$image->getClientOriginalName();
                   $image->move(public_path().'/images/', $name);  
                   $images[] = $name;  
               }
            }
   */

            $project = Projects::updateOrCreate([
                'slug' => Str::slug($data['slug']),
                'project_status' => $data['project_status'],
                'project_date' => $data['project_date'],
                'images' => json_encode($images),
                'description' => $data['description'],
            ]);
    
            return response([
                'status' => 'success',
                'project' => $project
            ] , 200);
    }


    public function getProjects(){
            $projects = Projects::all();
            return response([
            'status' => 'success',
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
            'project' => $project
        ] , 200);
    }

    public function deleteProject($slug){
        $project = Projects::where('slug', $slug)->firstOrFail();
        $project->delete();
        return response([
            'status' => 'success',
            'project' => $project
        ] , 200);
    }

    public static function getProjectsByStatus($status){
        if ($status == 'all') {
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