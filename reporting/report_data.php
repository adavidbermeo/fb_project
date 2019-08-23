<?php 
    if(isset($_GET['selected'])){
        
        $selected = $_GET['selected'];
        list($url, $click) = explode('?click=', $selected);
        // echo $click . "<br>";
        list($action_selected, $values) = explode('%', $click);
        // echo "<br><br><br>";
        // echo $action_selected . "<br>";
        // echo $values . "<br>";

        list($index1,$index2,$index3) = explode('&',$values);
        // echo "<br><br><br>";
        // echo $index1 . "<br>";
        // echo $index2 . "<br>";
        // echo $index3 . "<br>";
        $indexs = [$index1, $index2, $index3];
        foreach ($indexs as $index) {
            list($entrada[], $index_value[]) = explode('=',$index);
        }
        generateResponse($index_value, $action_selected ,$values);
    //    print_r($entrada);
    //    print_r($index_value);
    }
    function generateResponse($index_value, $action_selected , $values){
        switch ($action_selected) {
            case 'insert':
                switch ($index_value[2]) {
                    case 'ad':
                        echo "Se insertara la actual consulta de Anuncios. ¿Desea continuar?";
                        echo "<div>";
                        echo "<a href='index.php?click=insert%$values'>Si</a>";
                        echo "<a href='index.php'>No</a>";
                        echo "</div>";
                    break;
                    case 'campaign':
                        echo "Se insertara la actual consulta de Campañas. ¿Desea continuar?";
                        echo "<div>";
                        echo "<a href='index.php?click=insert%$values'>Si</a>";
                        echo "<a href='index.php'>No</a>";
                        echo "</div>";
                    break;
                    case 'page':
                        echo "
                        <form>
                            <input type='text'>
                        </form>
                        ";
                    break;
                          
                    default:
                        echo "There is no data";
                    break;
                }
                break;
            case 'generalselect':
                switch ($index_value[2]) {
                    case 'ad':
                       
                    break;
                    case 'campaign':
                        echo "
                            <form>
                                <input type='text'>
                            </form>
                        ";
                    break;
                    case 'page':
                        echo "
                        <form>
                            <input type='text'>
                        </form>
                        ";
                    break;
                          
                    default:
                        echo "jajaajja";
                    break;
                }
                break;
            case 'specificselect':
                switch ($index_value[2]) {
                    case 'ad':
                        echo "Se insertara la actual consulta de Anuncios. ¿Desea continuar?";
                        echo "<div>";
                        echo "<a href='index.php?click=insert%$values'>Si</a>";
                        echo "<a href='index.php'>No</a>";
                        echo "</div>";
                    break;
                    case 'campaign':
                        echo "
                            <form>
                                <input type='text'>
                            </form>
                        ";
                    break;
                    case 'page':
                        echo "
                        <form>
                            <input type='text'>
                        </form>
                        ";
                    break;
                          
                    default:
                        echo "jajaajja";
                    break;
                }
                break;
            case 'delete':
                switch ($index_value[2]) {
                    case 'ad':
                        echo "Se insertara la actual consulta de Anuncios. ¿Desea continuar?";
                        echo "<div>";
                        echo "<a href='index.php?click=insert%$values'>Si</a>";
                        echo "<a href='index.php'>No</a>";
                        echo "</div>";
                    break;
                    case 'campaign':
                        echo "
                            <form>
                                <input type='text'>
                            </form>
                        ";
                    break;
                    case 'page':
                        echo "
                        <form>
                            <input type='text'>
                        </form>
                        ";
                    break;
                          
                    default:
                        echo "jajaajja";
                    break;
                }
                break;    
            default:
                echo "An unexpected error has ocurred";
                break;
        }
           
    }
    ?>
</body>
</html>
