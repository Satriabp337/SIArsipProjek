@extends('layouts.app')

@section('content')
<div class="p-4">
    @include('partials.navbar')
    <nav class="navbar navbar-light bg-white px-4 py-3 border-bottom">
        <form class="d-flex w-50">
            <input id="searchInput" class="form-control me-2" type="search" placeholder="Cari kategori..." aria-label="Search">
        </form>
        <div class="d-flex align-items-center">
            <span class="me-3">Dr. Agus Setiawan <span class="badge bg-secondary ms-1">admin</span></span>
            <img src="https://ui-avatars.com/api/?name=Agus+Setiawan" alt="Profile" class="profile-img">
        </div>
    </nav>
    <div class="container-fluid py-4">
        <h4 class="fw-bold mb-3">Kategori</h4>
        <p class="mb-4">Daftar kategori dokumen yang tersedia dalam sistem arsip digital.</p>
        <div id="resultsList" class="row g-3">
            <!-- Category cards will be appended here -->
        </div>
    </div>
</div>

<script>
    const categories = [{
            id: 1,
            name: "Keuangan",
            description: "Dokumen terkait keuangan"
        },
        {
            id: 2,
            name: "Administrasi",
            description: "Dokumen administrasi umum"
        },
        {
            id: 3,
            name: "Perencanaan",
            description: "Dokumen perencanaan strategis"
        },
        {
            id: 4,
            name: "Kinerja",
            description: "Dokumen laporan kinerja"
        },
        {
            id: 5,
            name: "Surat",
            description: "Dokumen surat menyurat"
        }
    ];

    const resultsList = document.getElementById("resultsList");

    function renderCategories(categories) {
        resultsList.innerHTML = "";
        if (categories.length === 0) {
            resultsList.innerHTML = '<div class="text-muted">Tidak ada kategori yang ditemukan.</div>';
            return;
        }
        categories.forEach(cat => {
            const div = document.createElement("div");
            div.className = "col-md-4";
            div.innerHTML = `
                    <div class="card p-3 shadow-sm">
                        <h5 class="card-title">${cat.name}</h5>
                        <p class="card-text text-muted">${cat.description}</p>
                    </div>
                `;
            resultsList.appendChild(div);
        });
    }

    renderCategories(categories);

    const searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("input", e => {
        const query = e.target.value.trim().toLowerCase();
        const filtered = categories.filter(cat => cat.name.toLowerCase().includes(query) || cat.description.toLowerCase().includes(query));
        renderCategories(filtered);
    });
</script>
@endsection