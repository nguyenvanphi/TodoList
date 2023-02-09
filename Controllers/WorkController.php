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
        if(self::validation()){
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
        else{
            $this->messengerError = "Some fields are required";
        }
    }

    /**
     * Edit Work
     */
    public function edit()
    {
        if(self::validation() && self::validationIdWork()){
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
        else{
            $this->messengerError = "Some fields are required";
        }
    }

    /**
     * Delete Work
     */
    public function delete()
    {
        if(self::validationIdWork()){
            if($this->model->delete($_REQUEST['id'])){
                $this->messengerSuccess = "Deleted data successfully!";
            }
            else{
                $this->messengerError = "Failed to delete data";
            }
        }
        else{
            $this->messengerError = "The id field is required";
        }
    }

    /**
     * Validation Prams
     */
    public function validation()
    {
        if(!empty($_REQUEST['workName']) && !empty($_REQUEST['startDate']) && !empty($_REQUEST['endDate']) && !empty($_REQUEST['status']))
            return true;
        return false;
    }

    /**
     * validation Id Workd
     */
    public function validationIdWork()
    {
        if(!empty($_REQUEST['id']))
            return true;
        return false;
    }
}

?>