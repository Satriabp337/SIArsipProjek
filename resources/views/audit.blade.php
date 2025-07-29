@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-4 fw-bold text-dark">Audit Log</h1>

<!-- Filter Section -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form id="filter-form" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Document</label>
                <select id="doc-filter" class="form-select">
                    <option value="">All Documents & User Profiles</option>
                    <option value="document">Documents</option>
                    <option value="user profile">User Profiles</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Action</label>
                <select id="action-filter" class="form-select">
                    <option value="">All Actions</option>
                    <option value="upload">Upload</option>
                    <option value="edit">Edit</option>
                    <option value="delete">Delete</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Editor</label>
                <input type="text" id="user-filter" class="form-control" placeholder="Search by editor">
            </div>
            <div class="col-12 text-end">
                <button type="button" id="reset-filters" class="btn btn-outline-secondary mt-2">Reset Filters</button>
            </div>
        </form>
    </div>
</div>


    <!-- Audit Table -->
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Document</th>
                    <th scope="col">Action</th>
                    <th scope="col">Editor</th>
                    <th scope="col">Email</th>
                    <th scope="col">Timestamp</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody id="audit-log-body">
                <!-- Populated by JS -->
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small id="item-count" class="text-muted"></small>
        <div class="d-flex align-items-center">
            <button id="prev-page" class="btn btn-sm btn-outline-primary me-2">Previous</button>
            <span id="page-numbers" class="me-2"></span>
            <button id="next-page" class="btn btn-sm btn-outline-primary">Next</button>
        </div>
    </div>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="auditModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Audit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-content">
                <!-- Filled dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let auditLogs = [];
    let currentPage = 1;
    const itemsPerPage = 10;
    let filteredLogs = [];

    const auditLogBody = document.getElementById('audit-log-body');
    const docFilter = document.getElementById('doc-filter');
    const actionFilter = document.getElementById('action-filter');
    const userFilter = document.getElementById('user-filter');
    const resetFilters = document.getElementById('reset-filters');
    const prevPage = document.getElementById('prev-page');
    const nextPage = document.getElementById('next-page');
    const pageNumbers = document.getElementById('page-numbers');
    const itemCount = document.getElementById('item-count');
    const modalContent = document.getElementById('modal-content');

    async function initAuditLog() {
        try {
            const response = await fetch('/api/audit-logs', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            auditLogs = await response.json();
            filteredLogs = [...auditLogs];

            updateActionOptions(); // initialize action dropdown correctly
            renderAuditLog();
        } catch (error) {
            console.error('Error fetching audit logs:', error);
            auditLogBody.innerHTML = `
                <tr><td colspan="7" class="text-center text-danger">Failed to load audit logs.</td></tr>
            `;
        }
    }

    function renderAuditLog() {
        filteredLogs = auditLogs.filter(log => {
            const docMatch = docFilter.value === 'document'
                ? log.action.toLowerCase().includes('document')
                : docFilter.value === 'user profile'
                    ? log.action.toLowerCase().includes('user')
                    : true;

            const actionMatch = actionFilter.value
                ? log.action.toLowerCase().includes(actionFilter.value.toLowerCase())
                : true;

            const userMatch = userFilter.value
                ? (log.user_name.toLowerCase().includes(userFilter.value.toLowerCase()) ||
                   log.user_email.toLowerCase().includes(userFilter.value.toLowerCase()))
                : true;

            return docMatch && actionMatch && userMatch;
        });

        const totalPages = Math.ceil(filteredLogs.length / itemsPerPage);
        const startIdx = (currentPage - 1) * itemsPerPage;
        const paginatedLogs = filteredLogs.slice(startIdx, startIdx + itemsPerPage);

        auditLogBody.innerHTML = '';

        if (paginatedLogs.length === 0) {
            auditLogBody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">No audit logs found.</td></tr>`;
        } else {
            paginatedLogs.forEach(log => {
                const row = document.createElement('tr');
                row.classList.add('table-row');
                row.style.cursor = 'pointer';
                row.addEventListener('click', () => showAuditDetails(log));

                const actionType = log.action.toLowerCase().includes('delete') ? 'danger'
                                : log.action.toLowerCase().includes('edit') ? 'primary'
                                : 'success';

                row.innerHTML = `
                    <td>${log.id}</td>
                    <td>${log.doc_name}</td>
                    <td><span class="badge bg-${actionType}">${log.action}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-light border d-flex justify-content-center align-items-center me-2" style="width: 40px; height: 40px;">
                                ${log.user_name.charAt(0).toUpperCase()}
                            </div>
                            <div>
                                <div class="fw-semibold">${log.user_name}</div>
                                <small class="text-muted">ID: ${log.user_id}</small>
                            </div>
                        </div>
                    </td>
                    <td>${log.user_email}</td>
                    <td>${new Date(log.date).toLocaleString()}</td>
                    <td>${log.details}</td>
                `;

                auditLogBody.appendChild(row);
            });
        }

        updatePaginationControls(totalPages);
        itemCount.textContent = `Showing ${startIdx + 1}-${Math.min(startIdx + itemsPerPage, filteredLogs.length)} of ${filteredLogs.length}`;
    }

    function updatePaginationControls(totalPages) {
        pageNumbers.innerHTML = '';
        prevPage.disabled = currentPage === 1;
        nextPage.disabled = currentPage === totalPages || totalPages === 0;

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.className = `btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-outline-secondary'} me-1`;
            btn.textContent = i;
            btn.addEventListener('click', () => {
                currentPage = i;
                renderAuditLog();
            });
            pageNumbers.appendChild(btn);
        }
    }

    function showAuditDetails(log) {
        document.getElementById('modal-title').textContent = `Audit Details for ${log.doc_name} #${log.doc_id}`;

        let html = `
            <div class="mb-3">
                <h5>Basic Info</h5>
                <p><strong>ID:</strong> ${log.id}</p>
                <p><strong>Action:</strong> ${log.action}</p>
                <p><strong>Document:</strong> ${log.doc_name}</p>
                <p><strong>Timestamp:</strong> ${new Date(log.date).toLocaleString()}</p>
            </div>
            <div class="mb-3">
                <h5>Editor Info</h5>
                <p><strong>Name:</strong> ${log.user_name}</p>
                <p><strong>Email:</strong> ${log.user_email}</p>
                <p><strong>User ID:</strong> ${log.user_id}</p>
            </div>
            <div class="mb-3">
                <h5>Details</h5>
                <p>${log.details}</p>
            </div>
        `;

        if (log.old_data || log.new_data) {
            html += '<div><h5>Data Changes</h5><div class="row">';
            if (log.old_data) {
                html += `<div class="col-md-6"><h6>Before</h6><pre>${JSON.stringify(log.old_data, null, 2)}</pre></div>`;
            }
            if (log.new_data) {
                html += `<div class="col-md-6"><h6>${log.old_data ? 'After' : 'Data'}</h6><pre>${JSON.stringify(log.new_data, null, 2)}</pre></div>`;
            }
            html += '</div></div>';
        }

        modalContent.innerHTML = html;
        const modal = new bootstrap.Modal(document.getElementById('auditModal'));
        modal.show();
    }

    function updateActionOptions() {
        const uploadOption = [...actionFilter.options].find(opt => opt.value === 'upload');
        if (!uploadOption) return;

        if (docFilter.value === 'user profile') {
            uploadOption.style.display = 'none';
            if (actionFilter.value === 'upload') {
                actionFilter.value = '';
            }
        } else {
            uploadOption.style.display = '';
        }
    }

    // Events
    docFilter.addEventListener('change', () => {
        currentPage = 1;
        updateActionOptions();
        renderAuditLog();
    });

    actionFilter.addEventListener('change', () => {
        currentPage = 1;
        renderAuditLog();
    });

    userFilter.addEventListener('input', () => {
        currentPage = 1;
        renderAuditLog();
    });

    resetFilters.addEventListener('click', () => {
        docFilter.value = '';
        actionFilter.value = '';
        userFilter.value = '';
        currentPage = 1;
        updateActionOptions();
        renderAuditLog();
    });

    prevPage.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            renderAuditLog();
        }
    });

    nextPage.addEventListener('click', () => {
        const totalPages = Math.ceil(filteredLogs.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderAuditLog();
        }
    });

    document.addEventListener('DOMContentLoaded', initAuditLog);
</script>


@endsection