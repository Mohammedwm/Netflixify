@extends('layouts.dashboard.app')

@push('styles')

    <style>
        #movie_upload-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 25vh;
            flex-direction: column;
            cursor: pointer;
            border: 1px solid black;
        }
    </style>
    
@endpush
@section('content')
    <h2>Movies</h2>

    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('dashboard.movies.index')}}">Movies</a></li>
        <li class="breadcrumb-item active">Add</li>
    </Ul>

    <div class="row">
        <div class="col-md-12">
            <div class="tile mb-4">

                <div id="movie_upload-wrapper"
                    onclick="document.getElementById('movie_file-input').click()"
                    style="display : {{ $errors->any() ? 'none' : 'flex'}}"
                    >

                    <i class="fa fa-video-camera fa-2x"></i>
                    <p>Click to Upload</p>
                </div>

                <input type="file" name="" 
                    data-movie-id="{{$movie->id}}" 
                    data-url = "{{ route('dashboard.movies.store') }}"
                    id="movie_file-input" style="display:none;">
                <form id="movie_properties" 
                    action="{{route('dashboard.movies.update', ['movie' => $movie->id , 'type'=> 'publish'] )}}" 
                    enctype="multipart/form-data"
                    method="post" style="display : {{ $errors->any() ? 'block' : 'none'}}">
                    @csrf
                    @method('put')     

                    @include('dashboard.partials._errors')
                    
                    {{-- progress bar --}}
                    <div class="form-group" style="display : {{ $errors->any() ? 'none' : 'block'}}">
                        <label id="movie_upload-status">Uploading</label>
                        <div class="progress">
                            <div class="progress-bar" id="movie_upload-progress" role="progressbar"></div>
                          </div>
                    </div>

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
                    </div>

                     {{-- image --}}
                     <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
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
                        <button type="submit" id="movie_submit-btn" style="display : {{ $errors->any() ? 'block' : 'none'}}"
                             class="btn btn-primary"><i class="fa fa-plus"></i> Publish </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    
@endsection
