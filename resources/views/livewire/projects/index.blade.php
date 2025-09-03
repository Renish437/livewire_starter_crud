<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Project Management') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create and manage your projects') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="mb-6 flex w-full items-center justify-end">
        <flux:modal.trigger name="project-modal">
            <flux:button variant="primary" color="violet" icon="plus-circle">Create Project</flux:button>
        </flux:modal.trigger>
    </div>

    <livewire:projects.form-modal />

    <div x-data="{ show: false, message: '', type: '' }" x-init="window.addEventListener('flash', event => {
        let data = event.detail[0];
        message = data.message;
        type = data.type;
        show = true;
        setTimeout(() => show = false, 4000);
    });" x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-[-20px] opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transform ease-in duration-200 transition" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 translate-y-[-20px]"
        class="fixed top-5 right-5 w-full max-w-sm rounded-xl shadow-lg text-white z-50 overflow-hidden"
        :class="{
            'bg-green-500': type === 'success',
            'bg-red-500': type === 'error',
            'bg-blue-500': type === 'info',
            'bg-yellow-500': type === 'warning'
        }"
        style="display: none;">
        <div class="flex items-center justify-between px-4 py-3">
            <!-- Icon + Message -->
            <div class="flex items-center space-x-3">
                <!-- Dynamic Icon -->
                <template x-if="type === 'success'">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </template>
                <template x-if="type === 'error'">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </template>
                <template x-if="type === 'info'">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 20h.01M12 4h.01" />
                    </svg>
                </template>
                <template x-if="type === 'warning'">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                </template>

                <!-- Flash Message -->
                <div x-text="message" class="font-medium text-sm"></div>
            </div>

            <!-- Close Button -->
            <button @click="show = false" class="ml-4 focus:outline-none">
                <svg class="w-5 h-5 text-white hover:text-gray-200" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Table for listing --}}
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse border border-gray-200 dark:border-gray-700">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800">
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">#</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Logo</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Name</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Description</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Deadline</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Status</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Created At</th>
                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <!-- Row Number -->
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                            {{ $loop->iteration }}
                        </td>

                        <!-- Logo -->
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                            @if ($project->project_logo)
                                <img src="{{ asset('storage/' . $project->project_logo) }}" alt="{{ $project->name }}"
                                    class="h-16 w-16 object-cover rounded">
                            @else
                                <div
                                    class="h-10 w-10 flex items-center justify-center bg-gray-200 dark:bg-gray-600 rounded-full text-gray-500">
                                    N/A
                                </div>
                            @endif
                        </td>

                        <!-- Name -->
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                            {{ $project->name }}
                        </td>

                        <!-- Description -->
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                            {{ Str::limit($project->description, 50) }}
                        </td>

                        <!-- Deadline -->
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                            {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('D M Y') : 'N/A' }}
                        </td>

                        <!-- Status -->
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                            @php
                                $statusValue = strtolower($project->status ?? '');
                                $statusColor = match ($statusValue) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'in-progress' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="px-1 py-1 rounded-full text-[10px] font-semibold {{ $statusColor }}">
                                {{ ucfirst(str_replace('-', '_', $project->status)) }}
                            </span>

                        </td>

                        <!-- Created At -->
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                            {{ $project->created_at->format('d-m-Y H:i') }}
                        </td>

                        <!-- Actions -->
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                            <div class="flex items-center gap-2">
                                <flux:modal.trigger name="project-modal">
                                    <flux:button wire:click="$dispatch('open-project-modal',{mode:'view',project:{{ $project }}})" size="sm" variant="primary" color="green" icon="eye">
                                        View
                                    </flux:button>
                                    <flux:button wire:click="$dispatch('open-project-modal',{mode:'edit',project:{{ $project }}})" size="sm" variant="primary" color="blue" icon="pencil">
                                        Edit
                                    </flux:button>
                                </flux:modal.trigger>
                                  <flux:modal.trigger name="delete-project">
                                <flux:button wire:click="$dispatch('delete-project',{id:{{ $project->id }}})" size="sm" variant="danger" color="red" icon="trash">
                                    Delete
                                </flux:button>
                                  </flux:modal.trigger>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center">
                            <flux:text class="flex items-center justify-center text-gray-800">
                                No projects found.
                            </flux:text>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
  {{-- Delete project modal --}}
  

<flux:modal name="delete-project" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete project?</flux:heading>

            <flux:text class="mt-2">
                <p>You're about to delete this project.</p>
                <p>This action cannot be reversed.</p>
            </flux:text>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button wire:click="deleteProject" type="submit" variant="danger">Delete project</flux:button>
        </div>
    </div>
</flux:modal>
</div>
