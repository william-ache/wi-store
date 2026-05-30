<!-- Alpine.js layout data structure -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('connection', {
            online: typeof navigator !== 'undefined' ? navigator.onLine : true,
        });

        window.addEventListener('online', () => {
            Alpine.store('connection').online = true;
        });
        window.addEventListener('offline', () => {
            Alpine.store('connection').online = false;
        });

        Alpine.data('adminSidebarNav', (activeSection = null) => ({
            activeSection: activeSection,
            openSection: activeSection,
            isSectionOpen(id) {
                return this.openSection === id;
            },
            toggleSection(id) {
                if (this.openSection === id) {
                    if (this.activeSection === id) {
                        return;
                    }
                    this.openSection = null;
                    return;
                }

                this.openSection = id;
            },
        }));

        Alpine.data('adminLayout', () => ({
            showFeedbackModal: {{ (session('open_feedback_modal') || ($errors->has('title') && $errors->has('type')) || $errors->has('description')) ? 'true' : 'false' }},
            showRateModal: {{ (session('open_rate_modal') || old('rating') || $errors->has('rating') || $errors->has('comment')) ? 'true' : 'false' }},
            showAllNotifs: false,
            sidebarOpen: false,
            profileMenuOpen: false,
            searchModalOpen: false,
            notifOpen: false,
            searchQuery: '',
            searchResults: { categories: [], products: [], orders: [], clients: [] },
            searchPanelOpen: false,
            searchLoading: false,
            darkMode: localStorage.getItem('admin-dark-mode') === 'true',
            unreadCount: 0,
            notifications: [],
            shopSlug: '{{ config('current_shop')->slug }}',
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
            },
            closeSidebar() {
                this.sidebarOpen = false;
            },
            showDarkModeComingSoon() {
                if (typeof Swal === 'undefined') {
                    window.alert('El modo oscuro está en desarrollo y estará disponible muy pronto.');
                    return;
                }

                Swal.fire({
                    title: 'Modo oscuro 🌙',
                    text: 'Esta función está en desarrollo. Muy pronto podrás alternar el tema del panel.',
                    icon: 'info',
                    iconColor: '#7dd3fc',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '{{ config('current_shop')->color_primary ?? '#6366f1' }}',
                    background: '#1e293b',
                    color: '#ffffff',
                    customClass: {
                        popup: 'admin-dark-mode-swal',
                        title: 'admin-dark-mode-swal__title',
                        htmlContainer: 'admin-dark-mode-swal__text',
                        icon: 'admin-dark-mode-swal__icon',
                        confirmButton: 'admin-dark-mode-swal__btn',
                    },
                });
            },
            onSidebarNavClick(event) {
                if (window.innerWidth >= 768) return;
                const link = event.target.closest('a[href]');
                if (link && !link.getAttribute('href')?.startsWith('#')) {
                    this.closeSidebar();
                }
            },
            toggleProfileMenu() {
                this.profileMenuOpen = !this.profileMenuOpen;
                if (!this.profileMenuOpen) {
                    this.notifOpen = false;
                }
            },
            closeProfileMenu() {
                this.profileMenuOpen = false;
                this.notifOpen = false;
            },
            openSearchModal() {
                this.searchModalOpen = true;
                this.searchPanelOpen = true;
                this.$nextTick(() => {
                    document.getElementById('mobile-search-input')?.focus();
                });
            },
            closeSearchModal() {
                this.searchModalOpen = false;
                this.clearSearch();
            },
            hasSearchResults() {
                return (this.searchResults.categories?.length > 0)
                    || (this.searchResults.products?.length > 0)
                    || (this.searchResults.orders?.length > 0)
                    || (this.searchResults.clients?.length > 0);
            },
            clearSearch() {
                this.searchQuery = '';
                this.searchResults = { categories: [], products: [], orders: [], clients: [] };
                this.searchPanelOpen = false;
            },
            async runSearch() {
                if (this.searchQuery.trim().length < 2) {
                    this.clearSearch();
                    return;
                }
                this.searchLoading = true;
                try {
                    const res = await fetch(`/${this.shopSlug}/admin/search?query=` + encodeURIComponent(this.searchQuery));
                    const data = await res.json();
                    if (data.success) {
                        this.searchResults = data.data;
                        this.searchPanelOpen = true;
                    }
                } catch (e) {
                    console.error(e);
                } finally {
                    this.searchLoading = false;
                }
            },
            handleSearchSelect(type, item) {
                const currentPath = window.location.pathname;
                const shopSlug = this.shopSlug;

                if (type === 'category') {
                    if (currentPath.includes('/admin/categories')) {
                        this.clearSearch();
                        this.closeSearchModal();
                        editCategory(item.id, item.name, item.status);
                    } else {
                        window.location.href = `/${shopSlug}/admin/categories?edit_id=${item.id}`;
                    }
                } else if (type === 'product') {
                    if (currentPath.includes('/admin/products')) {
                        this.clearSearch();
                        this.closeSearchModal();
                        editProduct(item.id, item.name, item.category_id, item.price, item.description || '', item.is_available, item.image_path || '', encodeURIComponent(JSON.stringify(item.features || null)));
                    } else {
                        window.location.href = `/${shopSlug}/admin/products?edit_id=${item.id}`;
                    }
                } else if (type === 'client') {
                    if (currentPath.includes('/admin/clients')) {
                        this.clearSearch();
                        this.closeSearchModal();
                        editClient(item.id, item.name, item.phone, item.email || '', item.status);
                    } else {
                        window.location.href = `/${shopSlug}/admin/clients?edit_id=${item.id}`;
                    }
                } else if (type === 'order') {
                    if (currentPath.includes('/admin/orders')) {
                        this.clearSearch();
                        this.closeSearchModal();
                        editOrder(item.id, item.client_id || '', item.customer_name, item.customer_phone, item.total, item.status, item.payment_method, item.payment_status);
                    } else {
                        window.location.href = `/${shopSlug}/admin/orders?edit_id=${item.id}`;
                    }
                }
            },
            init() {
                this.syncConnectionStatus();

                window.addEventListener('online', () => {
                    this.syncConnectionStatus();
                });
                window.addEventListener('offline', () => {
                    Alpine.store('connection').online = false;
                });

                // Apply theme instantly on boot
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                this.$watch('darkMode', val => {
                    localStorage.setItem('admin-dark-mode', val);
                    if (val) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                });
                
                this.fetchNotifications();
                // Poll notifications every 30 seconds for live updates
                setInterval(() => {
                    this.fetchNotifications();
                }, 30000);

                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 768) {
                        this.closeSidebar();
                        document.body.style.overflow = '';
                    }
                });

                this.$watch('sidebarOpen', (open) => {
                    if (window.innerWidth < 768) {
                        document.body.style.overflow = open ? 'hidden' : '';
                    }
                });

                this.$watch('searchModalOpen', (open) => {
                    if (window.innerWidth < 768) {
                        document.body.style.overflow = open ? 'hidden' : (this.sidebarOpen ? 'hidden' : '');
                    }
                });
            },
            syncConnectionStatus() {
                const store = Alpine.store('connection');
                if (typeof navigator !== 'undefined' && !navigator.onLine) {
                    store.online = false;
                    return;
                }
                store.online = true;
            },
            async fetchNotifications() {
                try {
                    const response = await fetch(`/${this.shopSlug}/admin/notifications`);
                    const data = await response.json();
                    if (data.success) {
                        this.notifications = data.notifications;
                        this.unreadCount = data.unreadCount;
                        Alpine.store('connection').online = true;
                    }
                } catch (e) {
                    console.error('Error fetching notifications:', e);
                    if (typeof navigator !== 'undefined' && !navigator.onLine) {
                        Alpine.store('connection').online = false;
                    }
                }
            },
            async markAsRead(notif) {
                if (notif.is_read) return;
                try {
                    const response = await fetch(`/${this.shopSlug}/admin/notifications/${notif.id}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        notif.is_read = true;
                        this.unreadCount = data.unreadCount;
                    }
                } catch (e) {
                    console.error('Error marking notification as read:', e);
                }
            },
            async deleteNotification(id) {
                Swal.fire({
                    title: '¿Eliminar notificación?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--color-primary)',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        popup: 'rounded-3xl dark:bg-slate-900 dark:text-white',
                        title: 'font-black text-slate-800 dark:text-white',
                        htmlContainer: 'text-slate-500 dark:text-slate-400 text-xs font-semibold'
                    }
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/${this.shopSlug}/admin/notifications/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                                }
                            });
                            const data = await response.json();
                            if (data.success) {
                                this.notifications = this.notifications.filter(n => n.id !== id);
                                this.unreadCount = data.unreadCount;
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Notificación eliminada',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            }
                        } catch (e) {
                            console.error('Error deleting notification:', e);
                        }
                    }
                });
            },
            async clearAllNotifications() {
                Swal.fire({
                    title: '¿Limpiar todas las notificaciones?',
                    text: 'Se eliminarán permanentemente todas las notificaciones de la bandeja.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--color-primary)',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Sí, limpiar todo',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        popup: 'rounded-3xl dark:bg-slate-900 dark:text-white',
                        title: 'font-black text-slate-800 dark:text-white',
                        htmlContainer: 'text-slate-500 dark:text-slate-400 text-xs font-semibold'
                    }
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/${this.shopSlug}/admin/notifications`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                                }
                            });
                            const data = await response.json();
                            if (data.success) {
                                this.notifications = [];
                                this.unreadCount = 0;
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Bandeja de notificaciones vaciada',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            }
                        } catch (e) {
                            console.error('Error clearing notifications:', e);
                        }
                    }
                });
            },
            formatTime(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                const now = new Date();
                const diffMs = now - date;
                const diffMins = Math.floor(diffMs / 60000);
                
                if (diffMins < 1) return 'Hace un momento';
                if (diffMins < 60) return `Hace ${diffMins} min`;
                
                const diffHours = Math.floor(diffMins / 60);
                if (diffHours < 24) return `Hace ${diffHours} ${diffHours === 1 ? 'hora' : 'horas'}`;
                
                const diffDays = Math.floor(diffHours / 24);
                if (diffDays === 1) return 'Ayer';
                if (diffDays < 7) return `Hace ${diffDays} días`;
                
                return date.toLocaleDateString('es-ES', { day: '2-digit', month: 'short' });
            }
        }));
    });
