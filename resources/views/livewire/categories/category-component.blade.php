<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800 underline">
        {{ __('Category') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg">
            <div class="flex flex-col">
                <div class="flex flex-row justify-between p-4">
                    <div class="flex flex-row">
                        <input wire:model="search" type="text" placeholder="Search categories..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-800 focus:border-blue-800 sm:text-sm" />
                    </div>
                    <div class="ml-4">
                        <x-primary-button wire:click="openModal" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            {{ __('Add New') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-hidden overflow-x-auto mb-4 sm:rounded-lg shadow-lg border border-gray-200 bg-white">
            <table class="w-full table-auto border divide-y divide-gray-200 divide-solid rounded-lg">
                <thead class="bg-gray-50 divide-y divide-gray-200 divide-solid rounded-lg">
                    <tr class="bg-gray-50">
                        <th class="py-3 px-6 text-left text-gray-500 text-sm">
                            <div class="flex items-center text-gray-500">
                                <span
                                    class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Name</span>
                                <x-icon-sort-asc sortField="name" :sort-by="$sortColumn" :sort-asc="$sortAsc" />
                            </div>
                        </th>
                        <th class="py-3 px-6 text-left text-gray-500 text-sm">
                            <div class="flex items-center text-gray-500">
                                <span
                                    class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Created
                                    At</span>
                                <x-icon-sort-asc sortField="created_at" :sort-by="$sortColumn" :sort-asc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Action</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 divide-solid rounded-lg">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                {{ $category->created_at->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                <div class="flex items-center space-x-2">
                                    <x-secondary-button wire:click="editCategory({{ $category->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 14v5m0 0v-5m0 5h-5m5 0h5" />
                                        </svg>
                                    </x-secondary-button>
                                    <x-danger-button wire:click="showDeleteModal({{ $category->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </x-danger-button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 text-sm leading-5 text-gray-900" colspan="3">
                                No data found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex justify-between px-6 py-3">
            <div class="flex items-center">
                <span class="text-sm text-gray-700">Showing</span>
                <span class="mx-2 text-sm text-gray-700">{{ $categories->firstItem() }}</span>
                <span class="text-sm text-gray-700">to</span>
                <span class="mx-2 text-sm text-gray-700">{{ $categories->lastItem() }}</span>
                <span class="text-sm text-gray-700">of</span>
                <span class="mx-2 text-sm text-gray-700">{{ $categories->total() }}</span>
                <span class="text-sm text-gray-700">Entries</span>
            </div>
            <div class="flex items-center">
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    <div>
        <x-dialog wire:model.live="showModal" maxWidth="5xl" enctype="multipart/form-data">
            <x-slot name="title">
                {{ $categoryId ? 'Edit Category' : 'Create Category' }}
            </x-slot>
            <x-slot name="content">
                @if ($error_string != '')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{!! $error_string !!}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg wire:click="clearError" class="fill-current h-6 w-6 text-red-500" role="button"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path
                                    d="M14.348 14.849a1 1 0 0 1-1.414 0L10 11.414l-2.93 2.93a1 1 0 1 1-1.414-1.414l2.93-2.93-2.93-2.93a1 1 0 1 1 1.414-1.414l2.93 2.93 2.93-2.93a1 1 0 1 1 1.414 1.414l-2.93 2.93 2.93 2.93a1 1 0 0 1 0 1.414z">
                                </path>
                            </svg>
                        </span>
                    </div>
                @endif
                <div class="mt-4">
                    <x-label for="name" :value="__('Name')" class="ml-2" />
                    <div class="flex items-center">
                        <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text"
                            autofocus />
                    </div>
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button class="ml-4" wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
                @if ($categoryId)
                    <x-primary-button class="ml-4" wire:click="updateCategory" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-primary-button>
                @else
                    <x-primary-button class="ml-4" wire:click="createCategory" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-primary-button>
                @endif
            </x-slot>
        </x-dialog>
    </div>

    <div>
        <x-dialog wire:model.live="deleteModal" maxWidth="2xl">
            <x-slot name="title">
                {{ __('Delete Category') }}
            </x-slot>
            <x-slot name="content">
                Are you sure you want to delete this category <span class="font-semibold text-red-500">
                    {{ $name }}</span>?
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button class="ml-4" wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-danger-button class="ml-4" wire:click="deleteCategory" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-danger-button>
            </x-slot>
        </x-dialog>
    </div>
</div>
