<?php
require 'class.VisitorFootPrints.php';

/**
 * Class FootPrintsInDB
 */
class FootPrintsInDB extends VisitorFootPrints
{

    private $dbServer;
    private $dbUsername;
    private $dbPassword;
    private $dbName;
    private $dbLink;
    private $tableName;

    /**
     * @author              Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description         Use to initialize the database server details and to connect the database server.
     * @param $dbServer     Database Server Name
     * @param $dbUser       Database Server User
     * @param $dbPassword   Database Server Password
     * @param $dbName       Database Name
     * @param $dbTable      Table Name
     */
    function __construct($dbServer, $dbUser, $dbPassword, $dbName, $dbTable)
    {

        if (!extension_loaded('mysql')) {
            trigger_error('MySQL extension is not installed: ', E_USER_ERROR);
            return false;
        }

        parent::__construct();

        $this->dbServer = $dbServer;
        $this->dbUsername = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->dbName = $dbName;
        $this->tableName = $dbTable;

        if (!$this->dbLink = mysql_connect($this->dbServer, $this->dbUsername, $this->dbPassword)) {
            trigger_error('Unable to connect to the database server: ', E_USER_ERROR);
            return false;
        } else {
            if (!mysql_select_db($this->dbName, $this->dbLink)) {
                $this->createDatabase($this->dbName);
            }
            $this->checkTable($this->tableName);
        }

    }

    /**
     * @author              Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description         Use to store the visitor's information into database table.
     * @return bool         "true" if information successfully stored in database table
     *                      "false" if information not stored in database table
     */
    public function storeInfo()
    {
        $trackDetails = $this->trackDetails();
        $insertDetails = "INSERT INTO $this->tableName (trackip,trackcontinent,trackregion,trackcountry,trackreferrer, trackos, trackhost, trackbrowser, trackdatetime) VALUES('$trackDetails[IP]','$trackDetails[Continent]','$trackDetails[Region]','$trackDetails[Country]','$trackDetails[Referrer]','$trackDetails[OS]','$trackDetails[Host]','$trackDetails[Browser]','$trackDetails[DateTime]')";

        if (!mysql_query($insertDetails, $this->dbLink)) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * @author              Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description         Use to create the database
     * @param $selectDBName Database Name
     * @return bool         "true" if database created successfully
     *                      "false" if database not created successfully
     */
    private function createDatabase($selectDBName)
    {
        $createDatabase = "CREATE DATABASE $selectDBName";
        if (!mysql_query($createDatabase, $this->dbLink)) {
            trigger_error("Error while creating the database $selectDBName", E_USER_ERROR);
            return false;
        } else {
            mysql_select_db($selectDBName, $this->dbLink);
            return true;
        }
    }

    /**
     * @author                  Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description             Use to create the table
     * @param $selectTableName  Table Name
     * @return bool             "true" if table created successfully
     *                          "false" if table not created successfully
     */
    private function createTable($selectTableName)
    {
        $createTable = "
        CREATE TABLE $selectTableName(
        trackid INT PRIMARY KEY AUTO_INCREMENT,
        trackip VARCHAR(255) NOT NULL,
        trackcontinent VARCHAR(255) NOT NULL,
        trackregion VARCHAR(255) NOT NULL,
        trackcountry VARCHAR(255) NOT NULL,
        trackreferrer TEXT NOT NULL,
        trackos VARCHAR(255) NOT NULL,
        trackhost VARCHAR(255) NOT NULL,
        trackbrowser VARCHAR(255) NOT NULL,
        trackdatetime VARCHAR(255) NOT NULL
        )
        ";

        if (!mysql_query($createTable, $this->dbLink)) {
            $error = mysql_error();
            trigger_error("Error while creating the table $selectTableName $error", E_USER_ERROR);
            return false;
        } else {
            return true;
        }

    }

    /**
     * @author                  Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description             Use to check the existence of table and if the table not exists function will create a new table
     * @param $selectTableName  Table Name
     * @return bool             "false" if error occurs while checking the existence of table
     */
    private function checkTable($selectTableName)
    {
        $queryCheck = "SHOW TABLES LIKE '$selectTableName'";
        if (!$resultCheck = mysql_query($queryCheck, $this->dbLink)) {
            trigger_error('Error while checking the existence of table: ', E_USER_ERROR);
            return false;
        } else {
            $resultCount = mysql_num_rows($resultCheck);
            if ($resultCount !== 1) {
                $this->createTable($selectTableName);
            }
        }

    }

    /**
     * @author              Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description         Use to retrieve the visitor's information from the database table
     * @return array        The fetched information
     */
    function retrieveInfo()
    {
        $queryGetDetails = "SELECT * FROM $this->tableName";
        $allDetails = array();
        if (!$resultDetails = mysql_query($queryGetDetails, $this->dbLink)) {
            die('Error while retrieving the information.');
        } else {
            if (mysql_num_rows($resultDetails) < 1) {
                return "No Records Found";
            } else {
                while ($info = mysql_fetch_assoc($resultDetails)) {
                    $allDetails[] = $info;
                }
            }
        }
        return $allDetails;
    }

}