<?php
/*
    Below are the length definitions for the columns in the 
    flat file. You may use it, move it, delete it. Whatever 
    works for you. Please put all your code in this file and return
    it for review.
 */

$definitions = [
['name' => 'Serial Number', 'length' => 16, 'type' => 'int'],
['name' => 'Language', 'length' => 3, 'type' => 'string'],
['name' => 'Business Name', 'length' => 32, 'type' => 'string'],
['name' => 'Business Code', 'length' => 8, 'type' => 'string'],
['name' => 'Authorization Code', 'length' => 8, 'type' => 'string'],
['name' => 'Timestamp', 'length' => 20, 'type' => 'timestamp'],
];

/**
 * checks to see if record has valid data
 *
 * @return BOOL
 */
function testLine ($str) {
    $testLineResult = TRUE;
    if (strlen($str) > 88) {
        $testLineResult = FALSE;
    } else if (!preg_match('/[0-9]{16}/',$str)) {
        $testLineResult = FALSE;
    }
    return $testLineResult;
}

/**
 * controls the offset when moving through the file
 *
 * @return int
 */
function setOffset ($offSet, $newOffset) {
    $offSet = $offSet + $newOffset; 
    return $offSet;
}

/**
 * Helper function for the Usort that sorts the array by business name
 *
 * return @array
 */
function businessNameSort ($x, $y) {
    return strcasecmp($x['businessName'], $y['businessName']);
}

try
{
    $fileName = 'data.txt';

    if ( !file_exists($fileName) ) {
        throw new Exception('File not found.');
    }

    $file = new SplFileObject("data.txt");
    if ( !$file ) {
        throw new Exception('File open failed.');
    }  
    $lineNumber = 1;
    $defTotals = sizeof($definitions);
    $EOL = PHP_EOL;
    $theResults = array();

    /**
     * set lengths as easy to use variables
     *
     */
    $serialLength = $definitions[0]["length"];
    $languageLength = $definitions[1]["length"];
    $businessNameLength = $definitions[2]["length"];
    $businessCodeLength = $definitions[3]["length"];
    $authorizationCodeLength = $definitions[4]["length"];
    $timeStampLength = $definitions[5]["length"];


    while (!$file->eof()) {
        $offSet = $serialLength;
        $str = $file->fgets();
        $testLine = testLine($str);
        if ($testLine == FALSE)  {
            echo 'Line Number: '.$lineNumber.' is an incorrect length, Please check the data' . $EOL;
            $lineNumber++;
            echo $EOL;
        } else {
            $theResults[$lineNumber]['lineNumber'] = $lineNumber;
            $theResults[$lineNumber]['serialNumber'] = substr($str,0,$serialLength);
            $theResults[$lineNumber]['language'] = substr($str,$offSet,$languageLength); 
            $offSet = setOffset($offSet, $languageLength);
            $theResults[$lineNumber]['businessName'] = trim(substr($str,$offSet,$businessNameLength),' ');
            $offSet = setOffset($offSet, $businessNameLength);
            $theResults[$lineNumber]['businessCode'] = substr($str,$offSet,$businessCodeLength);
            $offSet = setOffset($offSet, $businessCodeLength);
            $theResults[$lineNumber]['authCode'] = substr($str,$offSet,$authorizationCodeLength);
            $offSet = setOffset($offSet, $authorizationCodeLength);
            $theResults[$lineNumber]['timeStamp']= substr($str,$offSet,$timeStampLength);
            $lineNumber++;
            unset($offSet);
        }
    }
    $fileName = null;

} catch ( Exception $e ) {
    echo 'This didn\'t work';
}

usort($theResults, 'businessNameSort');

$lineNumber = 1;
foreach($theResults as $result) {
    if ($result['serialNumber'] == '') {
        continue;
    } else {
        echo 'Line Number: '. $result['lineNumber'] . $EOL;
        echo 'Serial Number: '. $result['serialNumber'] . $EOL;
        echo 'Language: ' . $result['language'] . $EOL;
        echo 'Business Name: ' . $result['businessName'] . $EOL;
        echo 'Business Code: ' . $result['businessCode'] . $EOL;
        echo 'Authorization Code: ' . $result['authCode'] . $EOL;
        echo 'Time Stamp: '. $result['timeStamp'] . $EOL;
        echo $EOL;
    }
    $lineNumber++;
}


/*Column One
Definition: serial number
Data Type: left padded integer
Length 16

Column Two
Definition: Language
Data Type: string
Length: 3

Column Three
Definition: Business Name
Data Type: string
Length: 32

Column Four
Definition: Business Code
Data Type: string
Length: 8

Column Five
Definition: Authorization Code
Data Type: string
Length 8

Column six
Definition: Timestamp
Data Type: string as (yyyy-mm-dd hh:mm:ss)
Length: 20*/
