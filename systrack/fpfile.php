<?php
require 'class.FootPrintsInFile.php';
/**
 * Class Object
 */
$File = new FootPrintsInFile('track.log');

/**
 * To store the visitor's information
 */
$File->storeInfo();

/**
 * To retrieve and print the stored info
 */
print nl2br($File->retrieveInfo());