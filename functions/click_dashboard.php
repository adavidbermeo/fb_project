<div class="calendar-section delete">
    <p>Fecha Inicial : <input type="date" id="datepicker1" class="first-option" name="start-date" autofocus step="1"  value="<?php echo date('Y-m-d'); ?>" required></p><br>    
    <p>Fecha Final   : <input type="date" id="datepicker2" class="second-option" name="end-date" autofocus step="1"  value="<?php echo date('Y-m-d'); ?>" required></p>
    <input type="hidden" id="data" value="<?php echo $_GET['selected'] ?>">    
    <input type="button" value="VER REPORTE" id="create-dashboard">
</div>
<script src="dashboard/js/dashboard.js"></script>

