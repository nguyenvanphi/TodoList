<?php 

namespace Entity;

/**
 * Entity Work
 */
class WorkEntity
{
	public $id;
	public $workName;
	public $startDate;
	public $endDate;
	public $status;

	public function __construct($id, $workName, $startDate, $endDate, $status)
	{
		$this->id = $id;
		$this->workName = $workName;
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->status = $status;
	}
}

?>