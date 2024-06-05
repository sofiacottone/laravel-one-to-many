@extends('layouts.admin')

@section('content')
    <div>
        <div class="hstack justify-content-between">
            <h2>{{ $project->name }}</h2>
            <div class="hstack gap-2">
                <a href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}" class="btn btn-outline-secondary">
                    Edit
                </a>

                <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" data-project-title="{{ $project->name }}"
                        class="js-delete-btn btn btn-outline-danger">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        <div><span class="fw-bold">ID: </span>{{ $project->id }}</div>
        <div><span class="fw-bold">Slug: </span>{{ $project->slug }}</div>
        <div><span class="fw-bold">Client: </span>{{ $project->client_name }}</div>
        <div><span class="fw-bold">Type: </span>{{ $project->type ? $project->type->name : 'No type selected.' }}</div>
        <div><span class="fw-bold">Created: </span>{{ $project->created_at }}</div>
        <div><span class="fw-bold">Updated: </span>{{ $project->updated_at }}</div>
        @if ($project->cover_image)
            <div class="w-50 mt-3">
                <img src="{{ asset('storage/' . $project->cover_image) }}" class="img-fluid" alt="{{ $project->name }}">
            </div>
        @endif
        <div class="mt-5">{{ $project->summary }}</div>
    </div>

    {{-- modal  --}}
    <div id="confirmDeleteModal" class="ms-modal">

        {{-- Modal content --}}
        <div class="ms-modal-content">
            <div class="hstack align-items-center justify-content-between mb-3">
                <div class="hstack align-items-center justify-content-center gap-2">
                    <img src="https://img.icons8.com/ios/40/000000/box-important--v1.png" alt="box-important--v1" />
                    <div class="fs-3">Confirm delete</div>
                </div>
                <div class="ms-close">&times;</div>
            </div>
            <div class="ms-modal-body"></div>
            <div class="hstack justify-content-end gap-2">
                <button class="ms-close-btn btn btn-secondary">Cancel</button>
                <button id="modal-confirm" class="btn btn-danger">Delete</button>
            </div>
        </div>

    </div>
@endsection
