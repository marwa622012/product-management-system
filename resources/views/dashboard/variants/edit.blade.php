@extends('layout.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Edit Variant</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('dashboard.variants.update', $variant->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-11">
                <input type="text" name="name[en]" class="form-control" value="{{ $variant->getTranslation('name', 'en') }}" required>
            </div>
            <div class="col-11">
                <input type="text" name="name[ar]" class="form-control" value="{{ $variant->getTranslation('name', 'ar') }}" required>
            </div>
            @foreach ($variant->variantOptions as $index => $option) 
                <input type="hidden" name="options[{{ $index }}][id]" class="form-control" value="{{ $option->id }}" required>
            <div class="col-11">
                <input type="text" name="options[{{ $index }}][name_en]" class="form-control" value="{{ $option->getTranslation('name', 'en') }}" required>
            </div>
            <div class="col-11">
                <input type="text" name="options[{{ $index }}][name_ar]" class="form-control" value="{{ $option->getTranslation('name', 'ar') }}" required>
            </div>
            <div class=" col-1 option-row ">
            <button type="button"
                    class="btn btn-danger btn-sm remove-option"
                    data-id="{{ $option->id }}">
                🗑️
            </button>
        </div>
            @endforeach
        </div>
        <div id="newOptions"></div>

        <button type="button" class="btn btn-outline-primary mt-2" id="addOption">
            + Add Option
        </button>

        <button type="submit" class="btn btn-success">Update Variant</button>
        <a href="{{ route('dashboard.variants.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection