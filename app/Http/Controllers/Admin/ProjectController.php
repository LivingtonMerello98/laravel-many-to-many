<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

//aprire ticket per le request

class ProjectController extends Controller
{
    public function index()
    {
        $counter = 1;
        //da all() a latest per poter usare il paginator
        //consultare Providers/AppServiceProvider
        $projects = Project::latest()->paginate(5);


        return view('admin.projects.index', compact('projects', 'counter'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validazione dei dati
        $validated = $request->validate([
            'url' => 'nullable',
            'cover' => 'nullable|image|max:4048', // 
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $validated['slug'] = Str::slug($request->title);

        $img_path = Storage::put('uploads', $validated['cover']);

        $validated['cover'] = $img_path;


        Project::create($validated);

        return redirect()->route('admin.projects.index');
    }




    //dettaglio 
    public function show($id)
    {
        $project = Project::with('category')->find($id);

        if (!$project) {
            return redirect()->route('admin.projects.index')->with('error', 'Progetto non trovato.');
        }

        return view('admin.projects.show', compact('project'));
    }


    //modifiche
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $categories = Category::all();

        return view('admin.projects.edit', compact('project', 'categories'));
    }



    //aggiornamento
    public function update(Request $request, $id)
    {


        $validated = $request->validate([
            'url' => 'required',
            'cover' => 'nullable',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $validated['slug'] = Str::slug($request->title);

        $project = Project::findOrFail($id);


        // Controllo se c'è una cover e la aggiorno
        if ($request->hasFile('cover')) {
            // Cancella il vecchio file di copertura se esiste
            if ($project->cover && Storage::exists($project->cover)) {
                Storage::delete($project->cover);
            }

            $img_path = Storage::put('uploads', $validated['cover']);
            $validated['cover'] = $img_path;
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Progetto aggiornato con successo'); //da rivedere
    }


    public function destroy(Project $project)
    {


        if ($project->cover) {
            Storage::delete($project->cover);
        }

        //dd($project->cover);
        $project_title = $project->title;
        $project->delete();

        return redirect()->route('admin.projects.index')->with('succes', $project_title . '-Project delete');
    }
}
