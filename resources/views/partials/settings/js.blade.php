@php
    $currentHours = old('work_hours', $shop->work_hours ?? null);
    if (is_string($currentHours)) {
        $decodedHours = json_decode($currentHours, true);
        if ($decodedHours !== null) {
            $currentHours = $decodedHours;
        }
    }
    $isCustom = is_array($currentHours) && isset($currentHours['type']) && $currentHours['type'] === 'custom';

    $paymentMethods = $shop->payment_methods ? json_decode($shop->payment_methods, true) : [];
    if (empty($paymentMethods)) {
        $paymentMethods = [
            'Efectivo' => ['active' => true, 'details' => ''],
            'Pago Móvil' => ['active' => true, 'details' => ''],
        ];
    }
    $availableMethods = [
        'Transferencia' => ['color' => 'bg-slate-600 text-white border-slate-600 shadow-sm', 'placeholder' => 'Banco, Número de Cuenta, Titular, RIF...'],
        'Pago Móvil' => ['color' => 'bg-teal-500 text-white border-teal-500 shadow-sm', 'placeholder' => 'Banco, Teléfono, Cédula...'],
        'Efectivo' => ['color' => 'bg-emerald-600 text-white border-emerald-600 shadow-sm', 'placeholder' => 'Detalles (ej: Traer sencillo, Se acepta cambio...)'],
        'Zelle' => ['color' => 'bg-purple-600 text-white border-purple-600 shadow-sm', 'placeholder' => 'Correo de Zelle, Nombre...'],
        'Binance' => ['color' => 'bg-yellow-500 text-white border-yellow-500 shadow-sm', 'placeholder' => 'Pay ID, Correo, USDT...'],
        'PayPal' => ['color' => 'bg-blue-600 text-white border-blue-600 shadow-sm', 'placeholder' => 'Correo de cuenta...'],
        'Punto de Venta' => ['color' => 'bg-indigo-500 text-white border-indigo-500 shadow-sm', 'placeholder' => 'Detalles (ej: Pago directo al retirar/recibir...)'],
    ];
