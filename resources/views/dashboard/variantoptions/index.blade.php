@extends('layout.dashboard')

@section('content')
<div class="card p-3 shadow">
        <h5>All Variant options</h5>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Variant</th>
                    <th>Name (EN)</th>
                    <th>Name (AR)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($options as $option)
                    <tr>
                        <td>{{ $option->id }}</td>
                        <td>{{ $option->variant->name }}</td>
                        <td>{{ $option->getTranslation('name', 'en') }}</td>
                        <td>{{ $option->getTranslation('name', 'ar') }}</td>
                        <td>
                            {{-- <a href="{{ route('dashboard.variant-options.edit', $variant->id) }}" class="btn btn-sm btn-warning">Edit</a> --}}

                            {{-- <form action="{{ route('dashboard.variant-options.destroy', $variant->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection