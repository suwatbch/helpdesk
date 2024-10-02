<?php
    include_once "model.class.php";
    include_once "sale.class.php";
    include_once "holiday.class.php";

    class activity_plan extends model {
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
                    . " FROM tb_activity_plan a"
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
            global $page_size, $db;

            $field = "*";
            $table = "tb_activity_plan as a"
                        . " left join tb_customer as c on a.customer_id=c.customer_id"
                        . " left join tb_project as p on a.project_id=p.project_id"
                        . " left join tb_objective as o on a.objective_id=o.objective_id"
                        . " left join tb_next_step as n on a.next_step_id=n.next_step_id";

            if (strUtil::isNotEmpty($cratiria["status_activity_plan"])){
                $condition .= "activity_plan_status = '{$cratiria["status_activity_plan"]}'";
                
            }

            if (strUtil::isNotEmpty($cratiria["sale_id"])){
                $condition .= " AND a.sale_id = '{$cratiria["sale_id"]}'";
            }

            if (strUtil::isNotEmpty($cratiria["start_date"]) && strUtil::isNotEmpty($cratiria["end_date"])){
                $condition .= " AND a.activity_plan_date BETWEEN '{$cratiria["start_date"]}' AND '{$cratiria["end_date"]}'";
            }

            if ($cratiria["for_manager"]){
                $condition .= " AND a.activity_plan_status IN ('ST', 'CP')";
            }

            $condition .= " ORDER BY a.activity_plan_date DESC, a.start_time DESC, a.created_date DESC";

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
            $table = "tb_activity_plan as a"
                        . " left join tb_customer as c on a.customer_id=c.customer_id"
                        . " left join tb_project as p on a.project_id=p.project_id"
                        . " left join tb_objective as o on a.objective_id=o.objective_id"
                        . " left join tb_next_step as n on a.next_step_id=n.next_step_id"
                        . " left join tb_sale as s on a.sale_id=s.sale_id";
            $condition = "activity_plan_status <> 'DE'";
            
            if (strUtil::isNotEmpty($cratiria["sale_id"])){
                $condition .= " AND a.sale_id = '{$cratiria["sale_id"]}'";
            }

            if (strUtil::isNotEmpty($cratiria["start_date"]) && strUtil::isNotEmpty($cratiria["end_date"])){
                $condition .= " AND a.activity_plan_date BETWEEN '{$cratiria["start_date"]}' AND '{$cratiria["end_date"]}'";
            }

            if ($cratiria["for_manager"]){
                $condition .= " AND a.activity_plan_status IN ('ST', 'CP')";
            }
            
            $condition .= " ORDER BY a.activity_plan_date ASC, a.start_time ASC, a.created_date ASC";
           
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
        
        public function search_report_total_time($cratiria){

            $field = "a.customer_id,a.project_id,a.activity_date,a.start_time,a.end_time,c.customer_name,p.project_name,o.objective_name,s.sale_first_name,s.sale_last_name";
            $table = "tb_activity_plan as a"
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
            
            if (strUtil::isNotEmpty($cratiria["customer_id"])){
                $condition .= " AND a.customer_id = '{$cratiria["customer_id"]}'";
            }
            
            if (strUtil::isNotEmpty($cratiria["project_id"])){
                $condition .= " AND a.project_id = '{$cratiria["project_id"]}'";
            }
            

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);
            
            return $activity_total_time = array(
                "total_time_row" => $rows
            );
        }
        
        public function getById_LastRow($cratiria){
            $field = "activity_id";
            $table = "tb_activity_plan ";
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
                      . ", IFNULL(vs2.sale_full_name, a.modified_by) AS modified_by"
                      . ", IFNULL(vs3.sale_full_name, a.modified_by) AS approve_by";
            $table = "tb_activity_plan a"
                       . " LEFT JOIN tb_customer c ON (a.customer_id = c.customer_id)"
                       . " LEFT JOIN tb_project p ON (a.project_id = p.project_id)"
                       . " LEFT JOIN tb_objective o ON (a.objective_id = o.objective_id)"
                       . " LEFT JOIN tb_next_step n ON (a.next_step_id = n.next_step_id)"
                       . " LEFT JOIN v_tb_sale vs1 ON (a.created_by = vs1.sale_id)"
                       . " LEFT JOIN v_tb_sale vs2 ON (a.modified_by = vs2.sale_id)"
                       . " LEFT JOIN v_tb_sale vs3 ON (a.approve_by = vs3.sale_id)";
            $condition = "a.activity_plan_id='$activity_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            $activity = $this->db->fetch_array($result);
			$activity["sale_approve"] = $this->getById_plan_approve($activity_id);
            return $activity;
        }
		
		public function getById_plan_approve($activity_plan_id){
            global $db, $activity_approve;
            $field = "s.sale_first_name";
            $table = "tb_activity_plan_approve a"
                    . " LEFT JOIN tb_sale s ON (a.sale_id = s.sale_id)";
            $condition = "a.activity_plan_id = '$activity_plan_id' ";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $sale_approve[] = $row;
            }

            return $sale_approve;
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
                     . " FROM tb_activity_plan a"
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
                     . "    FROM tb_activity_plan a"
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
                    . "    FROM tb_activity_plan a"
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
                    . "    FROM tb_activity_plan a"
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
                    . "    activity_plan_date, start_time, end_time"
                    . " FROM tb_activity_plan"
                    . " WHERE activity_plan_status <> 'DE'"
                    . " AND sale_id = '{$activity["sale_id"]}'"
                    . " AND activity_plan_date = '{$activity["activity_plan_date"]}'";

            if (strUtil::isNotEmpty($activity["activity_plan_id"])){
                $sql .= " AND activity_plan_id <> '{$activity["activity_plan_id"]}'";
            }

            $sql .= " ORDER BY start_time";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return false;

            list($start_time, $end_time) = $this->getActivityDateRange($activity["activity_plan_date"], $activity["start_time"], $activity["end_time"]);
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time);

            while($row = $this->db->fetch_array($result)){
                list($t1, $t2) = $this->getActivityDateRange($row["activity_plan_date"], $row["start_time"], $row["end_time"]);
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
            return $this->deleteWithUpdate("tb_activity_plan", "activity_plan_status", "DE", "activity_plan_id = '$activity_id'");
        }

        public function deleteByLeave($sale_id, $activity_date_st, $activity_date_ed, $leave_type){
            $sql = " UPDATE tb_activity_plan SET"
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
            $table = "tb_activity_plan";
            $field = "customer_id, project_id, sale_id, activity_plan_date, start_time, end_time"
                      . ", place, objective_id, next_step_id, contact_person, activity_plan"
                      . ", expenses, activity_plan_status, sent_date, leave_type"
                      . ", created_by, created_date, modified_by, modified_date";
            $data = "'{$activity["customer_id"]}', '{$activity["project_id"]}', '{$activity["sale_id"]}', '{$activity["activity_plan_date"]}', '{$activity["start_time"]}', '{$activity["end_time"]}'"
                       . ", '{$activity["place"]}', '{$activity["objective_id"]}', '{$activity["next_step_id"]}', '{$activity["contact_person"]}', '{$activity["activity_plan"]}'"
                       . ", '{$activity["expenses"]}', '{$activity["activity_plan_status"]}', '{$activity["sent_date"]}', '{$activity["leave_type"]}'"
                       . ", '{$activity["action_by"]}', '{$activity["action_date"]}', '{$activity["action_by"]}', '{$activity["action_date"]}'";

           $result = $this->db->insert($table, $field, $data);
           
            if($activity["activity_plan_status"] <> "SD" && $activity["activity_plan_status"] <> "CP" ){
               if ($result){
                $activity["activity_plan_id"] = $this->db->insert_id();
                $result = $this->insertMember($activity["activity_plan_id"], $activity["member"]);
               }
               
           }

           return $result;
        }
        
        public function insertMember($activity_plan_id, $member){
            $table = "tb_activity_plan_approve";
            $field = "activity_plan_id, sale_id";

            foreach ($member as $m) {
                $m = trim($m);
                if (strUtil::isEmpty($m)) continue;
                $data = "'$activity_plan_id', '$m'";
                $result = $this->db->insert($table, $field, $data);
                if(!$result) return false;
            }

            return true;
        }

        public function update($activity){
            $table = "tb_activity_plan";
            $data = "customer_id = '{$activity["customer_id"]}'"
                        . ", project_id = '{$activity["project_id"]}'"
                        . ", activity_plan_date = '{$activity["activity_plan_date"]}'"
                        . ", start_time = '{$activity["start_time"]}'"
                        . ", end_time = '{$activity["end_time"]}'"
                        . ", place = '{$activity["place"]}'"
                        . ", objective_id = '{$activity["objective_id"]}'"
                        . ", next_step_id = '{$activity["next_step_id"]}'"
                        . ", contact_person = '{$activity["contact_person"]}'"
                        . ", activity_plan = '{$activity["activity_plan"]}'"
                        . ", activity_plan_status = '{$activity["activity_plan_status"]}'"
                        . ", sent_date = '{$activity["sent_date"]}'"
                        . ", expenses = '{$activity["expenses"]}'"
                        . ", modified_by = '{$activity["action_by"]}'"
                        . ", modified_date = '{$activity["action_date"]}'"
						. ", approve_by = '{$activity["approve_by"]}'"
                        . ", approve_date = '{$activity["approve_date"]}'"
                        . ", reject_remark = '{$activity["reject_remark"]}'";
            $condition = "activity_plan_id = '{$activity["activity_plan_id"]}'";
            $result= $this->db->update($table, $data, $condition);
            
            if($activity["activity_plan_status"] <> "SD" && $activity["activity_plan_status"] <> "CP"){
                if ($result){
                    $this->db->delete("tb_activity_plan_approve", "activity_plan_id = '{$activity["activity_plan_id"]}'");
                    $result = $this->insertMember($activity["activity_plan_id"], $activity["member"]);
                }
            }

            return $result;
        }
        
        public function update_plan($activity){
            $table = "tb_activity_plan";
            $data = "activity_plan_status = '{$activity["activity_plan_status"]}'"
                        . ", modified_by = '{$activity["action_by"]}'"
                        . ", modified_date = '{$activity["action_date"]}'";


            foreach ($activity["activity_plan_id"] as $plan_id) {
                if (strUtil::isEmpty($plan_id)) continue;
                    $condition = "activity_plan_id = '$plan_id'";
                    $result= $this->db->update($table, $data, $condition);
                    if($result){
                        $this->db->delete("tb_activity_plan_approve", "activity_plan_id = '$plan_id'");
                        $result = $this->insertMember($plan_id, $activity["member"]);
                    }
                if(!$result) return false;
            }

            return true;
             
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
        
        public function search_owner($sale_id){
            $field = " s2.sale_id AS manager_id, s2.employee_code AS manager_code,s2.sale_first_name AS manager_first_name, s2.sale_last_name AS manager_last_name"
                        . ", p.position_name AS manager_position_name ";
            
            $table = " tb_sale s"
                        . " LEFT JOIN tb_sale s2 ON (s.manager_id = s2.sale_id)"
                        . " LEFT JOIN tb_position p ON (s2.position_id = p.position_id)";

            $condition = " (s.sale_status IS NULL OR s.sale_status <> 'D') AND s.type='USR' AND s.sale_id = '$sale_id' "
                        . " ORDER BY s2.sale_first_name ASC";
            
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $activity = array(
                "total_row" => $rows
                , "data" => $arr

            );
        }
		
		
	public function searchApprove($cratiria,$status, $page = 1){
            global $page_size;

            $field = "*";
            
            if ($status == "WP"){
                //wait for approve                
                $table = "tb_activity_plan as a"
                        . " inner join tb_activity_plan_approve as ap on ap.activity_plan_id = a.activity_plan_id"
                        . " inner join tb_project as p on a.project_id=p.project_id"
                        . " left join tb_customer as c on a.customer_id=c.customer_id"
                        . " left join tb_objective as o on a.objective_id=o.objective_id"
                        . " left join tb_next_step as n on a.next_step_id=n.next_step_id"
                        . " INNER JOIN tb_sale s ON s.sale_id = a.sale_id";
                            
              $condition = "activity_plan_status = 'WP'";  
              #only approver can view item
              if (strUtil::isNotEmpty($cratiria["appv_id"])){
                  $condition .= " AND ap.sale_id = '{$cratiria["appv_id"]}'";
              }
            }else if ($status == "CP" || $status == "RJ"){
                // approved
                $table = "tb_activity_plan as a"
                        . " inner join tb_project as p on a.project_id=p.project_id"
                        . " left join tb_customer as c on a.customer_id=c.customer_id"
                        . " left join tb_objective as o on a.objective_id=o.objective_id"
                        . " left join tb_next_step as n on a.next_step_id=n.next_step_id"
                        . " INNER JOIN tb_sale s ON s.sale_id = a.sale_id";
                            
              $condition = "activity_plan_status = '$status'"; 
              #only approver can view item
              if (strUtil::isNotEmpty($cratiria["appv_id"])){
                  $condition .= " AND a.approve_by = '{$cratiria["appv_id"]}'";
              }
            }
                
            
            if (strUtil::isNotEmpty($cratiria["project_id"])){
                $condition .= " AND a.project_id = '{$cratiria["project_id"]}'";
            }
            
            if (strUtil::isNotEmpty($cratiria["employee_id"])){
                $condition .= " AND a.sale_id = '{$cratiria["employee_id"]}'";
            }

            if (strUtil::isNotEmpty($cratiria["start_date"]) && strUtil::isNotEmpty($cratiria["end_date"])){
                $condition .= " AND a.activity_plan_date BETWEEN '{$cratiria["start_date"]}' AND '{$cratiria["end_date"]}'";
            }
                        
            if (strUtil::isNotEmpty($cratiria["sale_group_id"])){
                $condition .= " AND s.sale_group_id = '{$cratiria["sale_group_id"]}'";
            }
            
//            $condition .= " AND s.sale_group_id is not NULL";
            $condition .= "ORDER BY a.activity_plan_date, a.start_time , a.created_date";
            
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
        
    }//end class
?>