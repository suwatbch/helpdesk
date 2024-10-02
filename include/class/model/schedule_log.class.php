<?php
    include_once "model.class.php";
    include_once dirname(dirname(__FILE__))."/util/strUtil.class.php";

    class schedule_log extends model {

        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "log_id, type, start_date_time, end_date_time, message, error";

            # table
            $table = " tb_schedule_log";

            # condition
            $condition = " 1 = 1";
            if (strUtil::isNotEmpty($cratiria["type"])){
                $condition .= " AND type = '{$cratiria["type"]}'";
            }

            if (strUtil::isNotEmpty($cratiria["start_date"])){
                $condition .= " AND SUBSTR(start_date_time, 1, 8) >= '{$cratiria["start_date"]}'";
            }

            if (strUtil::isNotEmpty($cratiria["end_date"])){
                $condition .= " AND SUBSTR(start_date_time, 1, 8) <= '{$cratiria["end_date"]}'";
            }

            $condition .= " ORDER BY log_id DESC";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $data[] = $row;
            }

            return array(
                "total_row" => $total_row
                , "data" => $data
            );
        }

        public function getById($log_id){
            $sql = " SELECT"
                    . "    log_id, type, start_date_time, end_date_time, message, error"
                    . " FROM tb_schedule_log"
                    . " WHERE log_id = '$log_id'";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);
            if ($rows == 0) return null;

            return $this->db->fetch_array($result);
        }
    }
?>
