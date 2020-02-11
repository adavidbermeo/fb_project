<?php 
?>
<div class="calendar-section">
    <p>Fecha Inicial : <input type="date" class="start-date" id="datepicker" name="start-date" autofocus step="1" min="2000-12-1" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d');?>" required></p><br>    
    <p>Fecha Final   : <input type="date" class="end-date" id="datepicker" name="end-date" autofocus step="1" min="2000-12-1" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d');?>" required></p>
    <input type="hidden" id="data" value="<?php echo $_GET['selected'] ?>">    
    <input type="button" value="VER REPORTE" id="send-data">
</div>
<script src="js/filter_by_date.js"></script>

    