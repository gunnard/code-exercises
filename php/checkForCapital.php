<?php
/**
 * Checks if a string begins with a capital Letter 
 *
 * @param (string) (word) The word to be evaluated
 * @return (bool)
 */
function checkForCapital($word) {
    if (is_string($word)) {
        if (preg_match('/\A[A-Z]()/',$word)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

$word = "testWord";
$output = ( checkForCapital($word) == true )? "Yes, the letter is: ".$word[0]."." : "No, there is not a capital letter.";
echo $output;
?>
