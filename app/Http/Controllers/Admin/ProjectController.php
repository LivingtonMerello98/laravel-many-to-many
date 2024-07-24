<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

//aprire ticket per le request

class ProjectController extends Controller
{
    public function index()
    {
        $counter = 1;
        //orm per tutti i record del db -> $projects
        //da all() a latest per poter usare il paginator
        //consultare Providers/AppServiceProvider
        $projects = Project::latest()->paginate(5);
        // rotta per la vista
        return view('admin.projects.index', compact('projects', 'counter'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        //validazione dati provvisoria
        $validated = $request->validate([
            'url' => 'required',
            'image' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'languages' => 'required|array',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Genera automaticamente il campo 'slug' dal titolo
        $validated['slug'] = Str::slug($request->title);

        $validated['languages'] = implode(',', $validated['languages']);


        Project::create($validated);

        return redirect()->route('admin.projects.index'); //da rivedere
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

        //dd($request->all());
        // Validazione dati provvisoria
        $validated = $request->validate([
            'url' => 'required',
            'image' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'languages' => 'required|array',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Genera automaticamente il campo 'slug' dal titolo
        $validated['slug'] = Str::slug($request->title);

        $validated['languages'] = implode(',', $validated['languages']);

        // trova il progetto esistente e lo aggiorna
        $project = Project::findOrFail($id);
        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Progetto aggiornato con successo'); //da rivedere
    }


    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index');
    }
}
