<script src="js/filter_by_date.js"></script>
<script>
    $(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
    });
</script>
<div class="calendar-section">
    <input class="start-date" type="text" name="daterange" value="12/01/2019 - 12/31/2019" />
    <input type="hidden" id="data" value="<?php echo $_GET["selected"] ?>">    
    <input type="button" value="VER REPORTE" id="send-data">
</div>