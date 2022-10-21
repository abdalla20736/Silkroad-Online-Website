
<?php 
#------website settings-----#

    include("./php/_Setting.php");
    include("./php/_sec.php");
    error_reporting(E_ALL | E_STRICT);
#------functions-php---------#
    include("./php/functions.php");
#-----Error-reporting-------#
    error_reporting(-1);
#-------Security class-------#
    $sec = new Security();
#-------Start SESSION ---------#
    session_start();
#-----SQL_SERVER-CHECK/Settings------#
    if(!file_exists("./php/_Setting.php")) 
    die("Con not found");
    if(!file_exists("./pager.php"))
    die("header not found");
    if(empty($serverName))
    die("Name of server not found");
    if(empty($US))
    die("UserName of server not found");
    if(empty($PS))
    die("Password of server not found");
    if(empty($dbname1))
    die("Name of FDB not found");
    if(empty($dbname2))
    die("Name of SDB not found");
    $_SESSION['title'] = "Home";
    global $title;
#--------Check-user-sesssion---------#
    
    if(isset($_SESSION['loggedin']) && (time() - $_SESSION['TIMEOUTS'] > 1800)){
        echo '<meta http-equiv="refresh" content="0; url=?page=logout">';
    }
    if(isset($_SESSION['TIMEOUTS']))
        $_SESSION['TIMEOUTS'] = time();
    #---------------------------------------------------Login-Session-------------------------------------------------------------------#
                if(isset($_SESSION['loggedin'])){
                    $getsilkquery = sqlsrv_query($dbcn,"Select * from $dbname3.dbo.SK_Silk Where ID in (Select ID from SK_USER Where Username = '{$_SESSION['User']}')")
                    or Emsg("Points error 90");
                    
                    if($getresult = sqlsrv_fetch_array($getsilkquery)){
                     $points = number_format(($getresult['silk']),0);
                    }else{
                        $points = "POINTS NOT FOUND, ERROR 95";
                    }
                    $getNameofUser = sqlsrv_query($dbcn,"Select * from $dbname3.dbo.SK_USER Where username = '{$_SESSION['User']}'");
                    
                    if ($getNameofUserResult = sqlsrv_fetch_array($getNameofUser,SQLSRV_FETCH_BOTH)){
                        $Nickname = $getNameofUserResult['Name'];
                    }else{
                        $Nickname = "Can't get the Name of user";
                    }
                    /* guild*/
                    $getch = $_SESSION['Char'];
                    $getgid = SQLSRV_QUERY($dbcn,"select GuildID from $dbname3.dbo._Guildmembers where CharID = '$getch'");
                    
                    
                    if($getgidr = SQLSRV_FETCH_ARRAY($getgid)){
                        $gid = $getgidr['GuildID'];
                    }else{$gid=null;}
                    if($getNameofUserResult['sec_primary'] == 1 && $getNameofUserResult['sec_content'] == 1){
                        $checkadmin = '<br> <li><a href="?page=Apanel">Admin panel</a></li><br>';
                    }else {$checkadmin = '';}
                    /** */
                    $_SESSION['showlogin'] = "
                    <li class='login-list-hover'><a ><span>$Nickname</span></a>
                        <ul class='login-list'> 

                            <li><a href='?page=myaccount'>My Account</a></li><br>
                            <li><a href='?page=mycharacter&id=$getch'>My Character</a></li><br>
                            <li><a href='?page=myguild&id=$gid'>My Guild</a></li><br>
                            <li><a href='?page=chat'>Guild chat</a></li><br>
                            
                            <form method='post' action='?page=logout'><br>
                            <li><button class='btn5' href='?page=logout' name='logout'>Logout</button></li>
                            </form>
                             $checkadmin
                        </ul>
                     </li>
                     <li class='fixmargin-silk-icon'><span class='logged-1' ><img class='icon' src='./img/ico/dollar.svg' alt='silk'>$points</span></li>
                     
                    ";
                }else{
                   $_SESSION['showlogin'] = '
                    <li><img class="icon" src="./img/ico/lock.png"><a href="?page=login"><span>LOGIN</span></a></li>
                    <li><img class="icon" src="./img/ico/user.png"><a href="?page=createacc" >REGISTER</a></li>
                    ';
                }        
                #-----------------------------------------------get SERVERINFO data-----------------------------------------#
                $getonlineusers = sqlsrv_query($dbcn,"select COUNT([Status]) as onlinep from $dbname3.dbo.SK_USER where [Status] = 1");
                $getRonlineusers = sqlsrv_fetch_array($getonlineusers);
                $getonliner = $getRonlineusers['onlinep'];

       
        
            if($Race == ""){
                $RACE1 = "CHINESE/EUROPE";
            }
            else{
                $RACE1=$Race;
            }
            if(is_numeric($SCHMastery) && is_numeric($SEUMastery)){
            if(($SCHMastery == "NULL" || $SCHMastery == "0") && ($SEUMastery == "NULL" || $SEUMastery == "0")){
                $RM = "NONE / NONE";
            }else if (($SCHMastery != "NULL" || $SCHMastery != "0") && ($SEUMastery == "NULL" || $SEUMastery == "0"))
            {
                $RM = "$SCHMastery / NONE";
            }else if  (($SCHMastery == "NULL" || $SCHMastery == "0") && ($SEUMastery != "NULL" || $SEUMastery != "0")){
                $RM = "NONE / $SEUMastery";
            }else {
                $RM = "$SCHMastery / $SEUMastery";
            }

           
        }
        else {
               Emsg("Mastery should be a number");
               $RM = "Error 113";
        }
 
        #-------------------------FORTRESS WAR-------------------

        #-------------------------JANGAN FORTRESS-----------------
        $getjanganFTW = sqlsrv_query($dbcn,"Select GuildID,TaxRatio from $dbname3.dbo._Fortress Where ID = 1");
        $getjFTWGWGUILD = sqlsrv_query($dbcn,"Select Name,ID from $dbname3.dbo._Guild Where ID in(select GuildID FROM $dbname3.dbo._Fortress Where ID = 1)");
        $JanganFTWMASTER = sqlsrv_query($dbcn,"Select top 1 Charname from $dbname3.dbo._Guildmembers Inner join $dbname3.dbo._Char ON _Guildmembers.CharID = _Char.ID where GuildID in(Select GuildID FROM _Fortress where ID = 1) and permission = 1");
        if($getjanganFTWres = sqlsrv_fetch_array($getjanganFTW)){
            $JTAX = $getjanganFTWres['TaxRatio'];
            if($getjanganFTWres['GuildID'] == 0){
                $JGNAME = "No body";
                 }
        }
        else{
            $JGNAME = "No Body";
        }
        if($getjFTWGWGUILDres = sqlsrv_fetch_array($getjFTWGWGUILD) ){
           
            if($JGFTWSER == 1)
            {
                $JGNAME = $getjFTWGWGUILDres['Name'];
                $JGID = $getjFTWGWGUILDres['ID'];
                ?>
                
                <script type="text/javascript">
             window.addEventListener('load', function(){
                        c1("p1",<?php echo $JGID ?>);
                    }, true);
                    

                 </script>
                 <?php
            }
            else
           {
               $JGNAME= "Closed Fortress";
           }
       
                }
                else{
                    $JGNAME = "No Body";
                    $JTAX = "0"; #----E199+8 
                    Emsg("Error 157");
                }
        /* if($JanganFTWMASTERRES = sqlsrv_fetch_array($JanganFTWMASTER)){
                    $JGM = $JanganFTWMASTERRES['Charname'];
                    if(!$JanganFTWMASTERRES['Charname']){
                        $JGM = "NO ONE";
                    }
                    
             }else{
                     $JGM = "No one";
                     Emsg("Error 167");
            }      */
        #-------------------------HOTAN FORTRESS-------------------
        $HotanFTW = sqlsrv_query($dbcn,"Select GuildID,TaxRatio from $dbname3.dbo._Fortress Where ID = 3");
        $HotanFTWGWGUILD = sqlsrv_query($dbcn,"Select Name,ID from $dbname3.dbo._Guild Where ID in(select GuildID FROM $dbname3.dbo._Fortress Where ID = 3)");
        $HotanFTWMASTER = sqlsrv_query($dbcn,"Select top 1 Charname from $dbname3.dbo._Guildmembers Inner join $dbname3.dbo._Char ON _Guildmembers.CharID = _Char.ID where GuildID in(Select GuildID FROM _Fortress where ID = 3) and permission = 1");
        if($HotanFTWres = sqlsrv_fetch_array($HotanFTW)){
            $HTAX = $HotanFTWres['TaxRatio'];
            if($HotanFTWres['GuildID'] == 0){
                $HGNAME = "No body";
                 }
        }
        else{
            $HGNAME = "No Body";
            $HTAX = "0";
        }
        if($HotanFTWGWGUILDres = sqlsrv_fetch_array($HotanFTWGWGUILD)){
            if($HFTWSER == 1)
             {
                $HGNAME = $HotanFTWGWGUILDres['Name'];
                $HGID = $HotanFTWGWGUILDres['ID'];
                ?>
               <script type="text/javascript">
             
                    window.addEventListener('load', function(){
                        c1("p3",<?php echo $HGID?>);
                    }, true);
                

                     
                      

                    </script>

               
                 <?php
             }
             else
            {
                $HGNAME= "Closed Fortress";
            }

                }else{
                    $HGNAME = "No Body"; #---E199+29 = line --- cant gate the guild name 
                    Emsg("Error 212");
                }
       /* if($HotanFTWMASTERRES = sqlsrv_fetch_array($HotanFTWMASTER)){
                    $HGM = $HotanFTWMASTERRES['Charname'];
                    if(!$HotanFTWMASTERRES['Charname']){
                        $HGM = "NO ONE";
                    }
             }else{
                     $HGM = "No one";
                     Emsg("Error 222");
            }*/
        #-------------------------Bandit FORTRESS-------------------
        $BanditFTW = sqlsrv_query($dbcn,"Select GuildID,TaxRatio from $dbname3.dbo._Fortress Where ID = 6");
        $BanditFTWGWGUILD = sqlsrv_query($dbcn,"Select Name,ID from $dbname3.dbo._Guild Where ID in(select GuildID FROM $dbname3.dbo._Fortress Where ID = 6)");
        $BanditFTWMASTER = sqlsrv_query($dbcn,"Select top 1 Charname from $dbname3.dbo._Guildmembers Inner join $dbname3.dbo._Char ON _Guildmembers.CharID = _Char.ID where GuildID in(Select GuildID FROM _Fortress where ID = 6) and permission = 1");
        if($BanditFTWres = sqlsrv_fetch_array($BanditFTW)){
            $BTAX = $BanditFTWres['TaxRatio'];
            if($BanditFTWres['GuildID'] == 0){
                $BGNAME = "No body";
             }
        }
        else{
            $BGNAME = "No Body";
            $BTAX = "0";
        }
        if($BanditFTWGWGUILDres = sqlsrv_fetch_array($BanditFTWGWGUILD) ){
            
            if($BFTWSER == 1)
             {
                
                $BGNAME = $BanditFTWGWGUILDres['Name'];
                $BGID = $BanditFTWGWGUILDres['ID'];
                $liline = "href='?page=myguild&id=$BGID'";
                
                echo '<script type="text/javascript">c1("p2",13);</script>';
             }
             else
            {
                $BGNAME= "Closed Fortress";
                $liline = "";
            }
         }
         else{
            $BGNAME = "No Body";
        }
       /* if($BanditFTWMASTERRES = sqlsrv_fetch_array($BanditFTWMASTER)){
            $BGM = $BanditFTWMASTERRES['Charname'];
            if(!$BanditFTWMASTERRES['Charname']){
                $BGM = "NO ONE";
            }
            
        }else{
             $BGM = "No one";
             Emsg("Error 275");
    }*/
