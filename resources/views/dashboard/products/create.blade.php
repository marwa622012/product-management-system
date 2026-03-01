{{-- @extends('layout.dashboard')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Product Type</label>
        <select name="type" id="productType" class="form-select">
            <option value="simple" {{ old('type')=='simple' ? 'selected' : '' }}>Simple</option>
            <option value="variable" {{ old('type')=='variable' ? 'selected' : '' }}>Variable</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Product Name (AR)</label>
        <input type="text" name="name[ar]" class="form-control" value="{{ old('name.ar') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Product Name (EN)</label>
        <input type="text" name="name[en]" class="form-control" value="{{ old('name.en') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select">
            <option value="">Select category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    @error('category_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-select">
            <option value="1" {{ old('is_active',1)==1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('is_active')==0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Product Image</label>
        <input type="file" name="image" class="form-control">
    </div>
    <div class="mb-3">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
        </div>


    <div id="simpleSection">
        
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="1" name="price" class="form-control" value="{{ old('price') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
        </div>
    </div>

    <div id="variantsSection" style="display:none">
         @foreach($variants as $variant)
            <h6>{{ $variant->name }}</h6>
            <div class="row mb-2">
                @foreach($variant->variantOptions as $option)
                    <div class="col-3">
                        <label>
                            <input type="checkbox"
                              class="variant-option"
                                    data-variant="{{ $variant->id }}[]"
                                   value="{{ $option->id }}">
                            {{ $option->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
        <button type="button" class="btn btn-info mb-3" id="createVariations" >Create Variations</button>
        <table class="table table-bordered" id="variationsTable" style="display:none">
    <thead>
        <tr>
            <th>SKU</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
    </div>

    <button type="submit" class="btn btn-danger">SUBMIT</button>
</form>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const typeSelect      = document.getElementById('productType');
    const simpleSection   = document.getElementById('simpleSection');
    const variantsSection = document.getElementById('variantsSection');
    const createBtn       = document.getElementById('createVariations');
    const table           = document.getElementById('variationsTable');
    const tbody           = table.querySelector('tbody');

    function toggleByType() {
        if (typeSelect.value === 'simple') {
            simpleSection.style.display   = 'block';
            variantsSection.style.display = 'none';
            table.style.display           = 'none';
        } else {
            simpleSection.style.display   = 'none';
            variantsSection.style.display = 'block';
        }
    }

    toggleByType();
    typeSelect.addEventListener('change', toggleByType);

    createBtn.addEventListener('click', function () {

        const checkedOptions = {};

        document.querySelectorAll('.variant-option:checked')
            .forEach(el => {
                const variantId = el.dataset.variant;
                if (!checkedOptions[variantId]) {
                    checkedOptions[variantId] = [];
                }

                checkedOptions[variantId].push({
                    id: el.value,
                    text: el.parentElement.innerText.trim()
                });
            });

        if (Object.keys(checkedOptions).length === 0) {
            alert('Please select variant options');
            return;
        }

        // generate combinations
        const combinations = Object.values(checkedOptions).reduce(
            (a, b) => a.flatMap(d => b.map(e => [].concat(d, e))),
            [[]]
        );

        tbody.innerHTML = '';

        combinations.forEach((combo, index) => {

            // R / S / C
            const displayName = combo
                .map(o => o.text.charAt(0).toUpperCase())
                .join(' / ');

            // R-S-C-1
            const sku = combo
                .map(o => o.text.charAt(0).toUpperCase())
                .join('-') + '-' + (index + 1);

            let optionInputs = '';
            combo.forEach((o, i) => {
                optionInputs += `
                    <input type="hidden"
                        name="variations[${index}][variant_values][${i}][variant_option_id]"
                        value="${o.id}">
                `;
            });

            tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>
                        <input type="text"
                            name="variations[${index}][sku]"
                            class="form-control"
                            value="${sku}">
                    </td>

                    <td>
                        <input type="text"
                            name="variations[${index}][name][en]"
                            class="form-control"
                            value="${displayName}">
                        ${optionInputs}
                    </td>

                    <td>
                        <input type="number"
                            name="variations[${index}][price]"
                            class="form-control" required>
                    </td>

                    <td>
                        <input type="number"
                            name="variations[${index}][stock]"
                            class="form-control" required>
                    </td>
                </tr>
            `);
        });

        table.style.display = 'table';
    });
});
</script>


@endsection --}}
@extends('layout.dashboard')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data">
    @csrf

    <!-- Product Type -->
    <div class="mb-3">
        <label class="form-label">Product Type</label>
        <select name="type" id="productType" class="form-select">
            <option value="simple" {{ old('type')=='simple' ? 'selected' : '' }}>Simple</option>
            <option value="variable" {{ old('type')=='variable' ? 'selected' : '' }}>Variable</option>
        </select>
    </div>

    <!-- Product Name -->
    <div class="mb-3">
        <label class="form-label">Product Name (AR)</label>
        <input type="text" name="name[ar]" class="form-control" value="{{ old('name.ar') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Product Name (EN)</label>
        <input type="text" name="name[en]" class="form-control" value="{{ old('name.en') }}">
    </div>

    <!-- Category -->
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select">
            <option value="">Select category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>

    <!-- Status -->
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-select">
            <option value="1" {{ old('is_active',1)==1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('is_active')==0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <!-- Image -->
    <div class="mb-3">
        <label class="form-label">Product Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <!-- SKU -->
    <div class="mb-3">
        <label class="form-label">SKU</label>
        <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
    </div>

    <!-- Simple Product Section -->
    <div id="simpleSection">
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="1" name="price" class="form-control" value="{{ old('price') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
        </div>
    </div>

    <!-- Variable Product Section -->
    <div id="variantsSection" style="display:none">
        @foreach($variants as $variant)
            <h6>{{ $variant->name }}</h6>
            <div class="row mb-2">
                @foreach($variant->variantOptions as $option)
                    <div class="col-3">
                        <label>
                            <input type="checkbox" class="variant-option"
                                data-variant="{{ $variant->id }}"
                                value="{{ $option->id }}">
                            {{ $option->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
        <button type="button" class="btn btn-info mb-3" id="createVariations">Create Variations</button>

        <!-- Variations Table -->
        <table class="table table-bordered" id="variationsTable" style="display:none">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <button type="submit" class="btn btn-danger">SUBMIT</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect      = document.getElementById('productType');
    const simpleSection   = document.getElementById('simpleSection');
    const variantsSection = document.getElementById('variantsSection');
    const createBtn       = document.getElementById('createVariations');
    const table           = document.getElementById('variationsTable');
    const tbody           = table.querySelector('tbody');

    function toggleByType() {
        if (typeSelect.value === 'simple') {
            simpleSection.style.display   = 'block';
            variantsSection.style.display = 'none';
            table.style.display           = 'none';
        } else {
            simpleSection.style.display   = 'none';
            variantsSection.style.display = 'block';
        }
    }

    toggleByType();
    typeSelect.addEventListener('change', toggleByType);

    createBtn.addEventListener('click', function () {
        const checkedOptions = {};
        document.querySelectorAll('.variant-option:checked')
            .forEach(el => {
                const variantId = el.dataset.variant;
                if (!checkedOptions[variantId]) checkedOptions[variantId] = [];
                checkedOptions[variantId].push({
                    id: el.value,
                    text: el.parentElement.innerText.trim()
                });
            });

        if (Object.keys(checkedOptions).length === 0) {
            alert('Please select variant options');
            return;
        }

        // generate combinations
        const combinations = Object.values(checkedOptions).reduce(
            (a, b) => a.flatMap(d => b.map(e => [].concat(d, e))),
            [[]]
        );

        tbody.innerHTML = '';

        combinations.forEach((combo, index) => {
            const displayName = combo.map(o => o.text.charAt(0).toUpperCase()).join(' / ');
            const sku = combo.map(o => o.text.charAt(0).toUpperCase()).join('-') + '-' + (index + 1);

            let optionInputs = '';
            combo.forEach((o, i) => {
                optionInputs += `<input type="hidden"
                    name="variations[${index}][variant_values][${i}][variant_option_id]"
                    value="${o.id}">`;
            });

            tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td><input type="text" name="variations[${index}][sku]" class="form-control" value="${sku}"></td>
                    <td>
                        <input type="text" name="variations[${index}][name][en]" class="form-control" value="${displayName}">
                        ${optionInputs}
                    </td>
                    <td><input type="number" name="variations[${index}][price]" class="form-control" required></td>
                    <td><input type="number" name="variations[${index}][stock]" class="form-control" required></td>
                </tr>
            `);
        });

        table.style.display = 'table';
    });
});
</script>

@endsection


