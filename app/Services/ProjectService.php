<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ProjectService
{
    /**
     * Create a new class instance.
     */
    protected $projectRepository;
    public function __construct(ProjectRepository $projectRepository)
    {
        //
        $this->projectRepository = $projectRepository;
    }
    public function saveProject(array $projectRequest){
        // Logic to save project data
        // For example, you might use a Project model to create a new project record in the database.
        // dd($data);
        if(!empty($projectRequest['project_logo'])){
           $projectLogoPath = $projectRequest['project_logo']->store('projects','public');
            $projectRequest['project_logo'] = $projectLogoPath;
        }
        $projectRequest['slug'] = Str::slug($projectRequest['name']);
        return $this->projectRepository->saveProject($projectRequest);
    }
    // getAllProjects
    public function getAllProjects(){
        return $this->projectRepository->getProjectQuery();
    }

   public function updateProject(array $data, int $projectId)
{
    $project = $this->projectRepository->getProjectQuery()->findOrFail($projectId);

    // Handle project logo upload
    if (!empty($data['project_logo']) && $data['project_logo']->isValid()) {
        // Store new logo
        $projectLogoPath = $data['project_logo']->store('projects', 'public');
        $data['project_logo'] = $projectLogoPath;

        // Delete old logo if it exists
        if ($project->project_logo && Storage::disk('public')->exists($project->project_logo)) {
            Storage::disk('public')->delete($project->project_logo);
        }
    } else {
        // If no new logo uploaded, keep existing one
        unset($data['project_logo']);
    }

    // Always update slug
    $data['slug'] = Str::slug($data['name']);
    $data['updated_at'] = now();
    $data['name'] = $data['name'] ?? $project->name;
    $data['description'] = $data['description'] ?? $project->description;
    $data['status'] = $data['status'] ?? $project->status;
    $data['deadline'] = $data['deadline'] ?? $project->deadline;
    

    $project->update($data);

    return $project;
}


    public function deleteProject($projectId){
        $project = $this->projectRepository->getProjectQuery()->findOrFail($projectId);
       
        return $project->delete();
    }
}
