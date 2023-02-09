<?php
    require_once("./Controllers/WorkController.php");
    require_once("./Configs/Work.php");
    $workController = new Controllers\WorkController;
    $works = [];
    // Get list work
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $works = $workController->index();
    }
    // Add new work
    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_REQUEST['type'] == "ADD") {
        $workController->add();
        $works = $workController->index();
    }
    // Edit work
	if($_SERVER['REQUEST_METHOD'] == "POST" && $_REQUEST['type'] == "EDIT"){
		$workController->edit();
		$works = $workController->index();
	}
    // Delete work by id
	if($_SERVER['REQUEST_METHOD'] == "POST" && $_REQUEST['type'] == "DELETE"){
		$workController->delete();
		$works = $workController->index();
	}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Todo List</title>
</head>

<body>

    <!-- Header -->
    <header class="mt-4 mb-4">
        <div class="container">
            <h1 class="h1 text-center">Todo List</h1>
            <div class="row mt-4">
                <div class="col-6">
                    <a class="btn btn-block btn-info" href="./calendar.php">Calendar Viewer</a>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#addModal">
                        Add New Work
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- List Work -->
    <section>
        <div class="container">
            <div class="col-md-12">
				<?php if($workController->messengerSuccess){ ?>
						<div class="alert alert-success" role="alert">
							<?= $workController->messengerSuccess ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
				<?php } ?>
				<?php if($workController->messengerError){ ?>
						<div class="alert alert-danger" role="alert">
							<?= $workController->messengerError ?>
						</div>
				<?php } ?>
			</div>
            <div class="row">
                <div class="col-12">
                    <div style="height: 400px;overflow: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Work Name</th>
                                    <th>Starting Date</th>
                                    <th>Ending Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($works as $index => $work) : ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= $work->workName ?></td>
                                        <td><?= date('Y-m-d H:i:s', strtotime($work->startDate)); ?></td>
                                        <td><?= date('Y-m-d H:i:s', strtotime($work->endDate)); ?></td>
                                        <td><?= \Configs\Work::STATUS_WORK[$work->status]; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $work->id ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $work->id ?>">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Add New Work-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="POST" action="index.php" id="formAdd">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Work</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="display: none;">
                            <input name="type" value="ADD">
                        </div>
                        <div class="form-group row">
                            <label for="workName" class="col-3 col-form-label">Work Name:</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="workName" name="workName" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startDate" class="col-3 col-form-label">Start Date:</label>
                            <div class="col-9">
                                <input type="datetime-local" class="form-control" id="startDate" name="startDate" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="endDate" class="col-3 col-form-label">End Date:</label>
                            <div class="col-9">
                                <input type="datetime-local" class="form-control" id="endDate" name="endDate" required>
                            </div>
                        </div>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                                <div class="col-sm-10">
                                    <?php
                                        $listStatus = Configs\Work::STATUS_WORK;
                                        foreach ($listStatus as $key => $value) :
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="<?= $key; ?>" checked>
                                            <label class="form-check-label">
                                                <?= $value ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit-form">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Edit Work-->
    <?php foreach ($works as $index => $work) : ?>
        <div class="modal fade" id="editModal<?= $work->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form method="POST" action="index.php" id="formEdit">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Work Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="display: none;">
                                <input name="type" value="EDIT">
                                <input name="id" value="<?= $work->id ?>" id="id-edit">
                            </div>
                            <div class="form-group row">
                                <label for="workName" class="col-3 col-form-label">Work Name:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="workName" name="workName" value="<?= $work->workName ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="startDate" class="col-3 col-form-label">Start Date:</label>
                                <div class="col-9">
                                    <input type="datetime-local" class="form-control" id="startDateEdit<?= $work->id ?>" name="startDate" value="<?= date('Y-m-d\TH:i:s', strtotime($work->startDate)) ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="endDate" class="col-3 col-form-label">End Date:</label>
                                <div class="col-9">
                                    <input type="datetime-local" class="form-control" id="endDateEdit<?= $work->id ?>" name="endDate" value="<?= date('Y-m-d\TH:i:s', strtotime($work->endDate)) ?>" required>
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                                    <div class="col-sm-10">
                                        <?php
                                            $listStatus = Configs\Work::STATUS_WORK;
                                            foreach ($listStatus as $key => $value) :
                                        ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" value="<?= $key ?>" <?= ($key ==  $work->status) ? 'checked' : '' ?> >
                                                <label class="form-check-label">
                                                    <?= $value ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-submit-form">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php endforeach; ?>

    <!-- Modal Delete Work-->
    <?php foreach ($works as $index => $work) : ?>
        <div class="modal fade" id="deleteModal<?= $work->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form method="POST" action="index.php" id="formDelete">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Work</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure delete this work?</p>
                            <div style="display: none;">
                                <input name="type" value="DELETE">
                                <input name="id" value="<?= $work->id ?>" id="id-delete">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-submit-form">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php endforeach; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
        $("#startDate, #endDate").change(function(){
            let start = $("#startDate").val();
            let end = $("#endDate").val();
            compareDate(start, end);
        });

        <?php foreach ($works as $index => $work) : ?>
            $("#startDateEdit<?= $work->id ?>, #endDateEdit<?= $work->id ?>").change(function(){
                let start = $("#startDateEdit<?= $work->id ?>").val();
                let end = $("#endDateEdit<?= $work->id ?>").val();
                compareDate(start, end);
            });
        <?php endforeach; ?>

        function compareDate(start, end){
            if(new Date(start) > new Date(end))
            {
                alert("Start date is greater than the end date");
                $(".btn-submit-form").prop('disabled', true);
            }
            else{
                $(".btn-submit-form").prop('disabled', false);
            }
        }
    </script>
</body>

</html>