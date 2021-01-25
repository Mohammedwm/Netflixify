@extends('layouts.dashboard.app')
@section('content')
    <h2>Movies</h2>

    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('dashboard.movies.index')}}">Movies</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="tile mb-4">
                <form id="movie_properties" 
                action="{{route('dashboard.movies.update', ['movie' => $movie->id , 'type'=> 'update'] )}}" 
                enctype="multipart/form-data"
                method="post" >
                @csrf
                @method('put')     

                @include('dashboard.partials._errors')
                
                {{-- name --}}
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" id="movie_name" class="form-control" value="{{old('name', $movie->name)}}">
                </div>
                
                 {{-- description --}}
                 <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{old('description', $movie->description)}}</textarea>                        
                </div>

                 {{-- poster --}}
                 <div class="form-group">
                    <label>Poster</label>
                    <input type="file" name="poster" class="form-control">
                    <img src="{{ $movie->poster_path}}" style="margin-top:10px; width:255px; height:378px" alt="">
                </div>

                 {{-- image --}}
                 <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                    <img src="{{ $movie->image_path}}" style="margin-top:10px; width:300px; height:300px" alt="">
                </div>

                {{-- categories --}}
                <div class="form-group">
                    <label>Category</label>
                    <select name="categories[]" class="form-control select2" multiple>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ in_array($category->id ,$movie->categories->pluck('id')->toArray()) ? 'selected' : '' }} > 
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- year --}}
                <div class="form-group">
                    <label>Year</label>
                    <input type="text" name="year" class="form-control" value="{{ old('year',$movie->year) }}">
                </div>

                {{-- rating --}}
                <div class="form-group">
                    <label>Rating</label> 
                    <input type="number" min="1" max="10" name="rating" class="form-control" value="{{ old('rating',$movie->rating) }}">
                </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-Edit"></i> Edit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection