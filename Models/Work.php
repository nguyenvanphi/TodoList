<?php

namespace Models;

require_once("./Models/WorkEntity.php");

class Work
{
	public function __construct()
	{

	}

    /**
     * Connect DB
     */
    private function connectDB()
    {
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "todolist";

		$conn = mysqli_connect($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			echo ("Connection failed: " . $conn->connect_error);
		}
		return $conn;
	}

    /**
     * Get List Work
     */
    public function getListWork()
    {
        $conn = $this->connectDB();
		$sql = "SELECT * FROM works";
		$result = $conn->query($sql);
		$dataWorks = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$work = new \Entity\WorkEntity($row['id'], $row['work_name'], $row['starting_date'], $row['ending_date'], $row['status']);
				array_push($dataWorks, $work);
			}
		} 
		$conn->close();
		return $dataWorks;
    }

    /**
     * Add New Work
     */
    public function add($work)
	{
		$conn = $this->connectDB();
		$stmt = $conn->prepare("INSERT INTO works (work_name, starting_date, ending_date, status) VALUES (?, ?, ?, ?)");
		$stmt->bind_param('sssi', $work->workName, $work->startDate, $work->endDate, $work->status);
		$check = $stmt->execute();
		$stmt->close();
		$conn->close();
		return $check;
	}

    /**
     * Edit Work
     */
    public function edit($work)
	{
		$conn = $this->connectDB();
		$sql = "UPDATE works SET work_name = '".$work->workName."', starting_date = '".$work->startDate."', ending_date = '".$work->endDate."', status = '".$work->status."' WHERE id = ".$work->id;
    	$check = $conn->query($sql);
		$conn->close();
		return $check;
	}

    /**
     * Delete Work By Id
     */
    public function delete($id){
		$conn = $this->connectDB();
		$sql = "DELETE FROM works WHERE id = ".$id;
		$check = $conn->query($sql);
		$conn->close();
		return $check;
	}
}