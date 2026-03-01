@extends('layout.app')

@section('title', 'User Profile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">User Profile</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Name</strong>
                            <span>{{ $user->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Email</strong>
                            <span>{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Role</strong>
                            <span>{{ $user->role }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Joined</strong>
                            <span>{{ $user->created_at->format('Y-m-d') }}</span>
                        </li>
                    </ul>
                    <div class="mt-4 text-center">
                        <a href="{{ route('profile.update.form') }}" class="btn btn-primary px-4">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
