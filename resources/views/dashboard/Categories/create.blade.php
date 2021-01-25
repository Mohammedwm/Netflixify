@extends('layouts.dashboard.app')
@section('content')
    <h2>Categories</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('dashboard.categories.index')}}">categories</a></li>
            <li class="breadcrumb-item active">Add</li>
        </ol>
    </nav>
    <div class="tile mb-4">
        <form action="{{route('dashboard.categories.store')}}" method="post">
            @csrf
            @method('post')

            @include('dashboard.partials._errors')

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add </button>
            </div>
        </form>
    </div>
@endsection
