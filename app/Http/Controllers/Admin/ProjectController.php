<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();


        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->all();

        $this->validation($formData);

        if ($request->hasFile('cover_image')) {
            $img_path = Storage::disk('public')->put('projects_images', $formData['cover_image']);
            $formData['cover_image'] = $img_path;
        }
        
        $newProject = new Project();
        $newProject->fill($formData);
        $newProject->slug = Str::slug($newProject->name);

        $newProject->save();

        session()->flash('message', $newProject->name . ' successfully created.');

        return redirect()->route('admin.projects.show', ['project' => $newProject->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return  view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $formData = $request->all();

        $this->validation($formData);

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }
            $img_path = Storage::disk('public')->put('projects_images', $formData['cover_image']);
            $formData['cover_image'] = $img_path;
        }
        
        $project->fill($formData);
        $project->slug = Str::slug($project->name);

        $project->update();

        session()->flash('message', $project->name . ' successfully updated.');

        return redirect()->route('admin.projects.show', ['project' => $project->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        
        // session()->flash('message', $project->name . ' successfully deleted.');

        return redirect()->route('admin.projects.index')->with('message', $project->name . ' successfully deleted.');
    }

    private function validation($data) {
        $validator = Validator::Make(
            $data,
            [
                'name'=> 'required|min:5|max:50',
                'summary' => 'min:15|max:2000',
                'client_name' => 'required',
                'cover_image' => 'nullable|image'  //|max:256
            ]
        )->validate();
        return $validator;
    }
}
