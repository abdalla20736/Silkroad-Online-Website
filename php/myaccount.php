
<?php
echo"<span style=' margin-left:5px; color:#fff !important; font-size:40px; '>MY ACCOUNT</span>";
    if(isset($_SESSION['loggedin'])){
        
            echo'<div class="myaccount-div">
            <a class="btn-site myaccount-btn" href="?page=changeps">Change password</a>
            <a class="btn-site myaccount-btn" href="?page=Epin">Charge silk - E-pin</a>
            </div>';
            
    }else{
        echo "<div class='exist-msg'><h1>".$sitename."</h1>
        <p>You must logout in order to register an account.</p></div>";
    }

?>