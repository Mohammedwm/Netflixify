@extends('layouts.dashboard.app')
@section('content')
    <h2>Users</h2>

    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard.welcome')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('dashboard.users.index')}}">Users</a></li>
        <li class="breadcrumb-item active">Add</li>
    </Ul>

    <div class="row">
        <div class="col-md-12">
            <div class="tile mb-4">
                <form action="{{route('dashboard.users.store')}}" method="post">
                    @csrf
                    @method('post')
        
                    @include('dashboard.partials._errors')
        
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                    </div>
        
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" value="{{old('email')}}">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Password Confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Roles</label>
                        <select name="role_id" class="form-group select2">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection
