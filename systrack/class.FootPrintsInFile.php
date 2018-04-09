<?php
require 'class.VisitorFootPrints.php';
/**
 * @package         PHP-Lib
 * @description     Class is used to store and retrieve the visitor's information in log file.
 * @copyright       Copyright (c) 2013, Peeyush Budhia
 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
 */
class FootPrintsInFile extends VisitorFootPrints
{

    public $logFile;

    /**
     * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description     Initialize the log file
     * @param $logFile  Log file name
     */
    function __construct($logFile)
    {
        parent::__construct();
        $this->logFile = $logFile;
    }

    /**
     * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description     Use to store the visitor's information into log file
     * @return bool     "true" if information successfully stored in file
     *                  "false" if information not stored in file
     */
    public function storeInfo()
    {
        if (!file_exists($this->logFile)) {
            $handler = fopen($this->logFile, 'w');
            fclose($handler);
        }
        $allDetails = '';
        $handler = fopen($this->logFile, 'a');
        foreach ($this->trackDetails() as $Details) {
            $allDetails .= $Details . ' | ';
        }
        if (!fwrite($handler, $allDetails . ";\r\n")) {
            fclose($handler);
            return false;
        } else {
            fclose($handler);
            return true;
        }
    }

    /**
     * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description     Use to retrieve the visitor's information from the log file
     * @return bool     "true" if information successfully fetched from the log file
     *                  "false" if information not stored fetched from the log file
     */
    public function retrieveInfo()
    {
        $allInfo = '';
        $handler = fopen($this->logFile, 'r');
        while (!feof($handler)) {
            $allInfo .= fgets($handler, 1024);
        }
        return $allInfo;
    }

}