<flux:modal name="project-modal" class="md:w-[500px]">
    <form wire:submit="saveProject" class="space-y-6">
        <div>
            <flux:heading size="lg">{{$isView ? 'Project Detials' :($projectId ? 'Update Project':'Create Project')}}</flux:heading>
            <flux:text class="mt-2">Add a new project using form below.</flux:text>
        </div>

        <div class="form-group">
            <flux:input :disabled="$isView" wire:model="name" label="Project Name" placeholder="Enter project name" />
        </div>
        <div class="form-group">
            <flux:textarea :disabled="$isView" wire:model="description" label="Description" placeholder="Enter project description" rows="3" />
        </div>
        <div class="form-group">
            <flux:input :disabled="$isView" wire:model="deadline" label="Deadline" type="date" />

        </div>
        <div class="form-group">
            <flux:select  wire:model="status" placeholder="Choose status" label="Status">
                <option value="pending">Pending</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </flux:select>
        </div>
        <div class="form-group">
           @if (!$isView) 
             <flux:input wire:model="project_logo" type="file" class="cursor-pointer"  accept="image/*"
                label="Logo" />
               
           @endif
           {{-- Preview  --}}
           @if ($project_logo && !$errors->has('project_logo'))
                <img src="{{ $project_logo->temporaryUrl() }}" alt="Project Logo" class="h-20 w-20 object-cover rounded">
           @elseif ($projectId && $existingLogo)
                <img src="{{ asset('storage/' . $existingLogo) }}" alt="Project Logo" class="h-20 w-20 object-cover rounded">  

               
           @endif
        </div>


        <div class="flex gap-2 justify-end">
             <flux:modal.close>
                <flux:button variant="ghost" class="cursor-pointer ms-2">Cancel</flux:button>
            </flux:modal.close>
            {{-- <flux:spacer /> --}}
            @if (!$isView)
                <flux:button type="submit" variant="primary" color="violet" class="cursor-pointer ms-2">{{ $projectId ? 'Update' : 'Save' }}
            </flux:button>
            @endif
             
           
        </div>

    </form>
</flux:modal>
