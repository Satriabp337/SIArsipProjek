<nav class="navbar navbar-light bg-white px-4 py-3 border-bottom">
    <form class="d-flex w-50">
        <input class="form-control me-2" type="search" placeholder="Cari dokumen, kategori, atau tag..." aria-label="Search">
    </form>
    <div class="d-flex align-items-center">
        <span class="me-3">Dr. Agus Setiawan <span class="badge bg-secondary ms-1">admin</span></span>
        <img src="https://ui-avat ars.com/api/?name=Agus+Setiawan" alt="Profile" class="profile-img">
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<a href="/login" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>
</nav>

<!-- <div class="header">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="mb-0">Dashboard Arsip Kedinasan</h2>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-md-end align-items-center">
                <span class="me-3">Selamat datang, Admin</span>
                <div class="user-avatar">AD</div>
            </div>
        </div>
    </div>
</div> -->