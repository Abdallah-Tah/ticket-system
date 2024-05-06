<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800 underline italic font-bold">
        {{ __('Tickets') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg">
            <div class="flex flex-col">
                <div class="flex flex-row justify-between p-4">
                    <div class="flex flex-row">
                        <input wire:model="search" type="text" placeholder="Search..." wire:model.live="search"
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
                <div class="flex justify-between px-6 py-3">
                    <div class="flex justify-between">
                        <div class="flex items-center">
                            <span class="text-sm text-gray-700">Showing</span>
                            <select wire:model.live="perPage"
                                class="mx-2 border rounded-md form-select form-select-sm text-gray-600 text-sm">
                                <option>10</option>
                                <option>15</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                            <span class="text-sm text-gray-700">Entries</span>
                        </div>
                    </div>
                </div>

                <thead class="bg-gray-50 divide-y divide-gray-200 divide-solid rounded-lg">
                    <tr class="bg-gray-50">
                        <th class="py-3 px-6 text-left text-gray-500 text-sm">
                            <div class="flex items-center text-gray-500">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Claim
                                    Number
                                </span>
                                <x-icon-sort-asc sortField="claim_number" :sort-by="$sortColumn" :sort-asc="$sortAsc" />
                            </div>
                        </th>
                        <th class="py-3 px-6 text-left text-gray-500 text-sm">
                            <div class="flex items-center text-gray-500">
                                <span
                                    class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Title</span>
                                <x-icon-sort-asc sortField="title" :sort-by="$sortColumn" :sort-asc="$sortAsc" />
                            </div>
                        </th>
                        <th class="py-3 px-6 text-left text-gray-500 text-sm">
                            <div class="flex items-center text-gray-500">
                                <span
                                    class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Created
                                    At</span>
                                <x-icon-sort-asc sortField="SupplierAddressID" :sort-by="$sortColumn" :sort-asc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Action</span>
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 divide-solid rounded-lg">
                    @forelse ($tickets as $item)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 text-sm leading-5 text-gray-900 underline cursor-pointer hover:text-blue-800"
                                wire:click="viewTicket({{ $item->id }})" wire:loading.class.delay="opacity-50">
                                {{ $item->claim_number }}
                            </td>
                            <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                <span class="bg-gray-200 rounded-md px-2 py-3 font-semibold text-md">
                                    {{ $item->title }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                {{ $item->created_at->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                <div class="flex items-center space-x-2">
                                    <x-secondary-button wire:click="showEditModal({{ $item->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 14v5m0 0v-5m0 5h-5m5 0h5" />
                                        </svg>
                                    </x-secondary-button>
                                    <x-danger-button wire:click="showDeleteModal({{ $item->id }})">
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
                            <td class="px-6 py-4 text-sm leading-5 text-gray-900" colspan="4">
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
                <span class="mx-2 text-sm text-gray-700">{{ $tickets->firstItem() }}</span>
                <span class="text-sm text-gray-700">to</span>
                <span class="mx-2 text-sm text-gray-700">{{ $tickets->lastItem() }}</span>
                <span class="text-sm text-gray-700">of</span>
                <span class="mx-2 text-sm text-gray-700">{{ $tickets->total() }}</span>
                <span class="text-sm text-gray-700">Entries</span>
            </div>
            <div class="flex items-center">
                {{ $tickets->links() }}
            </div>
        </div>

        <div>
            <x-dialog wire:model.live="showModal" maxWidth="5xl" enctype="multipart/form-data">
                <x-slot name="title">
                    {{ $ticket_id ? 'Edit Ticket' : 'Create Ticket' }}
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
                        <x-label for="claim_number" :value="__('Claim Number')" class="ml-2" />
                        <div class="flex items-center">
                            <x-text-input wire:model="claim_number" id="claim_number" class="block mt-1 w-full"
                                type="number" autofocus />
                        </div>
                        @error('claim_number')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="title" :value="__('Title')" class="ml-2" />
                        <div class="flex items-center">
                            <x-text-input wire:model="title" id="title" class="block mt-1 w-full"
                                type="text" />
                        </div>
                        @error('title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4 relative">
                        <x-label for="department_id" :value="__('Department')" class="ml-2" />
                        <div class="flex items-center">
                            <select wire:model="department_id" id="department_id"
                                class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('department_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4 relative">
                        <x-label for="category_id" :value="__('Category')" class="ml-2" />
                        <div class="flex items-center">
                            <select wire:model="category_id" id="category_id"
                                class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4 relative">
                        <x-label for="plan_id" :value="__('Plan')" class="ml-2" />
                        <div class="flex items-center">
                            <select wire:model="plan_id" id="plan_id"
                                class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Plan</option>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('plan_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4 relative">
                        <x-label for="status_id" :value="__('Status')" class="ml-2" />
                        <div class="flex items-center">
                            <select wire:model="status_id" id="status_id"
                                class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('status_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4 relative">
                        <x-label for="priority_id" :value="__('Priority')" class="ml-2" />
                        <div class="flex items-center">
                            <select wire:model="priority_id" id="priority_id"
                                class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Priority</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('priority_id')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <x-label for="requestor_name" :value="__('Requestor Name')" class="ml-2" />
                        <div class="flex items-center">
                            <x-text-input wire:model="requestor_name" id="requestor_name" class="block mt-1 w-full"
                                type="text" />
                        </div>
                        @error('requestor_name')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <x-label for="problem_statement" :value="__('Problem Statement')" class="ml-2" />
                        <div class="flex items-center">
                            <x-textarea-input wire:model="problem_statement" id="problem_statement"
                                class="block mt-1 w-full" type="text" />
                        </div>
                        @error('problem_statement')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <x-label for="target_date" :value="__('Target Date')" class="ml-2" />
                        <div class="flex items-center">
                            <x-text-input wire:model="target_date" id="target_date" class="block mt-1 w-full"
                                type="date" />
                        </div>
                        @error('target_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button class="ml-4" wire:click="$toggle('showModal')"
                        wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    @if ($ticket_id)
                        <x-primary-button class="ml-4" wire:click="updateTicket" wire:loading.attr="disabled">
                            {{ __('Update') }}
                        </x-primary-button>
                    @else
                        <x-primary-button class="ml-4" wire:click="createTicket" wire:loading.attr="disabled">
                            {{ __('Create') }}
                        </x-primary-button>
                    @endif
                </x-slot>
            </x-dialog>
        </div>
    </div>
</div>