@endphp
<script>
    // Tab management
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        // Show selected tab content
        document.getElementById('content-' + tabName).classList.add('active');
        
        // Update button styles
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-primary', 'text-white', 'font-black', 'shadow-md', 'shadow-primary/20', 'border-primary');
            btn.classList.add('bg-white', 'dark:bg-slate-900', 'text-slate-600', 'dark:text-slate-400', 'border-slate-200', 'dark:border-slate-850', 'hover:bg-slate-50', 'dark:hover:bg-slate-800/50', 'shadow-sm');
        });
        
        // Activate selected button
        const activeBtn = document.getElementById('tab-' + tabName);
        activeBtn.classList.remove('bg-white', 'dark:bg-slate-900', 'text-slate-600', 'dark:text-slate-400', 'border-slate-200', 'dark:border-slate-850', 'hover:bg-slate-50', 'dark:hover:bg-slate-800/50', 'shadow-sm');
        activeBtn.classList.add('active', 'bg-primary', 'text-white', 'font-black', 'shadow-md', 'shadow-primary/20', 'border-primary');
    }

    // Exchange Rate fetching
    async function fetchExchangeRate() {
        const select = document.getElementById('base_currency');
        const exchangeInput = document.getElementById('exchange_rate');
        const loadingDiv = document.getElementById('exchange-loading');
        const currency = select.value;

        if (currency === 'USD' || currency === 'EUR') {
            loadingDiv.style.display = 'block';
            try {
                const endpoint = currency === 'USD' 
                    ? 'https://ve.dolarapi.com/v1/dolares/oficial' 
                    : 'https://ve.dolarapi.com/v1/euros/oficial';
                let res = await fetch(endpoint);
                if (res.ok) {
                    let data = await res.json();
                    if (data && data.promedio) {
                        exchangeInput.value = 'Bs. ' + parseFloat(data.promedio).toFixed(2);
                    }
                }
            } catch (e) {
                console.error('Error fetching rate from DolarAPI', e);
            }
            loadingDiv.style.display = 'none';
        }
    }

    // GPS location
    let gpsLoading = false;
    async function getGPSLocation() {
        if (!navigator.geolocation) {
            Swal.fire({
                icon: 'error',
                title: 'GPS no soportado',
                text: 'Tu navegador o dispositivo no soporta la geolocalización.'
            });
            return;
        }

        gpsLoading = true;
        document.getElementById('gps-icon').style.display = 'none';
        document.getElementById('gps-loading').style.display = 'flex';

        navigator.geolocation.getCurrentPosition(
            (position) => {
                document.getElementById('latitude').value = position.coords.latitude.toFixed(6);
                document.getElementById('longitude').value = position.coords.longitude.toFixed(6);
                gpsLoading = false;
                document.getElementById('gps-icon').style.display = 'flex';
                document.getElementById('gps-loading').style.display = 'none';

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'success',
                    title: 'GPS Sincronizado',
                    text: 'Se han establecido las coordenadas actuales.'
                });

                const googleMapsLink = document.getElementById('google_maps_link');
                if (!googleMapsLink.value) {
                    googleMapsLink.value = `https://www.google.com/maps?q=${position.coords.latitude.toFixed(6)},${position.coords.longitude.toFixed(6)}`;
                }
            },
            (error) => {
                gpsLoading = false;
                document.getElementById('gps-icon').style.display = 'flex';
                document.getElementById('gps-loading').style.display = 'none';
                let msg = 'No se pudo obtener la ubicación.';
                if (error.code === error.PERMISSION_DENIED) {
                    msg = 'Permiso denegado. Por favor, concede acceso al GPS en tu navegador.';
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    msg = 'La ubicación física no está disponible en este momento.';
                } else if (error.code === error.TIMEOUT) {
                    msg = 'Tiempo de espera agotado al intentar conectar con el satélite GPS.';
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Ubicación no obtenida',
                    text: msg
                });
            },
            { enableHighAccuracy: true, timeout: 8000 }
        );
    }

    // Work Hours Toggle
    let workHoursType = '{{ $isCustom ? "custom" : "simple" }}';
    function toggleWorkHoursType() {
        workHoursType = workHoursType === 'simple' ? 'custom' : 'simple';
        document.getElementById('work_hours_type').value = workHoursType;
        document.getElementById('work-hours-toggle-text').textContent = workHoursType === 'simple' ? 'Avanzado' : 'Texto Simple';
        document.getElementById('work-hours-simple').style.display = workHoursType === 'simple' ? 'block' : 'none';
        document.getElementById('work-hours-custom').style.display = workHoursType === 'custom' ? 'block' : 'none';
    }

    // Payment Methods Management
    let paymentMethods = {!! json_encode($paymentMethods) !!};
    function togglePaymentMethod(name) {
        if (!paymentMethods[name]) {
            paymentMethods[name] = { active: true, details: '' };
        } else {
            paymentMethods[name].active = !paymentMethods[name].active;
        }
        updatePaymentUI();
    }

    function updatePaymentUI() {
        // Update buttons
        document.querySelectorAll('.flex.flex-wrap.gap-1 button').forEach(btn => {
            const name = btn.querySelector('span').textContent;
            const isActive = paymentMethods[name] && paymentMethods[name].active;
            const config = {!! json_encode($availableMethods) !!};
            if (isActive) {
                btn.className = config[name].color + ' px-2 py-0.5 rounded-lg border text-[9px] font-bold transition-all duration-300 select-none flex items-center gap-1 focus:outline-none';
                if (!btn.querySelector('svg')) {
                    btn.insertAdjacentHTML('afterbegin', '<svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>');
                }
            } else {
                btn.className = 'ui-surface text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-750 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-sm px-2 py-0.5 rounded-lg border text-[9px] font-bold transition-all duration-300 select-none flex items-center gap-1 focus:outline-none';
                const svg = btn.querySelector('svg');
                if (svg) svg.remove();
            }
        });

        // Update details sections
        Object.keys(paymentMethods).forEach(name => {
            const detailDiv = document.getElementById('payment-' + name);
            if (detailDiv) {
                if (paymentMethods[name].active) {
                    detailDiv.classList.remove('hidden');
                } else {
                    detailDiv.classList.add('hidden');
                }
            }
        });

        // Update hidden input
        document.getElementById('payment_methods_json').value = JSON.stringify(paymentMethods);
    }

    // Image previews
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // 1. Update standard preview in the upload card
                var previewImg = document.getElementById(previewId);
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                }

                // Hide standard placeholder svg if it exists
                var placeholder = document.getElementById(previewId + '-placeholder');
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }

                // 2. Update live mockup preview in the smartphone simulator
                var mockPreviewId = 'mock-' + previewId;
                var mockPreviewImg = document.getElementById(mockPreviewId);
                if (mockPreviewImg) {
                    mockPreviewImg.src = e.target.result;
                    mockPreviewImg.classList.remove('hidden');
                }

                // Hide mockup placeholder if it exists
                var mockPlaceholder = document.getElementById(mockPreviewId + '-placeholder');
                if (mockPlaceholder) {
                    mockPlaceholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Copy Shortlink
    function copyShortLink(url) {
        navigator.clipboard.writeText(url).then(function() {
            var toast = document.getElementById('toast-notification');
            toast.style.display = 'block';
            setTimeout(function() {
                toast.style.display = 'none';
            }, 2500);
        });
    }

    // Color Pickers logic
    function updateColorPreview(inputId, previewId) {
        var input = document.getElementById(inputId);
        var preview = document.getElementById(previewId);
        if (input && preview) {
            preview.style.backgroundColor = input.value;
        }
    }

    function updateColorFromText(textInputId, colorInputId, previewId) {
        var textInput = document.getElementById(textInputId);
        var colorInput = document.getElementById(colorInputId);
        var preview = document.getElementById(previewId);
        if (textInput && colorInput && preview) {
            colorInput.value = textInput.value;
            preview.style.backgroundColor = textInput.value;
        }
    }

    // Category Icon update
    function updateShopCategoryIcon(category) {
        const iconInput = document.getElementById('shop_category_icon');
        const categoryIcons = {
            'gastronomia': 'fas fa-utensils',
            'moda_estilo': 'fas fa-tshirt',
            'detalles_regalos': 'fas fa-gift',
            'servicios': 'fas fa-tools',
            'otros': 'fas fa-box'
        };
        
        if (iconInput && categoryIcons[category]) {
            iconInput.value = categoryIcons[category];
        } else if (iconInput) {
            iconInput.value = '';
        }
    }

    // DomContentLoaded initializations
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 if exists
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('#base_currency').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
            // Trigger rate fetch on select2 change
            $('#base_currency').on('change', function() {
                fetchExchangeRate();
            });
        }

        // Fetch rate on page load if exchange rate is empty
        const exchangeInput = document.getElementById('exchange_rate');
        if (exchangeInput && !exchangeInput.value) {
            fetchExchangeRate();
        }

        // Sync textarea values with paymentMethods
        document.querySelectorAll('#payment-details textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                const name = this.name.replace('payment_details[', '').replace(']', '');
                if (paymentMethods[name]) {
                    paymentMethods[name].details = this.value;
                }
            });
        });

        // Initialize category icon
        const categorySelect = document.getElementById('shop_category');
        if (categorySelect && categorySelect.value) {
            updateShopCategoryIcon(categorySelect.value);
        }
    });
</script>
