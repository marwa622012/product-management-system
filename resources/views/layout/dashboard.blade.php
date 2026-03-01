<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            background-color: #fff;
            border-right: 1px solid #eee;
        }
        .sidebar a {
            color: #333;
            text-decoration: none;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #f5f5f5;
            border-radius: 8px;
        }
        .content {
            flex: 1;
            padding: 20px;
            background-color: #f9fafb;
        }
    </style>
</head>
<body>

<div class="d-flex">

    @include('layout.sidebar')

    <div class="content">
        @yield('content')
    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const optionsSection = document.getElementById('optionsSection');
    const addOptionBtn = document.getElementById('addOption');

    let optionIndex = 0;

    addOptionBtn.addEventListener('click', function () {
        optionsSection.style.display = 'block';
        optionIndex++;

        const optionDiv = document.createElement('div');
        optionDiv.classList.add('row', 'mb-2');

        optionDiv.innerHTML = `
            <div class="col-5">
                <input type="text"
                    name="options[${optionIndex}][en]"
                    class="form-control"
                    placeholder="Option Name (EN)"
                    required>
            </div>

            <div class="col-5">
                <input type="text"
                    name="options[${optionIndex}][ar]"
                    class="form-control"
                    placeholder="Option Name (AR)"
                    required>
            </div>
        `;

        optionsSection.appendChild(optionDiv);
    });
});
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.remove-option').forEach(btn => {

        btn.addEventListener('click', function () {

            if (!confirm('Delete this option?')) return;

            const optionId = this.dataset.id;
            const row = this.closest('.option-row');

            fetch(`/dashboard/variant-options/${optionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error();
                return response.json();
            })
            .then(() => {
                // ✅ هنا السطر اللي بيغني عن الـ refresh
                row.remove();
            })
            .catch(() => {
                alert('Something went wrong');
            });
        });

    });

});
document.addEventListener('DOMContentLoaded', function () {

    let newIndex = 0;

    document.getElementById('addOption').addEventListener('click', function () {

        newIndex++;

        const wrapper = document.createElement('div');
        wrapper.classList.add('row', 'align-items-center', 'mb-2', 'option-row');

        wrapper.innerHTML = `
            <input type="hidden" name="new_options[${newIndex}][is_new]" value="1">

            <div class="col-11">
                <input type="text"
                    name="new_options[${newIndex}][en]"
                    class="form-control"
                    placeholder="Option (EN)"
                    required>
            </div>

            <div class="col-11">
                <input type="text"
                    name="new_options[${newIndex}][ar]"
                    class="form-control"
                    placeholder="Option (AR)"
                    required>
            </div>

            <div class="col-1 text-center">
                <button type="button"
                        class="btn btn-danger btn-sm"
                        onclick="this.closest('.option-row').remove()">
                    🗑️
                </button>
            </div>
        `;

        document.getElementById('newOptions').appendChild(wrapper);
    });

});
document.addEventListener('DOMContentLoaded', function () {
    const productType = document.getElementById('productType');
    const variantsSection = document.getElementById('variantsSection');
    const optionsSection =  document.getElementById('optionsSection');

    // تحقق أول مرة عند تحميل الصفحة (مثلاً بعد validation fail)
    if (productType.value === 'variable') {
        variantsSection.style.display = 'block';
        
    }

    // تغيير عند اختيار المستخدم
    productType.addEventListener('change', function () {
        if (this.value === 'variable') {
            variantsSection.style.display = 'block';
        } else {
            variantsSection.style.display = 'none';
            // لو عايزة كمان تفك تشيك كل الـ checkboxes
            variantsSection.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        }
    });
});
</script>
</body>
</html>
