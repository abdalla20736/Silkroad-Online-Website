<?php
        if(isset($_SESSION['LAST_ACTIVITY'])){
                if(time() - $_SESSION['LAST_ACTIVITY'] < 14400){

                
                if(!empty($_GET['u']));
                $user = $_GET['u'];
                if(!empty($_GET['cod']));
                $cod = $_GET['cod'];
                $active = SQLSRV_QUERY($dbcn,"UPDATE $dbname3.dbo.SK_USER SET Active = 1 Where username = '$user' and Code = '$cod' ");
                            SQLSRV_QUERY($dbcn,"UPDATE $dbname3.dbo.SK_USER SET Code = 0 Where username = '$user' and Code = '$cod'");

                    if($active){
                        unset($_SESSION['LASTACTIVITY']);
                        moveto("?page=news&success=3");
                    }else{
                        unset($_SESSION['LASTACTIVITY']);
                        moveto("?page=news&failed=1");
                    }
                }else{
                    SQLSRV_QUERY($dbcn,"DELETE FROM $dbname3.dbo.SK_USER Where username = '$user' and Code = '$cod' ");
                    moveto("?page=news&failed=4");
                }
        }else{
            moveto("?page=news");
        }

?>