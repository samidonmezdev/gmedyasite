<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$dbhost = '95.173.187.164';
$dbuser = 'foreks';
$dbpass = '!!Frks321!!';
$dbname = 'foreks';

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$conn->set_charset("utf8");
  
// Check connection
if($conn->connect_error)
{
    echo("Connection failed: " . $conn->connect_error.'<hr><br>');
} 

$exchanges = array(
	'INDUD' => 'DJI',
	'NDX100R' => 'IXIC',
	'SPXR' => 'GSPC',
	'UKXR' => 'FTSE',
	'DAXR' => 'GDAXI'
);

function getLastPrice($symbol)
{
	$APIKey = 'EAWL447L9RA0F05O';
	$url = 'tmp/'.$symbol.'.json';
	$json = json_decode(file_get_contents($url), true);

	return($json['Global Quote']);
}

foreach($exchanges as $exchange => $symbol)
{
	$data = getLastPrice($symbol);

	$sql1 = "SELECT * FROM `tblTarihsel` WHERE `strSembol` LIKE '".$exchange."' ORDER BY `strTarih` DESC LIMIT 0,1";
	$result = $conn->query($sql1);
	$row = $result->fetch_array(MYSQLI_ASSOC);

	if(
		number_format((float)$data['02. open'], 6, '.', '') != $row['dblAcilis'] && 
		number_format((float)$data['03. high'], 6, '.', '') != $row['dblEnYuksek'] && 
		$data['07. latest trading day'] != substr($row['strTarih'], 0, 4).'-'.substr($row['strTarih'], 4, -2).'-'.substr($row['strTarih'], -2)
	)
	{
		$sql2 = "INSERT INTO `tblTarihsel` (`strTarih`, `strSembol`, `dblAcilis`, `dblKapanis`, `dblEnDusuk`, `dblEnYuksek`, `dblHacim`, `dblHacimTL`) VALUES ('".substr($data['07. latest trading day'], 0, 4).''.substr($data['07. latest trading day'], 5, -3).''.substr($data['07. latest trading day'], -2)."', '".$exchange."', '".number_format((float)$data['02. open'], 6, '.', '')."', '".number_format((float)$data['08. previous close'], 6, '.', '')."', '".number_format((float)$data['04. low'], 6, '.', '')."', '".number_format((float)$data['03. high'], 6, '.', '')."', '".number_format((float)$data['06. volume'], 4, '.', '')."', '".number_format((float)$data['06. volume'], 4, '.', '')."');";
#		echo($sql2.'<hr>');
		$result = $conn->query($sql2);
	}

}

$conn->close();
