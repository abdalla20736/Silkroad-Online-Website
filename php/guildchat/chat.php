<head>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

<script src="jquery.min.js"></script>
   <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

</head>
<script>
var checkbottom;
jQuery(function($) {
$('#automsg').on('scroll', function() {
    var check = $(this).scrollTop() + $(this).innerHeight() >= $(this) 
[0].scrollHeight;
    if(check) {
       checkbottom = "bottom";
       
    }
    else {
    checkbottom = "nobottom";
    }
})
});
window.setInterval(function(){
if (checkbottom=="bottom") {
var objDiv = document.getElementById("automsg");
objDiv.scrollTop = objDiv.scrollHeight;
}
}, 200);
$(document).ready(function() {
    $("#automsg").animate({ scrollTop: "500000000000"});
});

$(window).load(function() {
$("#automsg").animate({ scrollTop: "500000000000"});
});

var auto_refresh = setInterval(function(){
$('#automsg').load('./php/guildchat/chatmsg.php'); return false;

},500 );

</script>

<?php
    if(!empty($_SESSION['Char']))
    $Gcharid = $_SESSION['Char'];
    else{
    $Gcharid = NULL;
    }
    $checkifhasguild = SQLSRV_QUERY($dbcn,"Select GuildID from _Guildmembers Where CharID = '$Gcharid'",array(),array('scrollable'=>SQLSRV_CURSOR_KEYSET));
    if(SQLSRV_NUM_ROWS($checkifhasguild) > 0){
    $getusr = SQLSRV_QUERY($dbcn,"Select * from $dbname3.dbo.SK_USER Where ID in (select UserID FROM $dbname3.dbo._CHAR where ID = '$Gcharid')");
    $getusrr= SQLSRV_FETCH_ARRAY($getusr);
    $getallchars = SQLSRV_QUERY($dbcn,"Select * from $dbname3.dbo._Guildmembers Where GuildID in (Select GuildID from $dbname3.dbo._Guildmembers Where CharID = '$Gcharid')");
    $Getallcharsr = SQLSRV_FETCH_ARRAY($getallchars);
    $Gguildid = $Getallcharsr['GuildID'];
    $getC = SQLSRV_QUERY($dbcn,"Select _OnlineChat.ID,_Guild.[Name] as GName,Charname,GuildID,CharID,MSG,Mtime from $dbname3.dbo._OnlineChat inner join $dbname3.dbo._Guild on _OnlineChat.GuildID = _Guild.ID inner join $dbname3.dbo._Char on _OnlineChat.CharID = _Char.ID where GuildID = '$Gguildid' order by _OnlineChat.Mtime ASC");

            echo"
            <h1 style='text-align:center; margin-top:20px;'>WELCOME TO GUILD ONLINE CHAT</h1> 
            <div class='chat-div'> 
                    <div  class='chat-msg-div'>
                        <div  id='automsg' class='chat-msg-part'>

            </div>
            <div class='chat-send-part'>
            <textarea autocomplete='off' rows='4' cols='30' type='text' rows='1' maxlength='100' placeholder=' type a message...' id='cmsg1' name='cmsg'></textarea>
            <button type='submit' id='sendbtn' class='chat-send-btn'>Send</button>
            </div>
            </div></div>";
            
            ?>
<script type="text/javascript">
            $(document).ready(function(){
            $('#sendbtn').click(function() {
                var inp = $('#cmsg1');
                if(inp.val().length > 0){
                    var Gguildid = "<?php echo $Gguildid; ?>"
                    var Gcharid = '<?php echo $Gcharid; ?>'
                    var mssgg = inp.val();
                    $.ajax({
                url: './php/guildchat/sendmsg.php',
                type: 'POST',
                data: { msg : mssgg, gid : Gguildid, gcid : Gcharid },

                error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("some error");
                }
                });
                $('#cmsg1').val('');
                
                }
                $("#automsg").animate({ scrollTop: "500000000" });
            });
            });
    
            $('#cmsg1').keypress(function (e) {
            var key = e.which;
            if(key == 13)  
            {
                $('#sendbtn').click(); return false;  
            } });   
</script>
        <?php
   
    }else{
        echo"<h1 style='text-align:center; margin-top:20px;'>Sorry, You have no guild</h1>";
    }
?>