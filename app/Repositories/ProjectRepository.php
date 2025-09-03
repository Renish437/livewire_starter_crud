<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function saveProject(array $data){
        // Logic to save project data
        // For example, you might use a Project model to create a new project record in the database.
        
       return Project::create($data);
    }

    public function getProjectQuery(){
        return Project::query();
    }
}
