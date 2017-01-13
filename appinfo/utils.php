<?php

/**
 * Convert a multi-dimensional, associative array to CSV data
 * @param  array $data the array of data
 * @return string       CSV text
 */
function str_putcsv($data)
{
	# Generate CSV data from array
	$fh = fopen('php://temp', 'rw');
	# don't create a file, attempt
	# to use memory instead

	# write out the headers
	fprintf($fh, chr(0xEF) . chr(0xBB) . chr(0xBF));
	fputcsv($fh, array_keys(current($data)), ";");

	# write out the data
	foreach ($data as $row)
	{
		fputcsv($fh, $row, ";");
	}
	rewind($fh);
	$csv = stream_get_contents($fh);
	fclose($fh);

	return $csv;
}

function generate_zip($data_array)
{
	// Zip the file
	$zipFile = tempnam(sys_get_temp_dir(), 'zipfile');
	$zip = new ZipArchive;
	$zip->open($zipFile, ZipArchive::OVERWRITE);

	foreach ($data_array as $dataName => $dataValue)
	{
		$zip->addFromString($dataName, $dataValue);
	}

	$zip->close();
	$zippedContent = file_get_contents($zipFile);

	unlink($zipFile);

	return $zippedContent;
}

function utf8_converter(&$item, $key)
{
	if (!mb_detect_encoding($item, 'utf-8', true))
	{
		$item = utf8_encode($item);
	}
}

function array_to_json($array)
{
	$array_utf8 = array_walk_recursive($array, "utf8_converter");
	$json = json_encode($array, JSON_UNESCAPED_UNICODE);
	$json_decoded = utf8_decode($json);
	return $json_decoded;
}

function json_to_array($json)
{
	$json_utf8 = utf8_encode($json);
	$array = json_decode($json_utf8);

	return $array;
}

//Exits
function ERROR_EXIT($errorMessage, $errorInfo)
{
	$GLOBALS['exit_strings']["ErrorInfo"] = $errorInfo;
	$GLOBALS['exit_strings']["ErrorMessage"] = $errorMessage;
	JSON_EXIT_ARRAY($GLOBALS['exit_strings']);
}

$exit_strings = [];
function JSON_EXIT_PUSH_STRING($string)
{
	array_push($GLOBALS['exit_strings'], $string);
}

function JSON_EXIT_STRING($string)
{
	JSON_EXIT_PUSH_STRING($string);
	JSON_EXIT_ARRAY($GLOBALS['exit_strings']);
}

function JSON_EXIT_ARRAY($array)
{
	echo array_to_json($array);
	exit();
}
?>