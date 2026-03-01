@include('layout.app')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow p-4" style="width: 380px;">
        <h3 class="text-center mb-4">Reset Password</h3>
        <form action="{{ route('reset.password.submit') }}" method="POST">
            @csrf
        <div class="mb-3">
                            <input type="hidden" name="code" value="{{ session('code') }}">
                            <input type="hidden" name="email" value="{{ session('email') }}">
                            <label class="form-label">New Password </label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control">
                        </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Update</button>
        </form>
    </div>
</div>