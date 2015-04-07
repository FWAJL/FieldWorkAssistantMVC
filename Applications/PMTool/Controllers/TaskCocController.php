<?php

namespace Applications\PMTool\Controllers;

if (!defined('__EXECUTION_ACCESS_RESTRICTION__'))
  exit('No direct script access allowed');

class TaskCocController extends \Library\BaseController {
  public function executeManageCoc(\Library\HttpRequest $rq) {
	\Applications\PMTool\Helpers\TaskHelper::SetActiveTab($this->user(), \Applications\PMTool\Resources\Enums\TaskTabKeys::CocTab);
    $sessionProject = \Applications\PMTool\Helpers\ProjectHelper::GetCurrentSessionProject($this->user());
	
	$sessionTask = \Applications\PMTool\Helpers\TaskHelper::GetCurrentSessionTask($this->user());
   	
	$this->page->addVar(\Applications\PMTool\Resources\Enums\ViewVariablesKeys::currentProject, $sessionProject[\Library\Enums\SessionKeys::ProjectObject]);
    $this->page->addVar(\Applications\PMTool\Resources\Enums\ViewVariablesKeys::currentTask, $sessionTask[\Library\Enums\SessionKeys::TaskObj]);
	
	$labServices = \Applications\PMTool\Helpers\TaskHelper::getLabServicesForTask($this, $sessionTask, "Laboratory");
	$this->page->addVar(\Applications\PMTool\Resources\Enums\ViewVariablesKeys::labServices, $labServices);
	
	$this->page->addVar(\Applications\PMTool\Resources\Enums\ViewVariablesKeys::currentPm, \Applications\PMTool\Helpers\PmHelper::GetCurrentSessionPm($this->user()));
	
	if ($rq->getData("mode") === "edit") {
      $this->page->addVar("task_editing_header", $this->resxData["task_legend_edit"]);
    } else {
      $this->page->addVar("task_editing_header", $this->resxData["task_legend_add"]);
    }
	$this->page->addVar(
            \Applications\PMTool\Resources\Enums\ViewVariablesKeys::tabStatus, \Applications\PMTool\Helpers\TaskHelper::GetTabsStatus($this->app()->user()));
    $this->page->addVar(
            \Applications\PMTool\Resources\Enums\ViewVariablesKeys::form_modules, $this->app()->router()->selectedRoute()->phpModules());
			
  }

  public function executeAddCoc(\Library\HttpRequest $rq) {
  	// Init result
    $result = $this->InitResponseWS();
    
    //Init PDO
    $task_coc_info = \Applications\PMTool\Helpers\CommonHelper::PrepareUserObject($this->dataPost(), new \Applications\PMTool\Models\Dao\Task_coc_info());
	

    $manager = $this->managers->getManagerOf($this->module());
    $result_save = $manager->add($task_coc_info);
    $task_coc_info->setTask_coc_id($result_save);
    $result["data"] = $task_coc_info;

    $this->SendResponseWS(
            $result, array(
        "resx_file" => \Applications\PMTool\Resources\Enums\ResxFileNameKeys::Task,
        "resx_key" => $this->action(),
        "step" => $result_save > 0 ? "success" : "error"
    ));
  }
  
  public function executeEditCoc(\Library\HttpRequest $rq) {
  	// Init result
    $result = $this->InitResponseWS();
    
    //Init PDO
    $task_coc_info = \Applications\PMTool\Helpers\CommonHelper::PrepareUserObject($this->dataPost(), new \Applications\PMTool\Models\Dao\Task_coc_info());
	
    $result["data"] = $task_coc_info;

    $manager = $this->managers->getManagerOf($this->module());
    $result_save = $manager->edit($task_coc_info, 'task_id');

    $this->SendResponseWS(
            $result, array(
        "resx_file" => \Applications\PMTool\Resources\Enums\ResxFileNameKeys::Task,
        "resx_key" => $this->action(),
        "step" => $result_save ? "success" : "error"
    ));
  }
  
  public function executeGetTaskCoc(\Library\HttpRequest $rq) {
  	// Init result
    $result = $this->InitResponseWS();
	$task_id = intval($this->dataPost["task_id"]);
	
	//Init PDO
    $task_coc_info = \Applications\PMTool\Helpers\CommonHelper::PrepareUserObject($this->dataPost(), new \Applications\PMTool\Models\Dao\Task_coc_info());
	$manager = $this->managers->getManagerOf($this->module());
    $result_coc = $manager->selectMany($task_coc_info, "task_id");
		
	$task_coc_info = (count($result_coc) > 0) ? $result_coc[0] : NULL;
//    $services = 
//            \Applications\PMTool\Helpers\ServiceHelper::GetServicesFromTaskServices(
//                    $this->user(), 
//                    \Applications\PMTool\Helpers\TaskHelper::GetCurrentSessionTask($this->user())
//                    );
//    $service = \Applications\PMTool\Helpers\CommonHelper::FindObjectByIntValue($task_coc_info->service_id(), "service_id", $services);
//    
//    $task_coc_info->setService_object($service);
    $result["task_coc"] = $task_coc_info;
    
    $this->SendResponseWS(
            $result, array(
        "resx_file" => \Applications\PMTool\Resources\Enums\ResxFileNameKeys::Task,
        "resx_key" => $this->action(),
        "step" => ($result_coc !== NULL) ? "success" : "error"
    ));
  }
}