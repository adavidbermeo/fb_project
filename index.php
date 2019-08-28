<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Facebook App</title>
    <link rel="stylesheet" href="css/facebook-styles.css">
    <script src="js/jquery/jquery.js" text="text/javascript"></script>
    <script src="js/submit.js" text="text/javascript"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/834edd277c.js"></script>

    <!-- Text JavaScript -->
    <script type="text/javascript">
        function openDialog() {
                $('#overlay').show(3000);
                $('#popup').css('display','block');
                $('#popup').animate({'left':'30%'},300);
        }
        function closeDialog(id) {
            $('#'+ id). css('position','absolute');
            $('#'+ id).animate({'left':'-100%'}, 500, function() {
                $('#'+ id). css('position','fixed');
                $('#'+ id). css('left','100%');
                $('#overlay').fadeOut('fast');
            });
        }
    </script>
</head>
<body class="index-background">
     <?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/fb_project/functions/accounts_data.php');
    use functions\AccountsPageData;
    $AccountsPageData = new AccountsPageData();
    
    $iterador = $AccountsPageData->getCountPageData();

?>
    <a href="index.php"><div class="app"><!--  --></div></a>
        
    
    <!-- <video src="videos/video-background.mp4" autoplay loop muted id="index"></video> -->
    <div class="custom-container">
       
        <datalist id="options">    
        <?php 
            for ($i=0; $i<= $iterador; $i++) { 
                echo '<option id="option" value="' .$AccountsPageData->page_data['page_name'][$i] .' -  '.  $i .'"' .
                ' label="'.$AccountsPageData->page_data['page_id'][$i] .'" name = "'. $AccountsPageData->page_data['page_id'][$i] .'">' .'</option>';
            }
        ?>
        </datalist>
        <!-- <marquee scrolldelay="1" behavior="scroll"><h1 class="backg">Statistics Panel FB</h1></marquee> -->
        <form method="POST" class="centrado-porcentual">
            <input list="options" type="text" placeholder=" Search Account" name="search" id="search" required >
            <button type="submit" id="paxzu">
                <i class="fas fa-search fa-2x" style="color: #fff;"></i> 
            </button>
        </form>
        <!-- <a onclick="openDialog();" class="open">Mostrar Popup</a> -->
        <!-- <div class="account-picture">

        </div> -->
        <div class="business-manager-info">
             
            <h3 class="welcome">Welcome to Facebook Api Project</h3>
            <img src="img/paxzu.png" alt="Index Background" id="index-back">
            <?php $AccountsPageData->callReporting(); ?> 
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