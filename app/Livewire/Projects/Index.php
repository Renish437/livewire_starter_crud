<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Services\ProjectService;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination,WithoutUrlPagination;

     public $projectId = null;
    #[On('delete-project')]
    public function deleteProjectConfirm($id){
        $this->projectId = $id;
         
    
       
    }
    #[On('refresh-projects')]
    public function resetFilters(ProjectService $projectService)
    {
    $this->resetPage();
    $this->dispatch('$refresh');
        // $this->resetPage();
    }
    public function deleteProject(ProjectService $projectService){
        if($this->projectId){
            $projectService->deleteProject($this->projectId);
            $this->dispatch('flash',[
                'type' => 'success',
                'message' => 'Project deleted successfully!',
        
            ]);
            $this->projectId = null;
            Flux::modals('delete-project')->close();
            $this->dispatch('$refresh');

        }
    }
    public function render(ProjectService $projectService)
    {
        
        
        $projects = $projectService->getAllProjects()->orderBy('id','desc')->paginate(10);
        
        return view('livewire.projects.index',[
            'projects' => $projects
        ]);
    }
}
