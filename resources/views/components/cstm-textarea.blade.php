@props(['disabled' => false])
<textarea rows="4" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge([ 'class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' ]) }}>{{ $slot }}</textarea>