?>

<!DOCTYPE html>
<html lang="en">

    
<head>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href='./style.css' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src='./php/guildchat/inv.js'></script>
    
    
    <title><?php echo $sitename ; ?></title>
    <script src ="./js/functions.js"></script>
    <!-- JS scripts -->
    <script>
    window.onscroll = function() {scrollFunction()};
    function scrollFunction() {
        if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
             document.getElementById("nav1").style.opacity = 0.8;
    
        } else {
            document.getElementById("nav1").style.opacity = 1;
    
                }
        }
    </script>
       <script>
    window.onscroll = function() {authorfunction()};
    function authorfunction() {
          
            var s = document.documentElement.clientHeight;
            var x = s;
        if ( ((s  - document.documentElement.scrollTop)*100)/x  < 10) {

             document.getElementById("auth").style.opacity = 0  ;
             }
         else{
             document.getElementById("auth").style.opacity = 0;
         }
        }
    </script>
<!-- END JS scripts -->
</head>
<body>
       
    
    <header>
        <nav id = "nav1" class="navbar">
           <ul class="main-nav">
           <div><img src="./img/Banner-1.png" class="logo"></div>
                <li><a href="?page=news">Home</a></li>
                <li><a href="?page=downloads" >Download</a></li>
                <li><a href="?page=index">RANKING</a></li>
                <li><a href="?page=webmall">WEB&nbspSHOP</a></li>
                <?php echo $_SESSION['showlogin']; unset($_SESSION['showlogin']);?>
            </ul>
        </nav>
    </header>


    <div class='allpages-2'>
       <div class="part-of-header">
        <h1><?php echo $title ?> NETWORK REAPER OF SOULS</h1>
        <p>"One of the best Online games"</p>
        </div>

    <section id='getpos' class="home-serverpanel-section">
                <div class="serverinfo-panel">
                    <p class="log-word">SERVER INFO</p>
                     <div class="serverinfo-inside">
                    <p>Online Players: <?php echo $getonliner ?></p>
                    <p>Cap: <?php echo $Scap ?></p>
                    <p>Degree: <?php echo $SDEGREE ?></p>
                    <p>Race: <?php echo $RACE1 ?></p>
                    <p>Mastery: <?php echo $RM ?></p>
                    <p>EXP: <?php echo $EXPRATE?>x</p>
                    <p>Max Plus: <?php echo $MPLUS ?> (Adv)</p>
                    <p>Alchemy Rate: <?php echo $AR ?>x</p>
                    <p>Guild Limit: <?php echo $GL ?></p>
                    <p>Union Limit: <?php echo $UN ?></p>
                    </div> 
                    <p class="log-word">FORTRESS WAR</p>
                    <div class="serverinfo-inside">
                        

                           <ul id="getul" class="getul-1">
                                <li>
                                 <img  src="./img/ico/jan.png">
                                 <a class="name-ftw">Jangan</a>
                                 <ul class="getul-2">
                                     <li><span>Guild</span></li>
                                     <li><a class="GUILD" id="p1"><?php echo $JGNAME ?></a></li>
                                     <li><span>Tax </span></li>
                                     <li> <?php echo $JTAX; ?>%</li>
                                     
                                </ul>
                                </li>    
                                
                           </ul>
                           <ul class="getul-1">
                                <li>
                                 <img  src="./img/ico/bandit.png">
                                 <a class="name-ftw">Bandit</a>
                                 <ul class="getul-2">
                                     <li><span>Guild</span></li>
                                     <li><a  class="GUILD" id="p2" <?php echo $liline ?>><?php echo $BGNAME ?></a></li>
                                     <li><span>Tax </span></li>
                                     <li> <?php echo $BTAX; ?>%</li>
                                    
                                </ul>
                                </li>    
                                
                           </ul>
                           <ul class="getul-1">
                                <li>
                                 <img  src="./img/ico/hotan.png">
                                 <a class="name-ftw">Hotan</a>
                                 <ul class="getul-2">
                                     <li><span>Guild</span></li>
                                     <li><a  class="GUILD" id="p3"><?php echo $HGNAME ?></a></li>
                                     <li><span>Tax </span></li>
                                     <li> <?php echo $HTAX; ?>%</li>
                                </ul>
                                </li>    
                           </ul>
                    </div> 
                </div>
               
                <div  class="home-section">
                            <div class="page-content">
                            <?php include_once("pager.php"); ?>
                            </div>
        
            </div>
     </section>

       
         
         <footer >  
         
        <div class='copyright-div'>
                <span class="copyright"></span>
         </div>
        </footer>
        
        </div>
   
    

</body>
</html>