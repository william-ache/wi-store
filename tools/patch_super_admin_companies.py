from pathlib import Path

p = Path(__file__).resolve().parents[1] / 'resources/views/super-admin/companies/index.blade.php'
lines = p.read_text(encoding='utf-8').splitlines(keepends=True)

xdata_lines = lines[162:216]  # lines 163-216 in 1-based (content of x-data)
xdata_body = ''.join(xdata_lines)
if xdata_body.startswith('    '):
    xdata_body = xdata_body[4:]
if xdata_body.endswith('}">\n'):
    xdata_body = xdata_body[:-3]
elif xdata_body.rstrip().endswith('}'):
    xdata_body = xdata_body.rstrip()
    if xdata_body.endswith('">'): 
        xdata_body = xdata_body[:-2]

content = ''.join(lines[287:1344])
scripts = ''.join(lines[1348:1385])
scripts = scripts.replace('<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>\n', '')
scripts = scripts.replace('<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>\n', '')

header = """@extends('layouts.super-admin')

@section('title', 'Empresas — Super Admin')

@section('page-header')
    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Empresas</h1>
    <p class="text-sm text-slate-500 mt-1">Lista global, activación de tiendas y aprobación de pagos.</p>
@endsection

@section('content')
<div class="w-full" x-data="
"""

footer = """
</div>
@endsection

@push('scripts')
""" + scripts + """@endpush
"""

out = header + xdata_body + '">\n' + content + footer

replacements = [
    ('glass-panel', 'sa-panel'),
    ('neon-btn', 'sa-btn-primary'),
    ('border-white/5', 'border-slate-200'),
    ('border-white/10', 'border-slate-200'),
    ('bg-white/5', 'bg-slate-50'),
    ('bg-white/[0.02]', 'bg-slate-50'),
    ('hover:bg-white/10', 'hover:bg-slate-100'),
    ('text-slate-100', 'text-slate-900'),
    ('text-white tracking-tight">Tiendas', 'text-slate-900 tracking-tight">Tiendas'),
    ('text-white mb-2', 'text-slate-900 mb-2'),
    ('text-white font-bold', 'text-slate-900 font-bold'),
    ('text-white font-black', 'text-slate-900 font-black'),
    ('text-white tabular-nums', 'text-slate-900 tabular-nums'),
    ('<h3 class="text-sm font-bold text-white">', '<h3 class="text-sm font-bold text-slate-900">'),
    ('text-violet-400', 'text-purple-600'),
    ('text-slate-400', 'text-slate-500'),
    ('text-slate-300', 'text-slate-600'),
    ('text-slate-350', 'text-slate-600'),
    ('text-slate-450', 'text-slate-500'),
    ('text-rose-350', 'text-rose-700'),
    ('text-rose-450', 'text-rose-700'),
    ('text-emerald-450', 'text-emerald-700'),
    ('bg-slate-800/80', 'bg-slate-100'),
]

for old, new in replacements:
    out = out.replace(old, new)

p.write_text(out, encoding='utf-8')
print('Written', len(out), 'chars')
