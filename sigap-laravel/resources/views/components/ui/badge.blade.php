@props(['status' => 'diajukan'])

@php
$styles = [
    'diajukan' => 'border-panen text-panen bg-panen/10',
    'diproses' => 'border-panen text-panen bg-panen/10',
    'selesai' => 'border-padi text-padi bg-padi/10',
    'ditolak' => 'border-red-700 text-red-700 bg-red-700/10',
];
$style = $styles[$status] ?? $styles['diajukan'];
@endphp

<span class="inline-flex items-center px-3 py-1 rounded border-2 border-dashed text-xs font-semibold uppercase tracking-wide -rotate-1 {{ $style }}">
    {{ $status }}
</span>
