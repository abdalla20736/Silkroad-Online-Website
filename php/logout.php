<?php 
    
    if(isset($_POST['logout']) || isset($_SESSION['TIMEOUTS']))
    {
        $us = $_SESSION['User'];
        sqlsrv_query($dbcn,"UPDATE $dbname3.dbo.SK_USER SET [status] = 0 Where Username = '$us'");
        unset($_SESSION['loggedin']);
        unset($_SESSION['User']);
        unset($_SESSION['Char']);
        unset($_SESSION['TIMEOUTS']);
        session_destroy();
        echo'<script>window.location.href="index.php";</script>';
        
    }
   
?>