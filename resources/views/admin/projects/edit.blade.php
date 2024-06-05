@extends('layouts.admin')

@section('content')
    <h2 class="mb-3">Edit: {{ $project->name }}</h2>

    <form action="{{ route('admin.projects.update', ['project' => $project->slug]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Project name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}">
            @error('name')
                <div class="text-danger ps-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="client-name" class="form-label">Client name</label>
            <input type="text" class="form-control" id="client-name" name="client_name"
                value="{{ old('client_name', $project->client_name) }}">
            @error('client_name')
                <div class="text-danger ps-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="client-name" class="form-label">Client name</label>
            <select class="form-select" id="type-id" name="type_id" aria-label="Project type select">
                <option value="">Select project type</option>
                @foreach ($types as $type)
                    <option @selected($type->id == old('type_id', $project->type_id)) value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('type_id')
                <div class="text-danger ps-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cover-image" class="form-label">Cover image</label>
            <input type="file" class="form-control" id="cover-image" name="cover_image">
            @error('cover_image')
                <div class="text-danger ps-2">{{ $message }}</div>
            @enderror
            @if ($project->cover_image)
                <div class="w-50 mt-3">
                    <img src="{{ asset('storage/' . $project->cover_image) }}" class="img-fluid"
                        alt="{{ $project->name }}">
                </div>
            @else
                <div class="ms-2">No uploaded images found.</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="summary" class="form-label">Summary</label>
            <textarea class="form-control" id="summary" rows="10" name="summary">{{ old('summary', $project->summary) }}</textarea>
            @error('summary')
                <div class="text-danger ps-2">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{ route('admin.projects.show', ['project' => $project->slug]) }}" class="btn btn-outline-secondary mb-3">
            Back
        </a>
        <button type="submit" class="btn btn-primary mb-3">Edit</button>
    </form>
@endsection
