<?php
$exchanges = array(
	'FTSE100' => 'FTSE',
	'HANG SENG' => 'HSI',
	'DAX' => 'GDAXI'
);

function getLastJson($symbol)
{
	$APIKey = 'EAWL447L9RA0F05O';
	$url = 'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=^'.$symbol.'&apikey='.$APIKey;
	$json = file_get_contents($url);

	return($json);
}

foreach($exchanges as $exchange => $symbol)
{
	echo('<h2>'.$exchange.'</h2>');
	$json = getLastJson($symbol);

	echo('<pre>'.$json.'</pre>');

	$data = json_decode($json, true);
	if(isset($data['Global Quote']))
	{
		$fileCreate = fopen($_SERVER['DOCUMENT_ROOT'].'/yurtdisi/tmp/'.$symbol.'.json', 'w');
		fwrite($fileCreate, $json);
		fclose($fileCreate);
	}
}
