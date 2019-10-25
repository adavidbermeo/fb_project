<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
    <!--  -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Facebook App</title>
    <link rel="stylesheet" href="css/facebook-styles.css">
    <script src="js/jquery/jquery.js" text="text/javascript"></script>
    <script src="js/submit.js" text="text/javascript"></script>

    <!-- <script type="text/javascript" src="js/jquery.min.js"></script> -->
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <script type="text/javascript" src="js/graphics.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/834edd277c.js"></script>
    <!-- Text JavaScript -->
    <script src="js/functions.js" type="text/javascript"></script>
        
</head>
<body class="index-background">
     <?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/functions/accounts_data.php');
    use functions\AccountsPageData;
    $AccountsPageData = new AccountsPageData();
    
    $iterador = $AccountsPageData->getCountPageData();

    ?>
    <a href="index.php"><div class="app"></div></a>
    <div class="custom-container"> 
        
        <form method="POST" class="centrado-porcentual">
            <select id="options">    
        
            <option value="" disabled selected>Select your business account</option>

            <?php 
            for ($i=0; $i<= $iterador; $i++) {        
                echo '<option required value= '.$AccountsPageData->page_data['page_id'][$i].'%'. $AccountsPageData->page_data['ad_account_id'][$i].'>'.$AccountsPageData->page_data['page_name'][$i] .'</option>';
            }
        ?>
        </select>
            <!-- <input list="options" type="text" placeholder=" Search Account" name="search" id="search" required> -->
            <button type="submit" id="paxzu">
                <i class="fas fa-search fa-2x" style="color: #fff;"></i> 
            </button>
        </form>
        <!-- <a onclick="openDialog();" class="open">Mostrar Popup</a> -->
       <!-- <div id="popup" class="popup" style="display:none;">
            <a onclick="closeDialog('popup');" class="close"><i class="fas fa-window-close fa-4x"></i></a>
        </div> -->
        <div class="business-manager-info">
             
            <h3 class="welcome">Welcome to Facebook Api Project</h3>
            <img src="img/paxzu.png" alt="Index Background" id="index-back">
            <?php $AccountsPageData->callReporting(); ?>

            <!-- <div id="chart-container"><canvas id="mycanvas"></canvas></div> -->
        </div>
        <div class="con-loader">

	        <div class="loader">
                
            </div>
            <div class="texto-loading">
                Loading data..... Please wait
            </div>
        </div>
        
    </div>
    <footer>Copyright Paxzu Colombia &copy; - 2019</footer>
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>