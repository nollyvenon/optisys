<?php
require 'class.FootPrintsInDB.php';

/**
 * Class Object
 */
$DB = new FootPrintsInDB('localhost', 'root', '', 'optisys', 'footprintdetails');

/**
 * To store the visitor's information
 */
$DB->storeInfo();

/**
 * To retrieve and print the stored info
 */
//$DB->createTable($footprintdetails);
session_start();
foreach ($DB->retrieveInfo() as $allInformation) {
    foreach ($allInformation as $info) {
        echo $info . ' | ';
    }
    echo "<hr>";
}


//echo $this->session->set_userdata('admin_id', $row->admin_id);
