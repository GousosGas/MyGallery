<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/configuration.php";

class Database
{
    public $connection;

    function __construct()
    {
        $this->open_db_connection();
    }

    public function open_db_connection()
    {
        /*Cloud connection*/
        $this->connection = new mysqli(null, DB_USER, DB_PASSWORD, DB_NAME, null, DB_SOCKET);

        /*localhost connection*/
        //$this->connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        if ($this->connection->connect_errno) {
            die("database connection failed" . $this->connection->connect->connet_errno);

        }
    }

    public function query($sql)
    {
        $result = $this->connection->query($sql);
        $this->confirm_query($result);
        return $result;

    }

    private function confirm_query($result)
    {
        if (!$result) {
            die("Query failed" . $this->connection->error);
        }

    }

    public function escape_string($string)
    {
        $escape_string = $this->connection->real_escape_string($string);
        return $escape_string;
    }

    public function the_insert_id()
    {
        return mysqli_insert_id($this->connection);
        /*The mysqli_insert_id() function
        returns the id (generated with AUTO_INCREMENT)
         used in the last query.*/
    }


}

$database = new Database();
