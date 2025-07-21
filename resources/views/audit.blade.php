@extends('layouts.app')
@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Audit Log</h1>
        
        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow mb-6 p-4">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Document</label>
                    <select id="doc-filter" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                        <option value="">All Documents</option>
                        <option value="user_profile">User Profiles</option>
                        <option value="product">Products</option>
                        <option value="order">Orders</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Action</label>
                    <select id="action-filter" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                        <option value="">All Actions</option>
                        <option value="create">Create</option>
                        <option value="update">Update</option>
                        <option value="delete">Delete</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Editor</label>
                    <input type="text" id="user-filter" placeholder="Search by editor" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button id="reset-filters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Reset Filters</button>
            </div>
        </div>

        <!-- Audit Log Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Editor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody id="audit-log-body" class="bg-white divide-y divide-gray-200">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
                <div class="flex-1 flex justify-between items-center">
                    <span id="item-count" class="text-sm text-gray-700"></span>
                    <div class="flex space-x-2">
                        <button id="prev-page" class="px-3 py-1 border rounded text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">Previous</button>
                        <div id="page-numbers" class="flex space-x-1"></div>
                        <button id="next-page" class="px-3 py-1 border rounded text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audit Details Modal -->
    <div id="audit-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800" id="modal-title">Audit Details</h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-4" id="modal-content">
                <!-- Modal content will be loaded here -->
            </div>
            <div class="mt-6 flex justify-end">
                <button id="modal-close-btn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Close</button>
            </div>
        </div>
    </div>

    <script>
        let auditLogs = []; // Will be populated by API data

        // Pagination settings
        let currentPage = 1;
        const itemsPerPage = 10;
        let filteredLogs = [];

        // DOM elements
        const auditLogBody = document.getElementById('audit-log-body');
        const docFilter = document.getElementById('doc-filter');
        const actionFilter = document.getElementById('action-filter');
        const userFilter = document.getElementById('user-filter');
        const resetFilters = document.getElementById('reset-filters');
        const prevPage = document.getElementById('prev-page');
        const nextPage = document.getElementById('next-page');
        const pageNumbers = document.getElementById('page-numbers');
        const itemCount = document.getElementById('item-count');
        const auditModal = document.getElementById('audit-modal');
        const modalContent = document.getElementById('modal-content');
        const modalCloseBtn = document.getElementById('modal-close-btn');
        const closeModalBtn = document.getElementById('close-modal');

        // Initialize the audit log
        async function initAuditLog() {
            try {
                console.log('Fetching audit logs...');
                const response = await fetch('/api/audit-logs', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                auditLogs = await response.json();
                console.log('Received audit logs:', auditLogs);
                filteredLogs = [...auditLogs];
                renderAuditLog();
            } catch (error) {
                console.error('Error fetching audit logs:', error);
                auditLogBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-red-500">
                            Failed to load audit logs. Please try again later.
                        </td>
                    </tr>
                `;
            }
        }

        // Render audit log items based on current filters and page
        function renderAuditLog() {
            // Filter logs
            filteredLogs = auditLogs.filter(log => {
                const docMatch = docFilter.value ? log.doc_name.toLowerCase().includes(docFilter.value.toLowerCase()) : true;
                const actionMatch = actionFilter.value ? log.action === actionFilter.value : true;
                const userMatch = userFilter.value ? 
                    (log.user_name.toLowerCase().includes(userFilter.value.toLowerCase()) || 
                     log.user_email.toLowerCase().includes(userFilter.value.toLowerCase())) : true;
                
                return docMatch && actionMatch && userMatch;
            });

            // Pagination
            const totalPages = Math.ceil(filteredLogs.length / itemsPerPage);
            const startIdx = (currentPage - 1) * itemsPerPage;
            const endIdx = startIdx + itemsPerPage;
            const paginatedLogs = filteredLogs.slice(startIdx, endIdx);

            // Clear existing rows
            auditLogBody.innerHTML = '';

            // Add filtered and paginated logs
            if (paginatedLogs.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No audit logs found matching your criteria
                    </td>
                `;
                auditLogBody.appendChild(row);
            } else {
                paginatedLogs.forEach(log => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50 cursor-pointer';
                    row.onclick = () => showAuditDetails(log);
                    
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${log.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${log.doc_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                ${log.action === 'create' ? 'bg-green-100 text-green-800' : 
                                 log.action === 'update' ? 'bg-blue-100 text-blue-800' : 
                                 'bg-red-100 text-red-800'}">
                                ${log.action}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    ${log.user_name.charAt(0).toUpperCase()}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">${log.user_name}</div>
                                    <div class="text-sm text-gray-500">ID: ${log.user_id}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${log.user_email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${new Date(log.date).toLocaleString()}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate max-w-xs">
                            ${log.details}
                        </td>
                    `;
                    auditLogBody.appendChild(row);
                });
            }

            // Update pagination controls
            updatePaginationControls(totalPages);
            itemCount.textContent = `Showing ${startIdx + 1}-${Math.min(endIdx, filteredLogs.length)} of ${filteredLogs.length} items`;
        }

        // Update pagination controls
        function updatePaginationControls(totalPages) {
            pageNumbers.innerHTML = '';
            prevPage.disabled = currentPage === 1;
            nextPage.disabled = currentPage === totalPages || totalPages === 0;

            // Only show page numbers if there are multiple pages
            if (totalPages > 1) {
                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = `px-3 py-1 border rounded ${currentPage === i ? 'bg-blue-500 text-white' : 'text-gray-700 bg-white hover:bg-gray-50'}`;
                    pageBtn.textContent = i;
                    pageBtn.onclick = () => {
                        currentPage = i;
                        renderAuditLog();
                    };
                    pageNumbers.appendChild(pageBtn);
                }
            }
        }

        // Show audit log details in modal
        function showAuditDetails(log) {
            const modalTitle = document.getElementById('modal-title');
            modalTitle.textContent = `Audit Details for ${log.doc_name} #${log.doc_id}`;
            
            let content = `
                <div class="border-b pb-4 mb-4">
                    <h4 class="text-lg font-medium text-gray-800">Basic Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">ID</label>
                            <p class="mt-1 text-sm text-gray-900">${log.id}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Action</label>
                            <p class="mt-1 text-sm ${log.action === 'create' ? 'text-green-600' : 
                             log.action === 'update' ? 'text-blue-600' : 'text-red-600'}">
                                ${log.action}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Document</label>
                            <p class="mt-1 text-sm text-gray-900">${log.doc_name}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Timestamp</label>
                            <p class="mt-1 text-sm text-gray-900">${new Date(log.date).toLocaleString()}</p>
                        </div>
                    </div>
                </div>
                
                <div class="border-b pb-4 mb-4">
                    <h4 class="text-lg font-medium text-gray-800">Editor Details</h4>
                    <div class="flex items-center mt-2">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-lg font-medium">
                            ${log.user_name.charAt(0).toUpperCase()}
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">${log.user_name}</p>
                            <p class="text-sm text-gray-500">${log.user_email}</p>
                            <p class="text-xs text-gray-500">User ID: ${log.user_id}</p>
                        </div>
                    </div>
                </div>
                
                <div class="border-b pb-4 mb-4">
                    <h4 class="text-lg font-medium text-gray-800">Action Details</h4>
                    <p class="mt-2 text-sm text-gray-700">${log.details}</p>
                </div>
            `;

            // Add data changes if available
            if (log.old_data || log.new_data) {
                content += `
                    <div>
                        <h4 class="text-lg font-medium text-gray-800">Data Changes</h4>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${log.old_data ? `
                                <div class="bg-gray-50 p-3 rounded border">
                                    <h5 class="text-sm font-medium text-gray-700 mb-2">Before</h5>
                                    <pre class="text-xs text-gray-600 overflow-auto max-h-40">${JSON.stringify(log.old_data, null, 2)}</pre>
                                </div>
                            ` : ''}
                            ${log.new_data ? `
                                <div class="bg-gray-50 p-3 rounded border">
                                    <h5 class="text-sm font-medium text-gray-700 mb-2">${log.old_data ? 'After' : 'Data'}</h5>
                                    <pre class="text-xs text-gray-600 overflow-auto max-h-40">${JSON.stringify(log.new_data, null, 2)}</pre>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            }

            modalContent.innerHTML = content;
            auditModal.classList.remove('hidden');
        }

        // Event listeners
        docFilter.addEventListener('change', () => {
            currentPage = 1;
            renderAuditLog();
        });

        actionFilter.addEventListener('change', () => {
            currentPage = 1;
            renderAuditLog();
        });

        userFilter.addEventListener('input', (e) => {
            currentPage = 1;
            renderAuditLog();
        });

        resetFilters.addEventListener('click', () => {
            docFilter.value = '';
            actionFilter.value = '';
            userFilter.value = '';
            currentPage = 1;
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

        modalCloseBtn.addEventListener('click', () => {
            auditModal.classList.add('hidden');
        });

        closeModalBtn.addEventListener('click', () => {
            auditModal.classList.add('hidden');
        });

        // Initialize on load
        document.addEventListener('DOMContentLoaded', initAuditLog);
    </script>
@endsection