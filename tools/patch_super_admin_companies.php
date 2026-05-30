<?php

$path = dirname(__DIR__) . '/resources/views/super-admin/companies/index.blade.php';
$lines = file($path, FILE_IGNORE_NEW_LINES);
if ($lines === false) {
    fwrite(STDERR, "Cannot read file\n");
    exit(1);
}

$raw = file_get_contents($path);
$parts = preg_split('/<body[^>]*x-data="/', $raw, 2);
if (count($parts) < 2) {
    fwrite(STDERR, "x-data not found\n");
    exit(1);
}
$after = $parts[1];
$end = strpos($after, '">');
$xdata = substr($after, 0, $end);

$mainStart = strpos($raw, '<!-- MAIN LAYOUT GRID');
$scriptsStart = strpos($raw, '<!-- Scripts -->');
$content = substr($raw, $mainStart, $scriptsStart - $mainStart);
$scriptsBlock = substr($raw, $scriptsStart);
$scriptsBlock = preg_replace('#<script src="https://code\.jquery\.com/jquery[^<]+</script>\s*#', '', $scriptsBlock);
$scriptsBlock = preg_replace('#<script src="https://cdn\.datatables\.net[^<]+</script>\s*#', '', $scriptsBlock);
$scriptsBlock = preg_replace('#</body>\s*</html>\s*$#', '', $scriptsBlock);

$out = <<<BLADE
@extends('layouts.super-admin')

@section('title', 'Empresas — Super Admin')

@section('page-header')
    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Empresas</h1>
    <p class="text-sm text-slate-500 mt-1">Lista global, activación de tiendas y aprobación de pagos.</p>
@endsection

@section('content')
<div class="w-full" x-data="{$xdata}">
{$content}</div>
@endsection

@push('scripts')
{$scriptsBlock}
@endpush

BLADE;

$replacements = [
    'glass-panel' => 'sa-panel',
    'neon-btn' => 'sa-btn-primary',
    'border-white/5' => 'border-slate-200',
    'border-white/10' => 'border-slate-200',
    'bg-white/5' => 'bg-slate-50',
    'bg-white/[0.02]' => 'bg-slate-50',
    'hover:bg-white/10' => 'hover:bg-slate-100',
    'text-violet-400' => 'text-purple-600',
    'text-slate-400' => 'text-slate-500',
    'text-slate-300' => 'text-slate-600',
    'text-slate-350' => 'text-slate-600',
    'text-slate-450' => 'text-slate-500',
    'text-rose-350' => 'text-rose-700',
    'text-rose-450' => 'text-rose-700',
    'text-emerald-450' => 'text-emerald-700',
    'bg-slate-800/80' => 'bg-slate-100',
    '<h2 class="text-xl font-bold text-white' => '<h2 class="text-xl font-bold text-slate-900',
    '<h3 class="text-sm font-bold text-white">' => '<h3 class="text-sm font-bold text-slate-900">',
    'text-sm font-bold text-white bg-white/5' => 'text-sm font-bold text-slate-800 bg-slate-100',
    'text-white font-extrabold' => 'text-slate-900 font-extrabold',
];

foreach ($replacements as $from => $to) {
    $out = str_replace($from, $to, $out);
}

file_put_contents($path, $out);
echo "OK " . strlen($out) . " bytes\n";
