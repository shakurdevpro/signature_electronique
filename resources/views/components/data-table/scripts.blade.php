@once
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('[data-table]').forEach(function(table) {

                if (table.dataset.initialized === 'true') {
                    return;
                }

                const tableBody = table.querySelector('[data-table-body]');

                if (!tableBody) {
                    return;
                }

                table.dataset.initialized = 'true';

                const searchInput = table.querySelector('[data-table-search]');
                const emptyMessage = table.querySelector('[data-table-empty]');
                const pagination = table.querySelector('[data-table-pagination]');
                const paginationLinks = table.querySelector('[data-table-pagination-links]');
                const pageSelect = table.querySelector('[data-table-page-select]');
                const pageTotal = table.querySelector('[data-table-page-total]');

                const perPage = Math.max(
                    1,
                    parseInt(table.dataset.perPage, 10) || 10
                );

                const rows = Array.from(
                    tableBody.querySelectorAll('.nk-tb-item')
                );

                const filterElements = Array.from(
                    table.querySelectorAll('[data-table-filter]')
                );

                const applyFiltersButton = table.querySelector('[data-table-apply-filters]');
                const resetFiltersButton = table.querySelector('[data-table-reset-filters]');

                let currentPage = 1;
                let filteredRows = [...rows];

                let appliedFilters = {};
                let pendingFilters = {};

                function normalize(value) {
                    return (value || '')
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '')
                        .toLowerCase()
                        .trim();
                }

                function readFilters() {
                    const filters = {};

                    filterElements.forEach(function(element) {
                        const key = element.dataset.tableFilter;

                        if (key) {
                            filters[key] = element.value || '';
                        }
                    });

                    return filters;
                }

                function applyFiltering() {
                    const search = normalize(searchInput ? searchInput.value : '');

                    filteredRows = rows.filter(function(row) {

                        const rowText = normalize(row.textContent);

                        if (search && !rowText.includes(search)) {
                            return false;
                        }

                        return Object.keys(appliedFilters).every(function(key) {
                            const selectedValue = normalize(appliedFilters[key]);

                            if (!selectedValue) {
                                return true;
                            }

                            const rowValue = normalize(row.dataset[key]);

                            return rowValue === selectedValue;
                        });
                    });

                    currentPage = 1;

                    renderTable();
                }

                // Création d'un élément de pagination
                function addPageButton(label, page, disabled, active) {

                    const li = document.createElement('li');
                    li.className = 'page-item';

                    if (disabled) {
                        li.classList.add('disabled');
                    }

                    if (active) {
                        li.classList.add('active');
                    }

                    const link = document.createElement('a');

                    link.href = '#';
                    link.className = 'page-link';
                    link.textContent = label;

                    if (disabled) {
                        link.setAttribute('aria-disabled', 'true');
                    }

                    link.addEventListener('click', function(event) {
                        event.preventDefault();

                        if (!disabled) {
                            currentPage = page;
                            renderTable();
                        }
                    });

                    li.appendChild(link);
                    paginationLinks.appendChild(li);
                }

                // Pagination identique à l'ancienne vue
                function renderPagination(totalPages) {

                    // Toujours afficher la zone de pagination
                    if (paginationLinks) {
                        paginationLinks.innerHTML = '';
                        paginationLinks.style.display = '';

                        // Bouton précédent
                        addPageButton(
                            'Prec',
                            currentPage - 1,
                            currentPage === 1,
                            false
                        );

                        // Pages à afficher
                        const pages = [];

                        for (let page = 1; page <= totalPages; page++) {
                            if (
                                page === 1 ||
                                page === totalPages ||
                                Math.abs(page - currentPage) <= 1
                            ) {
                                pages.push(page);
                            }
                        }

                        let previousPage = 0;

                        pages.forEach(function(page) {

                            if (page - previousPage > 1) {
                                const dots = document.createElement('li');
                                dots.className = 'page-item disabled';

                                const span = document.createElement('span');
                                span.className = 'page-link';

                                const icon = document.createElement('em');
                                icon.className = 'icon ni ni-more-h';

                                span.appendChild(icon);
                                dots.appendChild(span);
                                paginationLinks.appendChild(dots);
                            }

                            addPageButton(
                                page,
                                page,
                                false,
                                page === currentPage
                            );

                            previousPage = page;
                        });

                        // Bouton suivant
                        addPageButton(
                            'Suiv',
                            currentPage + 1,
                            currentPage === totalPages,
                            false
                        );
                    }

                    // Toujours afficher et activer le sélecteur
                    if (pageSelect) {
                        pageSelect.innerHTML = '';
                        pageSelect.disabled = false;

                        for (let page = 1; page <= totalPages; page++) {
                            const option = document.createElement('option');

                            option.value = page;
                            option.textContent = page;
                            option.selected = page === currentPage;

                            pageSelect.appendChild(option);
                        }
                    }

                    // Afficher le nombre total de pages
                    if (pageTotal) {
                        pageTotal.textContent = 'SUR ' + totalPages;
                    }

                    // Conserver la pagination visible
                    if (pagination) {
                        pagination.style.display = '';
                    }
                }

                function renderTable() {

                    const totalRows = filteredRows.length;

                    const totalPages = Math.max(
                        1,
                        Math.ceil(totalRows / perPage)
                    );

                    currentPage = Math.min(
                        Math.max(1, currentPage),
                        totalPages
                    );

                    const start = (currentPage - 1) * perPage;
                    const end = start + perPage;

                    const visibleRows = filteredRows.slice(start, end);

                    rows.forEach(function(row) {
                        row.style.display = 'none';
                    });

                    visibleRows.forEach(function(row) {
                        row.style.display = '';
                    });

                    if (emptyMessage) {
                        emptyMessage.style.display =
                            totalRows === 0 ? '' : 'none';
                    }

                    renderPagination(totalPages);

                    table.dispatchEvent(new CustomEvent('data-table:rendered', {
                        detail: {
                            visibleRows: visibleRows,
                            filteredRows: filteredRows,
                            currentPage: currentPage,
                            totalPages: totalPages
                        }
                    }));
                }

                // Recherche instantanée
                if (searchInput) {
                    searchInput.addEventListener('input', applyFiltering);
                }

                // Lecture des filtres
                filterElements.forEach(function(element) {
                    element.addEventListener('change', function() {
                        pendingFilters = readFilters();

                        if (!applyFiltersButton) {
                            appliedFilters = {
                                ...pendingFilters
                            };
                            applyFiltering();
                        }
                    });
                });

                // Application des filtres
                if (applyFiltersButton) {
                    applyFiltersButton.addEventListener('click', function() {
                        appliedFilters = {
                            ...readFilters()
                        };
                        applyFiltering();
                    });
                }

                // Réinitialisation des filtres
                if (resetFiltersButton) {
                    resetFiltersButton.addEventListener('click', function(event) {
                        event.preventDefault();

                        filterElements.forEach(function(element) {
                            element.value = '';
                        });

                        appliedFilters = {};
                        pendingFilters = {};

                        applyFiltering();
                    });
                }

                // Sélection directe d'une page
                if (pageSelect) {
                    pageSelect.addEventListener('change', function() {
                        currentPage = parseInt(pageSelect.value, 10) || 1;
                        renderTable();
                    });
                }

                // Initialisation
                appliedFilters = readFilters();
                pendingFilters = {
                    ...appliedFilters
                };

                applyFiltering();
            });

        });
    </script>
@endonce
