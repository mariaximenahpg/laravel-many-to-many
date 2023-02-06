<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Support\Str;
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
        // dd($projects);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data= $request->validated();

        $new_project = new Project();
        $new_project->fill($data);
        $new_project->slug = Str::slug($new_project->project_name);

        if ( isset($data['cover_image'])){
            $data['cover_image'] = Storage::disk('public')->put('uploads', $data['cover_image']);
        }
        
        $new_project->save();

        if(isset($data['technologies'])){
            $new_project->technologies()->sync($data['technologies']);
        }

        return redirect()->route('admin.projects.index')->with('message', 'Nuovo progetto aggiunto con successo');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        // dd($request);
        // modifica dei dati
        $data = $request->validated();

        $old_project_name = $project->project_name;

        $project->slug = Str::slug($data['project_name']);

        if(isset($data['cover_image'])) {
            if($project->cover_image){
                Storage::disk('public')->delete($project->cover_image);
            }
            $data['cover_image'] = Storage::disk('public')->put('uploads', $data['cover_image']);
        }
        // modifica della risorsa
        $project->update($data);

        if(isset($data['technologies'])){
            $project->technologies()->sync($data['technologies']);
        } else {
            $project->technologies()->sync([]);
        } 
        
        // redirect
        return redirect()->route('admin.projects.index')->with('message', "Il progetto $old_project_name è stato modificato con successo");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $old_project_name = $project->project_name;

        if( $project->cover_image ) {
            Storage::disk('public')->delete($project->cover_image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('message', "Il progetto $old_project_name è stato cancellato con successo");

    }
}
