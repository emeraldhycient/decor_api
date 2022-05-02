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
                    'slug' => 'required|string|unique|max:255',
                    'project_status' => 'required|string|max:255',
                    'project_date' => 'required|string|max:255',
                    'images' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                    'Description' => 'required|integer',
                ]
            );

            $images =[];
            if($request->hasfile('images'))
            {
               foreach($request->file('images') as $key => $file)
               {
                $imageName = rand().'.'.$file->extension();  
                $request->image->move(public_path('images'), $imageName);
                $insert[$key]['path'] = $$imageName;
               }
            }

            $project = Projects::updateOrCreate([
                'slug' => Str::slug($data['slug']),
                'project_status' => $data['project_status'],
                'project_date' => $data['project_date'],
                'images' => $images,
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
        ] , 200);
    }

    public function getProject($slug){
        $project = Projects::where('slug', $slug)->firstOrFail();
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


}