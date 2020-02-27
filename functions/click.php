<script src="js/filter_by_date.js"></script>
<div class="calendar-section">
    <p>Fecha Inicial : <input type="text" class="start-date" id="datepicker3" autofocus step="1"  value="<?php echo date("Y-m-d");?>" required></p><br>    
    <p>Fecha Final   : <input type="text" class="end-date" id="datepicker4" autofocus step="1"  value="<?php echo date("Y-m-d"); ?>" required></p>
    <input type="hidden" id="data" value="<?php echo $_GET["selected"] ?>">    
    <input type="button" value="VER REPORTE" id="send-data">
</div>