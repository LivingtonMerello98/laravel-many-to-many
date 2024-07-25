@extends('layouts.admin') 

{{-- edit projects --}}
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-md-5 d-flex justify-content-center align-items-center">
            
        </div>
        <div class="col-md-7">
            <h3 class="text-white text-uppercase">Edit Project</h3>
            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group mb-3">
                    <label for="url" class="text-white">Url del sito</label>
                    <input type="text" name="url" id="url" class="form-control" value="{{ old('url', $project->url) }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="image" class="text-white">Immagine del sito</label>
                    <input type="text" name="image" id="image" class="form-control" value="{{ old('image', $project->image) }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="title" class="text-white">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $project->title) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="categories" class="text-white">Type:</label>
                    <select class="form-select" aria-label="Default select example" name="category_id">
                        <option value="" disabled>seleziona categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="description" class="text-white">Description</label>
                    <textarea name="description" id="description" class="form-control " rows="7">{{ old('description', $project->description) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
