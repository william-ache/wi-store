@if (!empty($company['has_cashea']))
    <span class="inline-flex items-center shadow-sm"
          title="Financiamiento Cashea disponible">
        <img src="{{ asset('images/cashea-logo.png') }}" alt="Cashea" class="h-5 w-5 rounded-md object-contain cashea-logo-badge">
    </span>
@endif
@if (!empty($company['has_krece']))
    <span class="inline-flex items-center shadow-sm"
          title="Financiamiento Krece disponible">
        <img src="{{ asset('images/krece-logo.png') }}" alt="Krece" class="h-5 w-5 rounded-md object-contain krece-logo-badge">
    </span>
@endif
