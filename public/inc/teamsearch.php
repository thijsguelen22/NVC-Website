<?php
session_start();
include("../connector.php");
$form = $_GET['form'];
$teamnaam = isset($_GET['name']) ? $_GET['name'] : '';
$user = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';
//echo $_GET['comp'];
if($form == "naam") {
	$query = 'SELECT * FROM teams WHERE TeamSpel = :comp';
	$PDOArr = array(':comp'=>$_GET['comp']);
} else {
	$query = 'SELECT * FROM gasten, teams WHERE teams.TeamSpel = :comp AND gasten.GastId = teams.TeamAdmin AND gasten.GastId != :GastId';
	$PDOArr = array(':GastId'=>$user,
	':comp'=>$_GET['comp']);
}
$sth = $pdo->prepare($query);
$sth->execute($PDOArr);
$data = $sth->fetchAll(PDO::FETCH_ASSOC);
//var_dump($data);

function array_to_xml(array $arr, SimpleXMLElement $xml)
{
    foreach ($arr as $k => $v) {
        is_array($v)
            ? array_to_xml($v, $xml->addChild($k))
            : $xml->addChild($k, $v);
    }
    return $xml;
}
//var_dump($array);
$fieldnumber = $_GET['fn'];
var_dump($_GET['name']);
/*echo '<script>
function fillForm(fn, value) {
	document.getElementById("inputfield" + fn).value = value;
}
</script>';*/
//$xmlDoc=new DOMDocument();
//$xmlDoc->load("links.xml");

//$x=$xmlDoc->getElementsByTagName('link');

//get the q parameter from URL
$q=$_GET["q"];

//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $hint="";
  foreach($data as $value) {
	if($form == "naam") {
		$n=$y=$value['TeamNaam'];
		$z=$value['TeamAdmin'];
	} else {
		$y=$value['Naam'];
		$n=$z=$value['GastId'];
	}
      //find a link matching the search text
      if (stristr($y,$q)) {
        if ($hint=="") {
          //$hint='<a id="setres" onClick="setResult('."'".$z."', '".$fieldnumber."'".')">' .
		  $hint='<td class="nextbutton dynsearch"><a name="setres" id="setres" href="./inc/passthrough.php?teamnaam='.$teamnaam.'&fn='.$fieldnumber.'&str='.$n.'" value="'.$z.'"/>' .
          $y . '</a></td></tr>';
        } else {
          $hint=$hint . '<td class="nextbutton dynsearch"><a class="nextbutton dynsearch" name="setres" id="setres" href="./inc/passthrough.php?teamnaam='.$teamnaam.'&fn='.$fieldnumber.'&str='.$n.'" value="'.$z.'"/>' .
          $y . '</a></td></tr>';
        }
      }
    
  }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint=="") {
  $response="no suggestion";
} else {
  $response=$hint;
}

//output the response
echo $response;

?>