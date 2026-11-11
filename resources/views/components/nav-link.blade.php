@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center h-16 px-3 border-b-2 border-amber-500 text-sm font-medium text-slate-900 dark:text-white transition-colors duration-150'
            : 'inline-flex items-center h-16 px-3 border-b-2 border-transparent text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-600 transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
