@include('layout.app')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow p-4" style="width: 380px;">
        <h3 class="text-center mb-4"></h3>
        <form action="{{ route('verify.code.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your email">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="number" class="form-control" name="code" placeholder="Enter your code">
            </div>
            @error('code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-primary w-100 mt-3">Check Code</button>
        </form>
    </div>
</div>