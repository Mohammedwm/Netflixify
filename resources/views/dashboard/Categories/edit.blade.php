@extends('layouts.dashboard.app')
@section('content')
    <h2>Categories</h2>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('dashboard.categories.index')}}">categories</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
    <div class="tile mb-4">
        <form action="{{route('dashboard.categories.update',$category->id)}}" method="post">
            @csrf
            @method('put')

            @include('dashboard.partials._errors')

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{old('name',$category->name)}}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-Edit"></i> Edit </button>
            </div>
        </form>
    </div>
@endsection
