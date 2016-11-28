@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <style>
        .header{
            background: url("/images/background3.jpg")!important;
            height: 900px!important;
        }
		td{
			color: white;
			font-size: 24px;
		}
		#livesearch {
			color: white;
			font-size: 24px;
		}
    </style>
	<script>
function setResult(str, fn) {
	document.getElementById("inputfield" + fn).value = str;
}
function showResult(str, fn) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch" + fn).innerHTML=this.responseText;
      document.getElementById("livesearch" + fn).style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","/inc/teamsearch.php?comp=hs&fn="+fn+"&q="+str,true);
  xmlhttp.send();
}
</script>
                    <div class="ticket-content">
                        <h1>Contact</h1>
                        <form>
                            <table class="registrationtable">
								<?php
								session_start();
								
								for($i=1; $i < 5; $i++) {
								if(isset($_GET["f".$i])) {
									$_SESSION["f".$i] = $_GET["f".$i];
								} else {
									$_SESSION["f".$i] = $_SESSION["f".$i]; 
								}
								if(empty($_SESSION['f'.$i])) {
									$_SESSION['f'.$i] = "";
								}
								
								echo '<tr><td>Teamspeler '.$i.'</td><td><input value="'.$_SESSION["f".$i].'" name="inputfield'.$i.'" type="text" size="30" onkeyup="showResult(this.value, '.$i.')"><div id="livesearch'.$i.'"></div><td></td></tr>';	
								}
								
								?>
							</table>
                        </form>
                    </div>
                    <div class="clear"></div>
@endsection
