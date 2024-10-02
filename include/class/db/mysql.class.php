<?php
    class db {
        private $conn = null;
        private $server = null, $username = null, $password = null, $new_link = null, $client_flags = null, $database_name = null;
        
        public function __construct() {
            
        }

        public function connect($server = null, $username = null, $password = null, $new_link = null, $client_flags = null){
            $this->server = $server;
            $this->username = $username;
            $this->password = $password;
            $this->new_link = $new_link;
            $this->client_flags = $new_link;

            $this->conn = mysql_connect($this->server, $this->username, $this->password, $this->new_link, $this->client_flags);
            if (!$this->conn){
                //die('Could not connect: ' . mysql_error());
                error_handler_mysql("ไม่สามารถติดต่อ ฐานข้อมูลได้", $title="Data Base Connection");
            }

            return $this->conn;
        }

        public function reconnect(){
            $this->close();
            return $this->connect($this->server, $this->username, $this->password, $this->new_link, $this->client_flags);
        }

        public function close($link_identifier = null){
            if ($link_identifier == null){
                return mysql_close();
            } else {
                return mysql_close($link_identifier);
            }
        }

        public function begin_transaction(){
            mysql_query('begin');
        }

        public function end_transaction($result){
             if ($result){
                 mysql_query('commit');
             } else{
                 mysql_query('rollback');
             }
        }

        public function fetch_field($result, $i){
            return mysql_fetch_field($result,$i);
        }

        public function num_fields($result){
            return mysql_num_fields($result);
        }

        public function num_rows($result){
            return mysql_num_rows($result);
        }

        public function fetch_array($result){
            return mysql_fetch_array($result);
        }

        public function query($sql){
            $result = mysql_query($sql);
            if (!$result){
                error_handler_mysql($sql);
            }

            return $result;
        }

        public function select_db($database_name, $link_identifier = null){
            $this->database_name = $database_name;
            $result = mysql_select_db($this->database_name, $link_identifier);
            $this->query("SET NAMES 'UTF8'");
            return $result;
        }
		
        public function insert_id($link_identifier = null){
            if ($link_identifier == null) {
                return mysql_insert_id();
            }

            return mysql_insert_id($link_identifier);
        }

        public function ping($link_identifier = null){
            if ($link_identifier == null) {
                return mysql_ping();
            }

            return mysql_ping($link_identifier);
        }


        public function insert($table, $field, $data) {
            $sql = "INSERT INTO $table ($field) VALUES ($data)";
            return $this->query($sql);
        }

        public function update($table, $data, $condition) {
            $sql = "UPDATE $table SET $data WHERE $condition";
            return $this->query($sql);
        }

        public function delete($table, $condition = "") {
            $sql = "DELETE FROM  $table";

            if ($condition != ""){
                $sql .= " WHERE ".$condition;
            }

            return $this->query($sql);
        }

        public function select($field, $table, $condition="", $order_by="") {
            $sql = "SELECT ".$field." FROM ".$table;
            if ($condition !=""){
                $sql .= " WHERE ".$condition;
            }

            if ($order_by !=""){
                $sql .= " ORDER BY ".$order_by;
            }
            
            return $this->query($sql);
        }

        public function insert_from_table($table, $field, $data) {
            $sql = "INSERT INTO ".$table." (".$field.")(".$data.")";
            return $this->query($sql);
        }

        public function gen_id($table, $field, $prefix, $idlength) {
            $sql="SELECT ".$field." FROM ".$table." ORDER BY ".$field." ASC";
            $data = $this->query($sql);

            $num_rows = $this->num_rows($data);
            if ($num_rows == 0){
                for($i=1; $i<$idlength; $i++){
                    $idstart = $idstart."0";
                }
                
                $id=$idstart."1";
            } else {
                $id=$num_rows+1;
                $id=sprintf("%0".$idlength."d",$id);
            }
            return $prefix.$id;
        }

        public function count_rows($table, $condition = "") {
            $sql="SELECT * FROM ".$table;

            if ($condition != "") {
                $sql .= " WHERE ".$condition;
            }

            $data = $this->query($sql);
            return $this->num_rows($data);
        }

        public function  get_number_range($prefix){
            $sql="SELECT current_number FROM tb_number_range WHERE prefix='$prefix' FOR UPDATE";
            $data = $this->query($sql);

            $row= $this->fetch_array($data);
            $number = $row["current_number"] + 1;

            $sql = "UPDATE tb_number_range SET current_number=$number WHERE prefix='$prefix'";
            $this->query($sql);

            return $row["current_number"];
        }

        public function select_data_page($field,$table,$condition,$page,$page_size) {
            if($page <=1){
                $start = 0;
            } else {
                $start = ($page_size*$page) - $page_size;
            }

           $sql = "SELECT $field FROM $table";
            if ($condition != ""){
                $sql .= " WHERE ".$condition;
            }

            $sql .= " LIMIT $start, $page_size";
            
            $this->query('SET character_set_results=utf8');
            $result = $this->query($sql);

            return $result;
        }
    }
?>