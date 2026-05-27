<button {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-md px-3 py-1.5 text-sm font-medium shadow-sm transition-colors duration-150 bg-primary-600 hover:bg-primary-700 text-white']) }}>
    {{ $slot }}
</button>