</script>

<!-- Print Preview & Excel Controller Logic -->
<script>
    window.applyCustomExcelStyle = function(xlsx, brandColor) {
        var sheet = xlsx.xl.worksheets['sheet1.xml'];
        var styles = xlsx.xl['styles.xml'];

        var hexColor = brandColor.replace('#', '').toUpperCase();
        if(hexColor.length === 6) hexColor = 'FF' + hexColor;

        var fills = $('fills', styles);
        var cellXfs = $('cellXfs', styles);
        var fonts = $('fonts', styles);

        // Fuente Título (Blanco, Bold, 14)
        fonts.append('<font><b/><sz val="14"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>');
        var fontTitleId = fonts.find('font').length - 1;
        
        // Fuente Thead (Blanco, Bold, 11)
        fonts.append('<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>');
        var fontTheadId = fonts.find('font').length - 1;
        
        // Fuente Subtítulo (Gris oscuro, Italic, 10)
        fonts.append('<font><i/><sz val="10"/><color rgb="FF475569"/><name val="Calibri"/></font>');
        var fontSubId = fonts.find('font').length - 1;

        // Relleno Marca
        fills.append('<fill><patternFill patternType="solid"><fgColor rgb="' + hexColor + '"/><bgColor indexed="64"/></patternFill></fill>');
        var fillBrandId = fills.find('fill').length - 1;
        
        // Relleno Gris Claro (Subtítulo)
        fills.append('<fill><patternFill patternType="solid"><fgColor rgb="FFF1F5F9"/><bgColor indexed="64"/></patternFill></fill>');
        var fillGrayId = fills.find('fill').length - 1;

        fonts.attr('count', fonts.find('font').length);
        fills.attr('count', fills.find('fill').length);

        // Estilos XF
        var styleTitleXml = '<xf numFmtId="0" fontId="'+fontTitleId+'" fillId="'+fillBrandId+'" borderId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>';
        cellXfs.append(styleTitleXml);
        var styleTitleId = cellXfs.find('xf').length - 1;

        var styleSubXml = '<xf numFmtId="0" fontId="'+fontSubId+'" fillId="'+fillGrayId+'" borderId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>';
        cellXfs.append(styleSubXml);
        var styleSubId = cellXfs.find('xf').length - 1;

        var styleTheadXml = '<xf numFmtId="0" fontId="'+fontTheadId+'" fillId="'+fillBrandId+'" borderId="1" applyFont="1" applyFill="1" applyAlignment="1" applyBorder="1"><alignment horizontal="center" vertical="center"/></xf>';
        cellXfs.append(styleTheadXml);
        var styleTheadId = cellXfs.find('xf').length - 1;

        cellXfs.attr('count', cellXfs.find('xf').length);

        // Aplicar a celdas
        $('row[r="1"] c', sheet).attr('s', styleTitleId); // Título
        $('row[r="2"] c', sheet).attr('s', styleSubId);   // Subtítulo (messageTop)
        $('row[r="3"] c', sheet).attr('s', styleTheadId); // Thead
    };

    function openPrintPreview(dt) {
        // Deduzco el título según el texto del elemento de menú activo del sidebar
        let activeLinkText = $('aside a.bg-primary\\/10 span').text().trim() || 'General';
        if (!activeLinkText || activeLinkText === "") {
            activeLinkText = "Inventario de Tienda";
        }
        let reportTitle = "Reporte de " + activeLinkText;
        $('#preview-report-title').text(reportTitle);
        
        // Obtengo las cabeceras de columnas (ignorando la última que es Acciones)
        let headers = [];
        dt.columns().every(function(index) {
            if (index < dt.columns().count() - 1) {
                headers.push($(dt.column(index).header()).text().trim());
            }
        });
        
        // Obtengo los datos de las filas
        let rows = [];
        dt.rows({ search: 'applied', order: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
            let rowData = [];
            let cells = this.node().cells;
            for (let i = 0; i < cells.length - 1; i++) {
                let $cell = $(cells[i]);
                // Identifico si la celda tiene imágenes (ej: foto del producto)
                if ($cell.find('img').length > 0) {
                    rowData.push({ type: 'image', value: $cell.find('img').attr('src') });
                } else if ($cell.find('span.whitespace-nowrap').length > 0) {
                    // Es un badge con estilos
                    rowData.push({ type: 'badge', value: $cell.find('span').text().trim(), class: $cell.find('span').attr('class') });
                } else {
                    rowData.push({ type: 'text', value: $cell.text().trim() });
                }
            }
            rows.push(rowData);
        });
        
        $('#preview-record-count').text(rows.length);
        
        // Genero la tabla HTML limpia
        let tableHtml = '<thead><tr class="border-b border-slate-400 font-extrabold uppercase tracking-wider text-[10px]" style="background-color: var(--color-primary, #E60067) !important; color: var(--color-on-primary, #FFFFFF) !important;">';
        headers.forEach(h => {
            tableHtml += `<th class="px-4 py-3 border border-slate-300">${h}</th>`;
        });
        tableHtml += '</tr></thead><tbody>';
        
        if (rows.length === 0) {
            tableHtml += `<tr><td colspan="${headers.length}" class="px-4 py-8 text-center text-slate-400">No se encontraron registros.</td></tr>`;
        } else {
            rows.forEach(row => {
                tableHtml += '<tr class="border-b border-slate-200 text-slate-700 hover:bg-slate-50">';
                row.forEach(cell => {
                    tableHtml += '<td class="px-4 py-3 border border-slate-300 align-middle">';
                    if (cell.type === 'image') {
                        tableHtml += `<img src="${cell.value}" class="w-8 h-8 object-cover rounded-lg border border-slate-200">`;
                    } else if (cell.type === 'badge') {
                        tableHtml += `<span class="inline-block px-2.5 py-1 text-[10px] font-bold rounded-lg ${cell.class}">${cell.value}</span>`;
                    } else {
                        tableHtml += cell.value;
                    }
                    tableHtml += '</td>';
                });
                tableHtml += '</tr>';
            });
        }
        tableHtml += '</tbody>';
        
        $('#preview-table').html(tableHtml);
        
        // Muestro la modal
        $('#print-preview-modal').removeClass('hidden').addClass('flex');
    }
    
    function closePrintPreview() {
        $('#print-preview-modal').removeClass('flex').addClass('hidden');
    }
    
    function triggerPrint() {
        window.print();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            width: 'auto',
            padding: 0,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        @if(session('success') || session('success_short_link'))
            Toast.fire({
                icon: 'success',
                title: "{!! session('success') ?? session('success_short_link') !!}"
            });
        @endif
        
        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: 'Revisa los campos del formulario',
                text: @json($errors->first())
            });
        @elseif(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{!! session('error') !!}"
            });
        @elseif(session('plan_module_blocked'))
            Toast.fire({
                icon: 'info',
                title: "{!! session('plan_module_blocked') !!}"
            });
        @endif
    });
</script>
