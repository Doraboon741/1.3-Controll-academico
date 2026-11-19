@props(['equivalence'])

@php
    $colors = [
        'AU' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
        'DE' => 'bg-blue-100 text-blue-800 border-blue-300',
        'SA' => 'bg-amber-100 text-amber-800 border-amber-300',
        'NA' => 'bg-red-100 text-red-800 border-red-300',
    ];
    $style = $colors[$equivalence] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="px-2.5 py-0.5 text-xs font-bold rounded-full border {{ $style }}">
    {{ $equivalence }}
</span>