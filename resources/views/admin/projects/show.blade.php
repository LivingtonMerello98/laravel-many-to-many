@extends('layouts.admin') 

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-5 d-flex justify-content-center align-items-center">
                <div style="width: 70%; height:auto;">
                    <img src="{{ $project->image }}" alt="{{ $project->title }}" style="width: 100%; min-width: 50px;border-radius:0.5rem">
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="text-white text-uppercase mb-3">{{ $project->title }}</h3>

                <p class="text-white">{{ $project->description }}</p>

                <p class="text-white">
                    <strong>Category: </strong>
                    {{ $project->category ? $project->category->title : 'Categoria non definita' }}
                </p>

                <p class="text-white"><strong>Languages:</strong> {{ $project->languages }}</p>

                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-warning rounded-1">
                    <i class="fa-solid fa-pencil" style="color: #ffffff;"></i>
                </a>
                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-1">
                        <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection



