@include('layout.app')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow p-4" style="width: 380px;">
        <h3 class="text-center mb-4">Login</h3>
        <form action="{{ route('login.submit')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your email">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter your password">
            </div>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <a class="link_under_light" href="{{ route('forget') }}">Forget Password -></a>
            <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
        </form>
    </div>
</div>