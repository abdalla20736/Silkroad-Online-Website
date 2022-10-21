<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<?php
    echo"<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>E-Pin</span>";
    if(isset($_SESSION['loggedin'])){
        echo'    <div class="borders-web-mall epin-div"> <form method="post" action="?page=Epin">
        <span style="font-size:20px;">E-pin :&nbsp;&nbsp;&nbsp;</span>
        <input type="text" placeholder="Enter E-pin code" name="code" id="ecode" autocomplete="off">
        <button class="btn-site epin-btn" name="charge">Charge now !</button>
        </form></div>';

    }else{
        echo'<script>window.location.href="index.php"</script>';
    }
    if(isset($_POST['charge'])){
        $nowcode= md5($sec->secure($_POST['code']));
        $epin = SQLSRV_QUERY($dbcn,"select * from epin where pin = '".$nowcode."'",array(),array('scrollable' => SQLSRV_CURSOR_KEYSET));
        $guser = SQLSRV_QUERY($dbcn,"select ID from SK_USER where Username = '".$_SESSION['User']."'");
        $guseres = SQLSRV_FETCH_ARRAY($guser);
        $epinres = SQLSRV_FETCH_ARRAY($epin);
        if(SQLSRV_NUM_ROWS($epin) > 0){
            $silk = $epinres['silk'];
            $id = $guseres['ID'];
            $us = $_SESSION['User'];
            $try=  SQLSRV_QUERY($dbcn,"UPDATE SK_SILK SET silk = silk + $silk where ID in (select ID from SK_USER where Username = '$us') DELETE FROM epin Where pin = '".$nowcode."' INSERT INTO epin_log(silk,UserID,used)values('$silk','$id',GETDATE())");
            
            if($try == true){
                SwalfireApanel4("<span style='color:#fff;'>You used a epin code with value $silk silk</span>", "#111B2F", "black","?page=myaccount");
            }
            

        }else{
            ?> <script>changepsjs("ecode","The code incorrect")</script><?php
            
        }

    }
    

    
?>