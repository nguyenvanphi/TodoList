<?php
    require_once("./Controllers/WorkController.php");
    $workController = new Controllers\WorkController;
    $works = $workController->index();
    $events = [];
    if (!empty($works)) {
        foreach ($works as $key => $work) {
            $tmp = [
                'id' => $work->id,
                'title' => $work->workName,
                'start' => $work->startDate,
                'end' => $work->endDate,
                'status' => $work->status
            ];
            array_push($events, $tmp);
        }
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
    <link rel="stylesheet" href="./public/assets/css/fullcalendar.min.css" />
    <link rel="stylesheet" href="./public/assets/css/fullcalendar.print.min.css" media="print" />

    <title>Todo List</title>
</head>

<body>
    <!-- Header -->
    <header class="mt-4 mb-4">
        <div class="container">
            <h1 class="h1 text-center">Todo List</h1>
            <div class="row mt-4">
                <div class="col-6">
                    <a class="btn btn-block btn-info" href="javascript::void()">Calendar Viewer</a>
                </div>
                <div class="col-6">
                    <a class="btn btn-block btn-success" href="./index.php">Create New Work</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Calendar -->
    <section>
        <div class="container">
            <div id='calendar'></div>
        </div>
    </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
    <script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>
    <script src="http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
    <script src='http://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
    <script>
        $(document).ready(function() {
            var events = <?= json_encode($events); ?>;
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                defaultDate: "<?=  date('Y-m-d') ?>",
                navLinks: true,
                editable: true,
                eventLimit: true,
                events: events
            });
        });
    </script>
</body>

</html>