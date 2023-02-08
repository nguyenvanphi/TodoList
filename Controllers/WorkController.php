<?php

namespace Controllers;

require_once("./Models/Work.php");
require_once("./Models/WorkEntity.php");

class WorkController
{
    public $model;
    public $messengerSuccess;
	public $messengerError;

	public function __construct()  
	{  
	    $this->model = new \Models\Work;
        $this->messengerSuccess = "";
	    $this->messengerError = "";
	}

    /**
     * Get List Work
     */
    public function index()
    {
        return $this->model->getListWork();
    }

    /**
     * Add New Work
     */
    public function add()
    {
        $startDate = date('Y-m-d H:i:s', strtotime($_REQUEST['startDate']));
        $endDate = date('Y-m-d H:i:s', strtotime($_REQUEST['endDate']));

    	$work = new \Entity\WorkEntity(null, $_REQUEST['workName'], $startDate, $endDate, $_REQUEST['status']);

    	if($this->model->add($work)){
    		$this->messengerSuccess = "Added data successfully!";
    	}
    	else{
			$this->messengerError = "Failed to add data";
    	}
    }

    /**
     * Edit Work
     */
    public function edit()
    {
        $startDate = date('Y-m-d H:i:s', strtotime($_REQUEST['startDate']));
        $endDate = date('Y-m-d H:i:s', strtotime($_REQUEST['endDate']));

    	$work = new \Entity\WorkEntity($_REQUEST['id'], $_REQUEST['workName'], $startDate, $endDate, $_REQUEST['status']);

    	if($this->model->edit($work)){
    		$this->messengerSuccess = "Edited data successfully!";
    	}
    	else{
			$this->messengerError = "Failed to edit data";
    	}
    }

    /**
     * Delete Work
     */
    public function delete()
    {
    	if($this->model->delete($_REQUEST['delete'])){
    		$this->messengerSuccess = "Deleted data successfully!";
    	}
    	else{
			$this->messengerError = "Failed to delete data";
    	}
    }
}

?>