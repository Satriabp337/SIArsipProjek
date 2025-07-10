<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Digital - Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background: #f8fafc; }
        .sidebar { min-width: 220px; background: #fff; border-right: 1px solid #e5e7eb; min-height: 100vh; }
        .sidebar .nav-link.active { background: #f1f5f9; font-weight: 600; }
        .sidebar .nav-link { color: #222; }
        .sidebar .nav-link:hover { background: #f1f5f9; }
        .profile-img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .card-metric { min-width: 180px; }
        .quick-action { border-radius: 12px; }
        .quick-action .icon { font-size: 1.5rem; }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column p-3">
        <div class="mb-4">
            <div class="d-flex align-items-center mb-2">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;font-size:1.5rem;">A</div>
                <div class="ms-2">
                    <div class="fw-bold">Arsip Digital</div>
                    <small class="text-muted">Kementerian Dalam Negeri</small>
                </div>
            </div>
        </div>
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li> -->
            <li><a href="/dashboard" class="nav-link"><i class="bi bi-file-earmark-text me-2"></i>Dashboard</a></li>
            <li><a href="/document" class="nav-link"><i class="bi bi-file-earmark-text me-2"></i>Dokumen</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-folder me-2"></i>Kategori</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-upload me-2"></i>Upload</a></li>
            <li><a href="/laporan" class="nav-link"><i class="bi bi-bar-chart me-2"></i>Laporan</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-people me-2"></i>Pengguna</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-archive me-2"></i>Arsip</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
        </ul>
    </nav>
<!-- Main Content -->
    <div class="flex-grow-1">
        <nav class="navbar navbar-light bg-white px-4 py-3 border-bottom">
            <form class="d-flex w-50">
                <input class="form-control me-2" type="search" placeholder="Cari dokumen, kategori, atau tag..." aria-label="Search">
            </form>
            <div class="d-flex align-items-center">
                <span class="me-3">Dr. Agus Setiawan <span class="badge bg-secondary ms-1">admin</span></span>
                <img src="https://ui-avatars.com/api/?name=Agus+Setiawan" alt="Profile" class="profile-img">
            </div>
        </nav>
    </div>

<!-- Search Results -->
    <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
      <h2 class="text-xl font-semibold mb-4 text-gray-800">Hasil Pencarian</h2>
      <ul id="resultsList" class="space-y-4">
        <!-- Search results will be appended here -->
      </ul>
    </main>
  </div>
  <script>
    // Dummy data representing documents
    const documents = [
      {
        id: 1,
        name: "Laporan Tahunan Keuangan",
        category: "Keuangan",
        tags: ["laporan", "keuangan", "tahun"]
      },
      {
        id: 2,
        name: "Panduan Prosedur Administrasi",
        category: "Administrasi",
        tags: ["panduan", "prosedur"]
      },
      {
        id: 3,
        name: "Dokumen Rencana Strategis",
        category: "Perencanaan",
        tags: ["strategis", "rencana", "dokumen"]
      },
      {
        id: 4,
        name: "Laporan Bulanan Kinerja",
        category: "Kinerja",
        tags: ["laporan", "bulan", "kinerja"]
      },
      {
        id: 5,
        name: "Surat Edaran Internal",
        category: "Surat",
        tags: ["surat", "edaran", "internal"]
      }
    ];

      const searchInput = document.getElementById("searchInput");
    const resultsList = document.getElementById("resultsList");
    function renderResults(results) {
      resultsList.innerHTML = "";
      if (results.length === 0) {
        resultsList.innerHTML = '<li class="text-gray-500">Tidak ada dokumen yang ditemukan.</li>';
        return;
      }
      results.forEach(doc => {
        const li = document.createElement("li");
        li.className = "p-4 bg-white rounded-md shadow-sm border border-gray-200 hover:shadow-md transition-shadow";
        li.innerHTML = `
          <h3 class="text-lg font-semibold text-indigo-700 mb-1">${sanitizeHTML(doc.name)}</h3>
          <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Kategori:</span> ${sanitizeHTML(doc.category)}</p>
          <p class="text-sm text-gray-600"><span class="font-semibold">Tag:</span> ${doc.tags.map(t => `<span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-0.5 rounded mr-1">${sanitizeHTML(t)}</span>`).join("")}</p>
        `;
        resultsList.appendChild(li);
      });
    }

    // Simple sanitize function to avoid HTML injection
    function sanitizeHTML(str) {
      const temp = document.createElement('div');
      temp.textContent = str;
      return temp.innerHTML;
    }
    function filterDocuments(query) {
      query = query.trim().toLowerCase();
      if (query.length === 0) return documents;
      return documents.filter(doc => {
        return (
          doc.name.toLowerCase().includes(query) ||
          doc.category.toLowerCase().includes(query) ||
          doc.tags.some(tag => tag.toLowerCase().includes(query))
        );
      });
    }

    // Initial render all documents
    renderResults(documents);
    searchInput.addEventListener("input", e => {
      const query = e.target.value;
      const filtered = filterDocuments(query);
      renderResults(filtered);
    });
  </script>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>