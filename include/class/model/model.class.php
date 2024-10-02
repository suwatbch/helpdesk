<?php
    class model{
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function deleteWithUpdate($table, $field, $value = "", $condition = ""){
            $sql = " UPDATE $table SET $field = '$value', modified_by = '{$_SESSION["_USER_ID"]}', modified_date = '".date("YmdHis")."'";
            if ($condition != ""){
                $sql .= " WHERE $condition";
            }

            return $this->db->query($sql);
        }
        
        public function deleteWithoutUpdate($table, $condition = ""){
            $sql = " Delete From $table ";
            if ($condition != ""){
                $sql .= " WHERE $condition";
            }

            return $this->db->query($sql);
        }
    }
?>