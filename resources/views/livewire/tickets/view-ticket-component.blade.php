<div>
    <div class="py-12 px-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket View') }}
        </h2>
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-lg bg-white p-6 mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong class="text-gray-600">Title:</strong> {{ $ticket->title }}</div>
                <div><strong class="text-gray-600">Requestor Name:</strong> {{ $ticket->requestor_name }}</div>
                <div><strong class="text-gray-600">Department:</strong> {{ $ticket->department->name }}</div>
                <div><strong class="text-gray-600">Plan:</strong> {{ $ticket->plan->name }}</div>
                <div><strong class="text-gray-600">Category:</strong> {{ $ticket->category->name }}</div>
                <div><strong class="text-gray-600">Claim Number:</strong> {{ $ticket->claim_number }}</div>
                <div><strong class="text-gray-600">Target Date:</strong> {{ $ticket->target_date }}</div>
                <div><strong class="text-gray-600">Attachment:</strong>
                    <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank"
                        class="text-blue-500 hover:text-blue-600">View Attachment</a>
                </div>
                <div><strong class="text-gray-600">Status:</strong>
                    <span class="px-3 py-1 bg-blue-200 text-blue-600 rounded-full">
                        {{ $ticket->status->name }}
                    </span>
                </div>
                <div><strong class="text-gray-600">Created At:</strong> {{ $ticket->created_at }}</div>
                <div><strong class="text-gray-600">Problem Statement:</strong> {{ $ticket->problem_statement }}</div>
            </div>
        </div>
    </div>

    <div class="mt-2 px-4 mb-6">
        <h3 class="font-semibold text-lg text-gray-800 mb-4">Comments</h3>
        <div class="space-y-4">
            @foreach ($ticketComments as $comment)
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-gray-800 font-semibold">{{ $comment->user->name }}</span>
                        <span class="text-sm text-gray-600">{{ $comment->created_at }}</span>
                    </div>
                    @if ($editingCommentId === $comment->id)
                        <div x-data="simpleMDEInit()" x-init="initEditor()" x-on:livewire-update="refreshEditor()"
                            wire:ignore>
                            <textarea x-ref="editor" class="hidden">{{ $comment->message }}</textarea>
                            @error('comment')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            <x-primary-button wire:click="updateComment" class="mt-2">
                                {{ __('Update Comment') }}
                            </x-primary-button>
                        </div>
                    @else
                        {!! Illuminate\Support\Str::markdown($comment->message) !!}
                    @endif
                    @if ($comment->user_id == auth()->id())
                        <div class="flex justify-end space-x-2 mt-2">
                            <x-edit-button wire:click="editComment({{ $comment->id }})"></x-edit-button>
                            <x-delete-button wire:click="showDeleteComment({{ $comment->id }})"></x-delete-button>
                        </div>
                    @endif
                </div>
            @endforeach

            <div x-data="simpleMDEInit()" x-init="initEditor()" x-on:livewire-update="refreshEditor()" wire:ignore>
                <textarea x-ref="editor" class="hidden"></textarea>
                @error('comment')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
                <x-primary-button wire:click="createComment" class="mt-2">
                    {{ __('Add Comment') }}
                </x-primary-button>
            </div>
        </div>

        <x-dialog wire:model.live="showModal" maxWidth="5xl" enctype="multipart/form-data">
            <x-slot name="title">
                {{ $commentId ? 'Edit Comment' : 'Create Comment' }}
            </x-slot>
            <x-slot name="content">
                <div class="mt-4">
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
                        <x-label for="comment" :value="__('Comment')" class="ml-2" />
                        <div class="flex items-center w-full">
                            <input wire:model="comment" id="comment"
                                class="block mt-1 w-full border border-gray-300 p-2 rounded" rows="3"
                                autofocus></input>
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button class="ml-4" wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
                @if ($commentId)
                    <x-primary-button class="ml-4" wire:click="updateComment" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-primary-button>
                @else
                    <x-primary-button class="ml-4" wire:click="createComment" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-primary-button>
                @endif
            </x-slot>
        </x-dialog>
    </div>

    <div>
        <x-dialog wire:model.live="deleteModal" maxWidth="2xl">
            <x-slot name="title">
                {{ __('Delete Comment') }}
            </x-slot>
            <x-slot name="content">
                Are you sure you want to delete this comment <span class="font-semibold text-red-500">
                    {{ $name }}</span>?
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button class="ml-4" wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-danger-button class="ml-4" wire:click="deleteComment" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-danger-button>
            </x-slot>
        </x-dialog>
    </div>
</div>

@push('scripts')
    <script>
        function simpleMDEInit() {
            return {
                editor: null,
                initEditor() {
                    this.editor = new SimpleMDE({
                        element: this.$refs.editor,
                        spellChecker: false,
                        forceSync: false,
                        status: false,
                    });
                    this.editor.value(this.$refs.editor.textContent || '');
                    this.editor.codemirror.on('change', () => {
                        @this.set('comment', this.editor.value());
                    });
                },
                refreshEditor() {
                    if (this.editor) {
                        this.editor.value(this.$refs.editor.textContent || '');
                        this.editor.codemirror.refresh(); // Refresh to update the editor display
                    }
                }
            }
        }
    </script>
@endpush
</div>
