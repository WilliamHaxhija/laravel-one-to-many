@extends('layouts.admin')

@section('content')
    <div>
        @if (session()->has('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <h2 class="my-3">Projects</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Client Name</th>
                <th>Slug</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->client_name }}</td>
                    <td>{{ $project->slug }}</td>
                    <td>{{ $project->created_at }}</td>
                    <td>{{ $project->updated_at }}</td>
                    <td class="d-flex">
                        <a href="{{ route('admin.projects.show', ['project' => $project->slug]) }}" class="btn btn-outline-info btn-sm" tabindex="-1" role="button" aria-disabled="true"><i class="fa-solid fa-circle-info"></i></a>
                        <a href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}" class="btn btn-outline-secondary btn-sm mx-1" tabindex="-1" role="button" aria-disabled="true"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
