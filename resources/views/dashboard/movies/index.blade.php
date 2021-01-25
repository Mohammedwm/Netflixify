
@extends('layouts.dashboard.app')
@section('content')

    <h2>Movies</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Movies</li>
        </ol>
    </nav>

    <div class="tile mb-4">
        
        <div class="row">
            <div class="col-12">
                <form action="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                            <input type="text" name="search" autofocus class="form-control" placeholder="search" value="{{request()->search}}">
                            </div>
                        </div><!-- end of col -->
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search </button>
                            @if (auth()->user()->hasPermission('create_movies'))
                                <a href="{{route('dashboard.movies.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add </a>
                            @else
                                <a href="#" disabled="" class="btn btn-primary"><i class="fa fa-plus"></i> Add </a>
                            @endif
                        </div><!-- end of col -->
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Categories</th>
                            <th>Year</th>
                            <th>Rating</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($movies as $index=>$movie)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $movie->name }}</td>
                            <td>{{ Str::limit($movie->description, 40)  }}</td>
                            <td>
                                @foreach ($movie->categories as $category)
                                    <h5 style="display: inline-block"><span class="badge badge-primary">{{ $category->name }}</span></h5>
                                @endforeach
                            </td>
                            <td>{{ $movie->year }}</td>
                            <td>{{ $movie->rating }}</td>
                            <td>
                                @if (auth()->user()->hasPermission('update_movies'))
                                    <a style="display: inline-block" href="{{route('dashboard.movies.edit',$movie->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                @else
                                    <a style="display: inline-block" href="#" disabled="" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit </a>
                                @endif

                                @if (auth()->user()->hasPermission('delete_movies'))
                                    <form  method="post" action="{{route('dashboard.movies.destroy',$movie->id)}}" style="display: inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> Delete </button>
                                    </form>
                                @else
                                    <a style="display: inline-block" href="#" disabled="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete </a>
                                @endif   
                            </td>
                        </tr>
                    @endforeach            
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection
