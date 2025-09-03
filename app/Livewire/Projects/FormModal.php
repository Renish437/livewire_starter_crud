<?php

namespace App\Livewire\Projects;

use App\Services\ProjectService;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class FormModal extends Component
{
    use WithFileUploads;
    #[Rule('required|string|max:100')]
    public $name = null;

    #[Rule('required|string|max:255')]
    public $description =null;

    #[Rule('required|date')]
    public $deadline = null;

    #[Rule('required|in:pending,in-progress,completed,cancelled')]
    public $status = "pending";

    #[Rule('nullable|max:5120')] // max 2MB
    public $project_logo=null;

    public $projectId = null;
    public $isView = false;
    public $existingLogo = null;
    public $mode = 'create'; // create, view, edit


    public function saveProject(ProjectService $projectService){
     $validated = $this->validate();

     if($this->projectId){
        $projectService->updateProject($validated,$this->projectId);

     }else{
       $projectService->saveProject($validated);
     }
     

     $this->reset();
     
   $message = $this->projectId ? 'Project updated successfully!' : 'Project created successfully!';

$this->dispatch('flash', [
    'type' => 'success',
    'message' => $message,
]);

    $this->dispatch('refresh-projects');
 
      Flux::modals('project-modal')->close();

    }
    #[On('open-project-modal')]
    public function projectDetail($mode,$project=null){
         $this->isView = $mode==='view';
       if($mode==='create'){
        $this->isView = false;
        $this->reset();
       }else{
        $this->projectId = $project['id'];
        $this->name = $project['name'];
        $this->description = $project['description'];
        $this->deadline = $project['deadline'];
        $this->status = $project['status'];
        $this->existingLogo = $project['project_logo'];

       }
    }


    // public function deleteProject(ProjectService $projectService){
    //     if($this->projectId){
    //         $projectService->deleteProject($this->projectId);
    //      }
         
    //      $this->reset();
         
    //      $this->dispatch('flash',[
    //         'type' => 'success',
    //         'message' => 'Project deleted successfully!',
    
    //     ]);
     
    //       Flux::modals('project-modal')->close();
    // }
    public function render()
    {
        
        return view('livewire.projects.form-modal');
    }
}
