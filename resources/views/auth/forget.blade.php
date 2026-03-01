@include('layout.app')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow p-4" style="width: 380px;">
        <h3 class="text-center mb-4"></h3>
        <form action="{{ route('forget.password.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your email">
            </div>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            
            <button type="submit" class="btn btn-primary w-100 mt-3">Send Code </button>
        </form>
    </div>
</div>