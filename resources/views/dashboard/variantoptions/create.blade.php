@extends('layout.dashboard')

@section('content')
<div class="container">
    <h2>Add Variant Option</h2>

    <form method="POST" action="{{ route('dashboard.variant-options.store') }}">
        @csrf

        <div class="mb-3">
            <label>Variant</label>
            <select name="variant_id" class="form-control" required>
                <option value="">Select Variant</option>
                @foreach($variants as $variant)
                    <option value="{{ $variant->id }}">
                        {{ $variant->getTranslation('name','en') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Name (EN)</label>
            <input type="text" name="name[en]" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Name (AR)</label>
            <input type="text" name="name[ar]" class="form-control" required>
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
