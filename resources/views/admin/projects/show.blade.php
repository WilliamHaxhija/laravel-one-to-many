@extends('layouts.admin')

@section('content')
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <div>
        <h2 class="my-3">
            {{ $project->name }}
        </h2>
        <div>
            <strong>ID: </strong>{{ $project->id }}
        </div>
        <div>
            <strong>Created: </strong>{{ $project->created_at }}
        </div>
        <div>
            <strong>Updated: </strong>{{ $project->updated_at }}
        </div>
        <div>
            <strong>Client Name: </strong>{{ $project->client_name }}
        </div>
        <div>
            <strong>Slug: </strong>{{ $project->slug }}
        </div>
        @if ($project->cover_image)
            <div class="w-75 my-3">
                <strong>Image:</strong>
                <img class="w-100" src="{{ asset('storage/'. $project->cover_image) }}" alt="{{ $project->name }}">    
            </div>    
        @endif
        <div>
            <strong>Summary: </strong>
            <p>{{ $project->summary }}</p>
        </div>
        <div class="d-flex">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-primary btn-sm" tabindex="-1" role="button" aria-disabled="true"><i class="fa-regular fa-rectangle-list"></i></a>
            <a href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}" class="btn btn-secondary btn-sm mx-2" tabindex="-1" role="button" aria-disabled="true"><i class="fa-solid fa-pen-to-square"></i></a>
            <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
            </form>
        </div>
    </div>
@endsection
