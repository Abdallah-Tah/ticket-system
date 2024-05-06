<div>
    <select
        {{ $attributes->merge([
            'class' => 'flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
            dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-gray-900 dark:text-gray-300 dark:placeholder-gray-500 dark:focus:border-gray-600',
        ]) }}>
        {{ $slot }}
    </select>
</div>
