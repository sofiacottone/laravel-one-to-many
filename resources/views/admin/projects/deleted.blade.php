@extends('layouts.admin')

@section('content')
    <h2>Deleted projects</h2>

    @if (count($projects) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Client name</th>
                    <th>Created</th>
                    <th>Deleted</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->client_name }}</td>
                        <td>{{ $project->created_at }}</td>
                        <td>{{ $project->deleted_at }}</td>

                        {{-- actions  --}}
                        <td>
                            <div class="hstack justify-content-center gap-2 text-center">

                                <a href="{{ route('admin.projects.restore', ['project' => $project->id]) }}"
                                    class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                </a>

                                <form action="{{ route('admin.projects.forceDelete', ['project' => $project->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" data-project-title="{{ $project->name }}"
                                        class="js-delete-btn btn btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="mt-3 ms-2">No deleted projects.</div>
    @endif

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
