<?php
    include_once "model.class.php";
    include_once "sale.class.php";
    include_once "holiday.class.php";

    class activity extends model {
        public $leave_type = array(
            "A1" => "ลากิจ"
            ,"C1" => "ลาพักร้อน"
            , "S1" => "ลาป่วย"
            , "E1" => "ลาอุปสมบท"
            , "D1" => "ลาคลอด"
            , "F1" => "ลาทำหมัน"
            , "H1" => "ลารับราชการทหาร"
            , "R1" => "การปฏิบัติงานนอกสถานที่"
            , "T1" => "การฝึกอบรมพัฒนา"
            , "J1" => "ลาอื่นๆ"
        );

        public function searchSaleReportByTree($manager_id, $activity_date_st, $activity_date_ed){
            $sql =  " SELECT"
                     . "    vs.sale_id, vs.employee_code, vs.sale_full_name AS sale_name, p.position_name"
                     . " FROM v_tb_sale vs"
                     . " INNER JOIN tb_position p ON (vs.position_id = p.position_id)"
                     . " WHERE vs.sale_status = 'A'"
                     . " AND vs.manager_id = '$manager_id'"
                     . " ORDER BY vs.employee_code";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $sale_id = $row["sale_id"];
                 list($total, $send, $row["missed"], $row["late"], $row["missed_percent"], $row["late_percent"]) = $this->getActivityStatus($sale_id, $activity_date_st, $activity_date_ed);

                $member = $this->searchSaleReportByTree($sale_id, $activity_date_st, $activity_date_ed);
                if (count($member) > 0){
                    $row["member"] = $member;
                }

                $arr[] = $row;
            }

            return $arr;
        }

        public function searchSaleReport($manager_id, $activity_date_st, $activity_date_ed, $page = 1){
            global $page_size;

            $field = " s.sale_id, s.employee_code, s.sale_first_name, s.sale_last_name, s.position_id, p.position_name, s.telephone, s.mobile, t.cnt";
            $table = " tb_sale s"
                        . " INNER JOIN tb_position p ON (s.position_id = p.position_id)"
                        . " LEFT JOIN (SELECT manager_id AS sale_id, count(*) AS cnt FROM tb_sale GROUP BY manager_id) t ON (s.sale_id = t.sale_id)";
            $condition = " s.sale_status = 'A' AND s.manager_id='$manager_id'"
                              . " ORDER BY s.employee_code";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                list($total, $send, $row["missed"], $row["late"], $row["missed_percent"], $row["late_percent"]) = $this->getActivityStatus($row["sale_id"], $activity_date_st, $activity_date_ed);
                $arr[] = $row;
            }

            return array(
                "total_row" => $total_row
                , "data" => $arr
            );
        }

        public function getActivityStatus($sale_id, $activity_date_st, $activity_date_ed){
            $sql = " SELECT"
                    . "    count(*) AS total"
                    . "    , SUM(CASE WHEN a.activity_date IS NOT NULL THEN 1 ELSE 0 END) send"
                    . "    , SUM(CASE WHEN a.activity_date IS NULL THEN 1 ELSE 0 END) missed"
                    . "    , SUM(CASE WHEN a.late > 0 THEN 1 ELSE 0 END) late"
                    . " FROM"
                    . " ("
                    . "   SELECT"
                    . "    a.sale_id, activity_date"
                    . "    , COUNT(*) AS count"
                    . "    , SUM(CASE WHEN activity_date >= SUBSTRING(a.sent_date, 1, 8) THEN 1 ELSE 0 END) AS duly"
                    . "    , SUM(CASE WHEN activity_date < SUBSTRING(a.sent_date, 1, 8) THEN"
                    . "                  CASE WHEN DATEDIFF(SUBSTRING(a.sent_date, 1, 8), activity_date) = 1 AND SUBSTRING(a.sent_date, 9, 2) < '09' THEN 0 ELSE 1 END"
                    . "               ELSE 0 END) AS late"
                    . " FROM tb_activity a"
                    . " WHERE a.activity_status IN ('ST', 'CP')"
                    . " AND a.sale_id = $sale_id"
                    . " GROUP BY activity_date"
                    . " ) a"
                    . " RIGHT JOIN"
                    . " (";

            $holiday = new holiday($this->db);

            $tbl_date = "";
            while($activity_date_st <= $activity_date_ed) {
                if (!$holiday->isHoliday($activity_date_st)){
                    $tbl_date .= (strUtil::isNotEmpty($tbl_date) ? " UNION " : "")." SELECT $activity_date_st".(strUtil::isEmpty($tbl_date) ? " AS d" : "");
                }

                $activity_date_st =  date("Ymd", strtotime("$activity_date_st +1day"));
            }

            $sql .= $tbl_date;
            $sql .= " ) t ON (a.activity_date = t.d)";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            $row = $this->db->fetch_array($result);

            return array(
                (int)$row["total"]
                , (int)$row["send"]
                , (int)$row["missed"]
                , (int)$row["late"]
                , $row["missed"] / $row["total"] * 100
                , $row["late"] / $row["total"] * 100
            );
        }

        public function search($cratiria, $page = 1){
            global $page_size;

            $field = "*";
            $table = "tb_activity as a"
                        . " left join tb_customer as c on a.customer_id=c.customer_id"
                        . " left join tb_project as p on a.project_id=p.project_id"
                        . " left join tb_objective as o on a.objective_id=o.objective_id"
                        . " left join tb_next_step as n on a.next_step_id=n.next_step_id";
            $condition = "activity_status <> 'DE'";

            if (strUtil::isNotEmpty($cratiria["sale_id"])){
                $condition .= " AND a.sale_id = '{$cratiria["sale_id"]}'";
            }

            if (strUtil::isNotEmpty($cratiria["start_date"]) && strUtil::isNotEmpty($cratiria["end_date"])){
                $condition .= " AND a.activity_date BETWEEN '{$cratiria["start_date"]}' AND '{$cratiria["end_date"]}'";
            }

            if ($cratiria["for_manager"]){
                $condition .= " AND a.activity_status IN ('ST', 'CP')";
            }

            $condition .= " ORDER BY a.activity_date DESC, a.start_time DESC, a.created_date DESC";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $activity = array(
                "total_row" => $total_row
                , "data" => $arr
            );
        }
        
        public function search_report($cratiria){

            $field = "*";
            $table = "tb_activity as a"
                        . " left join tb_customer as c on a.customer_id=c.customer_id"
                        . " left join tb_project as p on a.project_id=p.project_id"
                        . " left join tb_objective as o on a.objective_id=o.objective_id"
                        . " left join tb_next_step as n on a.next_step_id=n.next_step_id"
                        . " left join tb_sale as s on a.sale_id=s.sale_id";
            $condition = "activity_status <> 'DE'";
            
            if (strUtil::isNotEmpty($cratiria["sale_id"])){
                $condition .= " AND a.sale_id = '{$cratiria["sale_id"]}'";
            }

            if (strUtil::isNotEmpty($cratiria["start_date"]) && strUtil::isNotEmpty($cratiria["end_date"])){
                $condition .= " AND a.activity_date BETWEEN '{$cratiria["start_date"]}' AND '{$cratiria["end_date"]}'";
            }

            if ($cratiria["for_manager"]){
                $condition .= " AND a.activity_status IN ('ST', 'CP')";
            }
            
            $condition .= " ORDER BY a.activity_date ASC, a.start_time ASC, a.created_date ASC";
            
            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $activity = array(
                "total_row" => $total_row
                , "data" => $arr

            );
        }
        
        public function getById_LastRow($cratiria){
            $field = "activity_id";
            $table = "tb_activity ";
            $condition = "activity_status <> 'DE'";
            
            if (strUtil::isNotEmpty($cratiria["sale_id"])){
                $condition .= " AND a.sale_id = '{$cratiria["sale_id"]}'";
            }

            if (strUtil::isNotEmpty($cratiria["start_date"]) && strUtil::isNotEmpty($cratiria["end_date"])){
                $condition .= " AND a.activity_date BETWEEN '{$cratiria["start_date"]}' AND '{$cratiria["end_date"]}'";
            }

            if ($cratiria["for_manager"]){
                $condition .= " AND a.activity_status IN ('ST', 'CP')";
            }
            
            if($cratiria["status_none"]!="none"){
            $condition .= " AND (a.customer_id <> '0' AND a.project_id <> '1') ORDER BY c.customer_name asc,p.project_name asc ";
            }
            
            if($cratiria["status_none"]=="none"){
            $condition .= " AND (a.customer_id = '0' OR a.project_id = '1') ORDER BY c.customer_id desc ";
            }
            $condition = " limit 0,1";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            $activity_id = $this->db->fetch_array($result);
            return $activity_id;
            
        }

        public function getById($activity_id){
            $field = "a.*, c.customer_name, p.project_name, o.objective_name, n.next_step_name"
                      . ", IFNULL(vs1.sale_full_name, a.created_by) AS created_by"
                      . ", IFNULL(vs2.sale_full_name, a.modified_by) AS modified_by";
            $table = "tb_activity a"
                       . " LEFT JOIN tb_customer c ON (a.customer_id = c.customer_id)"
                       . " LEFT JOIN tb_project p ON (a.project_id = p.project_id)"
                       . " LEFT JOIN tb_objective o ON (a.objective_id = o.objective_id)"
                       . " LEFT JOIN tb_next_step n ON (a.next_step_id = n.next_step_id)"
                       . " LEFT JOIN v_tb_sale vs1 ON (a.created_by = vs1.sale_id)"
                       . " LEFT JOIN v_tb_sale vs2 ON (a.modified_by = vs2.sale_id)";
            $condition = "a.activity_id='$activity_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            $activity = $this->db->fetch_array($result);
            return $activity;
        }

        public function exportForSale($activity_date_st, $activity_date_ed, $sale_id){
            $sale = new sale($this->db);
            $sale = $sale->getById($sale_id);
            if (count($sale) == 0){
                return null;
            }

            $rpt["sale_name"] = $sale["sale_first_name"]." ".$sale["sale_last_name"];
            $rpt["manager_name"] = $sale["manager_name"];
            $rpt["position_name"] = $sale["position_name"];
            $rpt["sale_group_id"] = $sale["sale_group_id"];
            $rpt["activity_date_st"] = $activity_date_st;
            $rpt["activity_date_ed"] = $activity_date_ed;

            # activity
            $sql = " SELECT"
                     . "    a.sale_id, a.activity_date, c.customer_name, p.project_name, o.objective_name, a.activity, a.expenses"
                     . "    , a.start_time, a.end_time, a.duration_time, a.unit_of_time"
                     . " FROM tb_activity a"
                     . " INNER JOIN tb_customer c ON (a.customer_id = c.customer_id)"
                     . " INNER JOIN tb_project p ON (a.project_id = p.project_id)"
                     . " INNER JOIN tb_objective o ON (a.objective_id = o.objective_id)"
                     . " WHERE a.activity_status IN ('ST', 'CP')"
                     . " AND a.sale_id = '$sale_id'"
                     . " AND a.activity_date BETWEEN  '$activity_date_st' AND '$activity_date_ed'"
                     . " ORDER BY a.activity_date, a.start_time, c.customer_name, p.project_name, o.objective_name";
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($sale["email_notify"] == "N" && $rows == 0){
                return null;
            }
            
            if ($rows > 0){
                $index = 1;
                while ($row = $this->db->fetch_array($result)){
                    $duration = "";
                    if (strUtil::isNotEmpty($row["start_time"]) && strUtil::isNotEmpty($row["end_time"])){
                        list($d1, $d2) = $this->getActivityDateRange($row["activity_date"], $row["start_time"], $row["end_time"]);
                        
                        $diff = dateUtil::dateDiff($d1, $d2, dateUtil::DIFF_IN_MINUTES);
                        $h = floor($diff / 60);
                        $m = $diff % 60;

                        if ($h > 0) $duration .= "$h Hrs. ";
                        if ($m > 0) $duration .= "$m Min.";
                        if ($duration != "") $duration = "(".trim($duration).")";

                        $duration = $row["start_time"]."-".$row["end_time"]." ".$duration;
                    } elseif((int)$row["duration_time"] != 0) {
                        $duration = number_format($row["duration_time"], 2)." ".$row["unit_of_time"];
                    }

                    $rpt["activity"][] = array(
                        $index++
                        , $row["activity_date"]
                        , $row["customer_name"]
                        , $row["project_name"]
                        , $row["objective_name"]
                        , $row["activity"]
                        , $duration
                    );
                }
            }

            return $rpt;
        }

        public function exportForManager($activity_date_st, $activity_date_ed, $manager_id){
            # for manager
            if (strUtil::isNotEmpty($manager_id)){
                $sql = "SELECT sale_id FROM tb_sale WHERE manager_id = '$manager_id' ORDER BY employee_code";
                $result = $this->db->query($sql);
                $rows = $this->db->num_rows($result);
                if ($rows > 0){
                    while ($row = $this->db->fetch_array($result)){
                        $act = $this->exportForSale($activity_date_st, $activity_date_ed, $row["sale_id"]);

                        if (count($act) > 0){
                            $ret[] = $act;
                        }

                        $act = $this->exportForManager($activity_date_st, $activity_date_ed, $row["sale_id"]);
                        if (count($act) > 0){
                            foreach ($act as $value) {
                                $ret[] = $value;
                            }
                        }
                    }
                }
            }

            return $ret;
        }

        public function sumByObjective($activity_date_st, $activity_date_ed, $sale_group_id = ""){
            $sql = " SELECT"
                     . "   o.objective_name, t.cnt"
                     . " FROM tb_objective o"
                     . " LEFT JOIN ("
                     . "    SELECT"
                     . "       o.objective_id, count(a.activity_id) AS cnt"
                     . "    FROM tb_activity a"
                     . "    INNER JOIN tb_objective o ON (a.objective_id = o.objective_id)"
                     . "    INNER JOIN tb_sale s ON (a.sale_id = s.sale_id)"
                     . "    WHERE a.activity_status IN ('ST', 'CP')"
                     . "    AND a.activity_date BETWEEN '$activity_date_st' AND '$activity_date_ed'";

            if (strUtil::isNotEmpty($sale_group_id)){
                $sql .= "    AND s.sale_group_id = '$sale_group_id'";
            }

            $sql .= "    GROUP BY o.objective_id"
                     . " ) t ON o.objective_id = t.objective_id"
                     . " WHERE o.objective_status = 'A'"
                     . " ORDER BY cnt";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
               $arr[] = $row;
            }

            return $arr;
        }

        public function sumByNextStep($activity_date_st, $activity_date_ed, $sale_group_id = ""){
            $sql = " SELECT "
                    . "    n.next_step_name, t.cnt"
                    . " FROM tb_next_step n"
                    . " LEFT JOIN ("
                    . "    SELECT"
                    . "       n.next_step_id, count(a.activity_id) AS cnt "
                    . "    FROM tb_activity a"
                    . "    INNER JOIN tb_next_step n ON (a.next_step_id = n.next_step_id)"
                    . "    INNER JOIN tb_sale s ON (a.sale_id = s.sale_id)"
                    . "    WHERE a.activity_status IN ('ST', 'CP')"
                    . "    AND a.activity_date BETWEEN '$activity_date_st' AND '$activity_date_ed'";

            if (strUtil::isNotEmpty($sale_group_id)){
                $sql .= "    AND s.sale_group_id = '$sale_group_id'";
            }

            $sql .= "    GROUP BY n.next_step_id"
                     . " ) t ON n.next_step_id = t.next_step_id"
                     . " WHERE n.next_step_status = 'A'"
                     . " ORDER BY cnt";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
               $arr[] = $row;
            }

            return $arr;
        }

        public function sumByCustomerGroup($activity_date_st, $activity_date_ed, $sale_group_id = ""){
            $sql = " SELECT"
                    . "    g.customer_group_name, t.cnt"
                    . " FROM tb_customer_group g"
                    . " LEFT JOIN ("
                    . "    SELECT"
                    . "       c.customer_group_id, count(a.activity_id) AS cnt"
                    . "    FROM tb_activity a"
                    . "    INNER JOIN tb_customer c ON (a.customer_id = c.customer_id)"
                    . "    INNER JOIN tb_sale s ON (a.sale_id = s.sale_id)"
                    . "    WHERE a.activity_status IN ('ST', 'CP')"
                    . "    AND a.activity_date BETWEEN '$activity_date_st' AND '$activity_date_ed'";

            if (strUtil::isNotEmpty($sale_group_id)){
                $sql .= "    AND s.sale_group_id = '$sale_group_id'";
            }

            $sql .= "    GROUP BY c.customer_group_id"
                     . " ) t ON g.customer_group_id = t.customer_group_id"
                     . " WHERE g.customer_group_status = 'A'"
                     . " ORDER BY cnt";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
               $arr[] = $row;
            }

            return $arr;
        }

        public function isDuplicate($activity){
            $sql = " SELECT"
                    . "    activity_date, start_time, end_time"
                    . " FROM tb_activity"
                    . " WHERE activity_status <> 'DE'"
                    . " AND sale_id = '{$activity["sale_id"]}'"
                    . " AND activity_date = '{$activity["activity_date"]}'";

            if (strUtil::isNotEmpty($activity["activity_id"])){
                $sql .= " AND activity_id <> '{$activity["activity_id"]}'";
            }

            $sql .= " ORDER BY start_time";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return false;

            list($start_time, $end_time) = $this->getActivityDateRange($activity["activity_date"], $activity["start_time"], $activity["end_time"]);
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time);

            while($row = $this->db->fetch_array($result)){
                list($t1, $t2) = $this->getActivityDateRange($row["activity_date"], $row["start_time"], $row["end_time"]);
                $t1 = strtotime($t1);
                $t2 = strtotime($t2);

                if ($start_time == $t1 && $end_time == $t2) return true;
                if ($start_time < $t1 && $end_time > $t2) return true;
                if ($start_time < $t2 && $end_time > $t2) return true;
                if ($start_time < $t1 && $end_time > $t1) return true;
                if (($start_time > $t1 && $start_time < $t2) || ($end_time > $t1 && $end_time < $t2)) return true;
            }

            return false;
        }

        public function delete($activity_id){
            return $this->deleteWithUpdate("tb_activity", "activity_status", "DE", "activity_id = '$activity_id'");
        }

        public function deleteByLeave($sale_id, $activity_date_st, $activity_date_ed, $leave_type){
            $sql = " UPDATE tb_activity SET"
                    . "    activity_status = 'DE'"
                    . "    , modified_by = 'ENGINE'"
                    . "    , modified_date = '".date("YmdHis")."'"
                    . " WHERE activity_status <> 'CP'"
                    . " AND sale_id = '$sale_id'"
                    . " AND leave_type = '$leave_type'"
                    . " AND activity_date BETWEEN '$activity_date_st' AND '$activity_date_ed'";
            return $this->db->query($sql);
        }

        public function insert(&$activity){
            $table = "tb_activity";
            $field = "customer_id, project_id, sale_id, activity_date, start_time, end_time"
                      . ", place, objective_id, next_step_id, contact_person, activity"
                      . ", expenses, activity_status, sent_date, leave_type"
                      . ", created_by, created_date, modified_by, modified_date, activity_type, activity_plan_id";
            $data = "'{$activity["customer_id"]}', '{$activity["project_id"]}', '{$activity["sale_id"]}', '{$activity["activity_date"]}', '{$activity["start_time"]}', '{$activity["end_time"]}'"
                       . ", '{$activity["place"]}', '{$activity["objective_id"]}', '{$activity["next_step_id"]}', '{$activity["contact_person"]}', '{$activity["activity"]}'"
                       . ", '{$activity["expenses"]}', '{$activity["activity_status"]}', '{$activity["sent_date"]}', '{$activity["leave_type"]}'"
                       . ", '{$activity["action_by"]}', '{$activity["action_date"]}', '{$activity["action_by"]}', '{$activity["action_date"]}', '{$activity["activity_type"]}', '{$activity["activity_plan_id"]}'";

           $result = $this->db->insert($table, $field, $data);

            if ($result){
                $activity["activity_id"] = $this->db->insert_id();
           }

           return $result;
        }

        public function update($activity){
            $table = "tb_activity";
            $data = "customer_id = '{$activity["customer_id"]}'"
                        . ", project_id = '{$activity["project_id"]}'"
                        . ", activity_date = '{$activity["activity_date"]}'"
                        . ", start_time = '{$activity["start_time"]}'"
                        . ", end_time = '{$activity["end_time"]}'"
                        . ", place = '{$activity["place"]}'"
                        . ", objective_id = '{$activity["objective_id"]}'"
                        . ", next_step_id = '{$activity["next_step_id"]}'"
                        . ", contact_person = '{$activity["contact_person"]}'"
                        . ", activity = '{$activity["activity"]}'"
                        . ", activity_status = '{$activity["activity_status"]}'"
                        . ", sent_date = '{$activity["sent_date"]}'"
                        . ", expenses = '{$activity["expenses"]}'"
                        . ", modified_by = '{$activity["action_by"]}'"
                        . ", modified_date = '{$activity["action_date"]}'";
            $condition = "activity_id = '{$activity["activity_id"]}'";
            return $this->db->update($table, $data, $condition);
        }

        private function getActivityDateRange($activity_date, $start_time, $end_date){
            $start_time = explode(":", $start_time);
            $end_date = explode(":", $end_date);

            $d1 = $activity_date.str_pad($start_time[0], 2, STR_PAD_RIGHT).str_pad($start_time[1], 2, STR_PAD_RIGHT);

            if ($end_date[0] < 24){
                $d2 = $activity_date.str_pad($end_date[0], 2, STR_PAD_RIGHT).str_pad($end_date[1], 2, STR_PAD_RIGHT);
            } else {
                $d2 = date("Ymd", strtotime("$activity_date +1 day"))."0000";
            }

            return array($d1, $d2);
        }
        
    }//end class
?>