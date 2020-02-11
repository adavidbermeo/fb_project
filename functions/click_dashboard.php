<?php 
?>
<div class="calendar-section">
    <p>Fecha Inicial : <input type="date" class="start-date" id="first-option" name="start-date" autofocus step="1" min="2000-12-1" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d');?>" required></p><br>    
    <p>Fecha Final   : <input type="date" class="end-date" id="second-option" name="end-date" autofocus step="1" min="2000-12-1" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d');?>" required></p>
    <input type="hidden" id="data" value="<?php echo $_GET['selected'] ?>">    
    <input type="button" value="VER REPORTE" id="create-dashboard">
</div>
<script src="dashboard/js/dashboard.js"></script>
