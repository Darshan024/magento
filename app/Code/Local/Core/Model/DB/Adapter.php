<?php
class Core_Model_DB_Adapter
{
    public $config = [
        "host" => "localhost",
        "password" => "",
        "user" => "root",
        "database" => "ccc_project"
    ];
    public $connect = null;
    public function connect()
    {
        if (is_null($this->connect)) {
            $this->connect = mysqli_connect(
                $this->config["host"],
                $this->config["user"],
                $this->config["password"],
                $this->config["database"]
            );
        }
        return $this->connect;
    }
    public function fetchAll($query)
    {
        $rows = [];
        $sql = mysqli_query($this->connect(), $query);

        while ($row = mysqli_fetch_assoc($sql)) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function fetchPairs($query)
    {
    }
    public function fetchOne($query)
    {

    }
    public function fetchRow($query)
    {
        // print_r($query);
        // die;
        $rows = [];
        $sql = mysqli_query($this->connect(), $query);
        while ($row = mysqli_fetch_assoc($sql)) {
            $rows = $row;
        }
        return $rows;
    }
    public function insert($query)
    {
        // print_r($query);
        // echo "<br>";
        // die;
        $sql = mysqli_query($this->connect(), $query);
        if ($sql) {
            return mysqli_insert_id($this->connect());
        } else {
            return false;
        }
    }
    public function update($query)
    {
        // print_r($query);
        // die;
        // echo "<br>";
        $sql = mysqli_query($this->connect(), $query);
        if ($sql) {
            return true;
        } else {
            return false;
        }
    }
    public function delete($query)
    {
        $sql = mysqli_query($this->connect(), $query);

        if ($sql) {
            return true;
        } else {
            return false;
        }
    }
    public function query($query)
    {

    }
}
?>