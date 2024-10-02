<?php
    include_once "model.class.php";

    class news extends model {

        public function getById($news_id){
            $sql = " SELECT"
                    . "    n.news_id, n.topic, n.content, n.start_date, n.end_date, n.status"
                    . "    , vs1.sale_full_name AS created_by, n.created_date"
                    . "    , vs2.sale_full_name AS modified_by, n.modified_date"
                    . " FROM tb_news n"
                    . " LEFT JOIN v_tb_sale vs1 ON (n.created_by = vs1.sale_id)"
                    . " LEFT JOIN v_tb_sale vs2 ON (n.modified_by = vs2.sale_id)"
                    . " WHERE news_id = '$news_id'";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            return $this->db->fetch_array($result);
        }

        public function search($criteria, $page = 1){
            global $page_size;

            $field = "news_id, topic, content, start_date, end_date";
            $table = " tb_news n";
            $condition = " n.status <> 'D'"
                              . " ORDER BY start_date DESC, end_date DESC, modified_date DESC";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return array(
                "total_row" => $total_row
                , "data" => $arr
            );
        }

        public function currentNews($news_date){
           $sql = " SELECT"
                   . "    n.news_id, n.topic, n.content, n.start_date, n.end_date, n.created_date, n.modified_date"
                   . " FROM tb_news n"
                   . " WHERE status = 'A'"
                   . " AND ((start_date = '' AND end_date = '')"
                   . " OR (start_date <= '$news_date' AND end_date >= '$news_date')"
                   . " OR (start_date <= '$news_date' AND end_date = '')"
                   . " OR (start_date = '' AND end_date >= '$news_date')"
                   . " )"
                   . " ORDER BY n.start_date DESC, n.modified_date DESC";

           $result = $this->db->query($sql);
           $rows = $this->db->num_rows($result);

           if ($rows == 0) return null;

           while($row = $this->db->fetch_array($result)){
               $arr[] = $row;
           }

           return $arr;
        }
        
        public function delete($news_id){
            return $this->deleteWithUpdate("tb_news", "status", "D", "news_id = '$news_id'");
        }

        public function insert(&$news){
            $sql = " INSERT INTO tb_news("
                    . "    topic, content, start_date, end_date, status"
                    . "    , created_by, created_date, modified_by, modified_date"
                    . " ) VALUES ("
                    . "    '{$news["topic"]}', '{$news["content"]}', '{$news["start_date"]}', '{$news["end_date"]}', '{$news["status"]}'"
                    . "    , '{$news["action_by"]}', '{$news["action_date"]}', '{$news["action_by"]}', '{$news["action_date"]}'"
                    . " )";

            $result = $this->db->query($sql);

            if ($result){
                $news["news_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($news){
            $sql = " UPDATE tb_news SET"
                    . "    topic = '{$news["topic"]}'"
                    . "    , content = '{$news["content"]}'"
                    . "    , start_date = '{$news["start_date"]}'"
                    . "    , end_date = '{$news["end_date"]}'"
                    . "    , status = '{$news["status"]}'"
                    . "    , modified_by = '{$news["action_by"]}'"
                    . "    , modified_date = '{$news["action_date"]}'"
                    . " WHERE news_id = '{$news["news_id"]}'";

            return $this->db->query($sql);
        }
    }
?>