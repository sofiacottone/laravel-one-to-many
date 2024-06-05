<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        $types = Type::all();

        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|min:5|max:250|unique:projects',
                'client_name' => 'nullable|max:95',
                'summary' => 'nullable|min:5',
                'cover_image' => 'nullable|image|max:512',
                'type_id' => 'nullable|exists:types,id'
            ]
        );

        $formData = $request->all();

        // verify if the user updated an image
        if ($request->hasFile('cover_image')) {
            // upload the image in the right folder
            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);
            // save the img path in the db column
            $formData['cover_image'] = $img_path;
        }

        $newProject = new Project();
        $newProject->fill($formData);
        $newProject->slug = Str::slug($newProject->name, '-');
        $newProject->save();

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
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Project $project)
    {
        $types = Type::all();

        return view('admin.projects.edit', compact('project', 'types'));
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
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'min:5',
                    'max:250',
                    Rule::unique('projects')->ignore($project),

                ],
                'client_name' => 'nullable|max:95',
                'summary' => 'nullable|min:5',
                'cover_image' => 'nullable|image|max:512',
                'type_id' => 'nullable|exists:types,id'
            ]
        );

        $formData = $request->all();

        // verify if the user updated an image
        if ($request->hasFile('cover_image')) {

            if ($project->cover_image) {
                // delete previous images
                Storage::delete($project->cover_image);
            }
            // upload the image in the right folder
            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);
            // save the img path in the db column
            $formData['cover_image'] = $img_path;
        }

        $project->slug = Str::slug($formData['name'], '-');
        $project->update($formData);

        return redirect()->route('admin.projects.show', compact('project'));
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

        return redirect()->route('admin.projects.index');
    }

    /**
     * Display a listing of the deleted resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $projects = Project::onlyTrashed()->get();

        return view('admin.projects.deleted', compact('projects'));
    }

    /**
     * Restore a specified soft deleted resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore(Project $project)
    {
        $project->restore();

        return redirect()->route('admin.projects.index');
    }

    /**
     * Permanently delete a specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Project $project)
    {
        $project->forceDelete();

        return redirect()->route('admin.projects.index');
    }
}
