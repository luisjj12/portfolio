@props(['disabled' => false])

<a 
    {{ $disabled ? 'aria-disabled="true" tabindex="-1" ' : '' }}
    {!! $attributes->merge([
        'class' => 'inline-block px-4 py-2 text-gray-800  focus:outline-none'
    ]) !!}
>
    {{ $slot }}
</a>
