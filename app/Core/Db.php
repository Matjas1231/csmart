<?php

namespace App\Core;

if (!function_exists("eregi")) {
    function eregi($pattern, $string)
    {
        $pattern = "/" . $pattern . "/i";
        return preg_match($pattern, $string);
    }
}

class Db
{
    var $conn;
    var $error;
    var $error_msg;
    var $host;
    var $user;
    var $pass;
    var $database;
    var $cnt;
    var $if_cnt;

    function __construct()
    {
        require_once("config.php");

        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;

        $this->if_cnt = false;
        $this->cnt = 0;
    }
    function start_cnt()
    {
        $this->if_cnt = true;
        $this->cnt = 0;
    }
    function end_cnt()
    {
        $this->if_cnt = false;
    }
    function connect()
    {
        global $domain;


        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->database);
        if (!$this->conn) {
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            //exit;
        }
        mysqli_query($this->conn, "set names utf8 COLLATE 'utf8_polish_ci'");
    }
    function disconnect()
    {
        mysqli_close($this->conn);
    }
    function query($q)
    {
        global $domain;

        $query = mysqli_query($this->conn, $q);

        if ($this->if_cnt == true) $this->cnt++;

        if ((eregi("update ", $q) || eregi("insert into ", $q) || eregi("delete ", $q)) && !$query) {
            echo $q . "<br>";

            $this->error = 1;
            echo $this->conn->error;
        }
        // echo $this->conn->error;
        $this->error_msg = $this->conn->error;

        return $query;
    }

    function get_all($table, $where_id = "")
    {
        return $this->query("SELECT * FROM " . $table . " " . (($where_id == "") ? "" : "WHERE id='" . $where_id . "'"));
    }
    function get_all_where($table, $where)
    {
        return $this->query("SELECT * FROM " . $table . " WHERE " . $where);
    }

    function query_all($table)
    {
        return $this->query("SELECT * FROM " . $table);
    }

    function get_row($table, $where_id = "")
    {
        return $this->row($this->get_all($table, $where_id));
    }
    function get_row_where($table, $where)
    {
        return $this->row($this->get_all_where($table, $where));
    }

    function num($q)
    {
        $w = $this->query($q);
        return $w->num_rows;
    }
    function row($query)
    {
        $fetch = mysqli_fetch_array($query);

        return $fetch;
    }
    function update($table, $array, $id)
    {
        $array['mu'] = $_SESSION['user_id'] ?? 2;
        $array['dm'] = date("Y-m-d H:i:s");
        foreach ($array as $key => $value) {
            $set[] = "`" . $key . "`='" . $this->pv($value) . "'";
        }
        $this->query("update " . $table . " set " . implode(",", $set) . " where id='" . $id . "'");
        return $id;
    }
    function update_where($table, $array, $where)
    {
        $array['mu'] = $_SESSION['user_id'] ?? 1;
        $array['dm'] = date("Y-m-d H:i:s");
        foreach ($array as $key => $value) {
            $set[] = "`" . $key . "`='" . $this->pv($value) . "'";
        }
        $res = $this->query("update " . $table . " set " . implode(",", $set) . " where " . $where);
        mysqli_free_result($res);
        return $id;
    }
    function insert($table, $array, $id = "", $no_save = false)
    {
        date_default_timezone_set("Europe/Warsaw");

        $array['mu'] = $_SESSION['user_id'] ?? 1;
        $array['cu'] = $_SESSION['user_id'] ?? 1;
        // $array['c'] = $_SESSION['c'];
        $array['de'] = date("Y-m-d H:i:s");
        $array['dm'] = date("Y-m-d H:i:s");
        $columns = [];
        $values = [];

        foreach ($array as $key => $value) {
            if ($key == "assigned" || $key == "user_id" || $key == "data") {
                $columns[] = "`" . $key . "`";
                $values[] = "'" . $value . "'";
            } else {
                // Assuming $this->pv handles escaping properly
                $columns[] = "`" . $key . "`";
                $values[] = "'" . $this->pv($value) . "'";
            }
        }

        if ($table && count($columns) > 0 && count($values) > 0) {
            $query = "INSERT INTO " . $table . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";
            $res = $this->query($query);

            if (!is_bool($res)) {
                mysqli_free_result($res);
            }
        }

        return $id;
    }
    function get($field, $table, $where)
    {
        $row = $this->row($this->query("select " . $field . " from " . $table . " where " . $where));
        return $row[$field];
    }
    function delete($table, $id)
    {
        return $this->query("delete from " . $table . " where id='" . $this->pv($id) . "'");
    }
    function pv($v)
    {
        $arr1 = array("'", '"');
        $arr2 = array("\'", '\"');
        return str_replace($arr1, $arr2, $v);
    }
}
