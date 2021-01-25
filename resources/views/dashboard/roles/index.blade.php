@extends('layouts.dashboard.app')
@section('content')
    <h2>Role</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Role</li>
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
                            @if (auth()->user()->hasPermission('create_roles'))
                                <a href="{{route('dashboard.roles.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add </a>
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
                @if($roles->count() > 0)
                    <table class="table table-hover table-bordered" id="tab">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Users counr</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $index=>$role)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach ($role->permissions as $permission)
                                    <h5 style="display: inline-block"><span class="badge badge-primary">{{ $permission->name }}</span></h5>
                                @endforeach
                            </td>
                            <td>{{ $role->users_count }}</td>
                            <td>
                                @if (auth()->user()->hasPermission('update_roles'))
                                    <a href="{{route('dashboard.roles.edit',$role->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                @else
                                    <a href="#" disabled="" class="btn btn-warning"><i class="fa fa-edit"></i> Edit </a>
                                @endif
                                
                                @if (auth()->user()->hasPermission('delete_roles'))
                                    <form method="post" action="{{route('dashboard.roles.destroy',$role->id)}}" style="display: inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> Delete </button>
                                    </form>
                                @else
                                    <a href="#" disabled="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                    {{$roles->appends(request()->query())->links() }}
                @else
                    <h3 style="font-weight: 400"> Sorry no record found</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
