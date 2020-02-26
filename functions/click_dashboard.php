<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $( function() {
        $( "#datepicker" ).datepicker();
    } );
    $( function() {
        $( "#datepicker2" ).datepicker();
    } );
    </script>
</head>
<body>
    <div class="calendar-section delete">
    <p>Fecha Inicial : <input type="text" id="datepicker" class="first-option" name="start-date" autofocus step="1" min="2000-12-1" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d');?>" required></p><br>    
    <p>Fecha Final   : <input type="text" id="datepicker2" class="second-option" name="end-date" autofocus step="1" min="2000-12-1" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d');?>" required></p>
    <input type="hidden" id="data" value="<?php echo $_GET['selected'] ?>">    
    <input type="button" value="VER REPORTE" id="create-dashboard">
</div>
<script src="dashboard/js/dashboard.js"></script>
</body>
</html>
