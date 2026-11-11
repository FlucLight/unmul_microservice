@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-2 w-full ps-3 pe-4 py-2.5 border-l-2 border-amber-500 text-start text-sm font-medium text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10 transition-colors duration-150'
            : 'flex items-center gap-2 w-full ps-3 pe-4 py-2.5 border-l-2 border-transparent text-start text-sm font-medium text-slate-700 dark:text-slate-200 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-600 transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
