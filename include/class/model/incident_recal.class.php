<?php
include_once "model.class.php";
include_once "helpdesk_workinfo_period.class.php";

class incident_recal extends model { 

    public function recal(){

        $incidentlist = $this->get_incidents();

        if(count($incidentlist) > 0){
            $message = "Record count : ".count($incidentlist);
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else{
            $message = "No record --: ";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        $today = date("Y-m-d H:i:s");

        foreach($incidentlist as $row){ 
            $incident_id = $row["id"]; 
            $status_id = $row["status_id"];

            // $message = "incident id : ".$incident_id;
            // echo "<script type='text/javascript'>alert('$message');</script>";

            if($status_id >= 5){
                $assign_dt = $row["assigned_date"];
                $resolved_dt = $row["resolved_date"];

                // Get workinfo.
                $workinfo_list = $this->get_incidents_workInfo_byid($incident_id); 

                // Calcuate actual time.
                $objCalActual = new workinfo_period($db);
                // $actual_time =  $objCalActual->actual_working_hour(); 
                // $actual_time =  $objCalActual->actual_working_hour($incident,$w_info,$incident["assigned_date"],$today); 
                $actual_time =  $objCalActual->actual_working_hour($row,$workinfo_list,$row["create_date"],$row["resolved_date"]); 

                // Get statement update. 
                $set_actual_working_sec = " tot_actual_working_sec = '{$actual_time["tot_actual_working_sec"]}'";
                $set_actual_pending_sec = ", tot_actual_pending_sec = '{$actual_time["tot_actual_pending_sec"]}'";

                $set_tot_pending_res_wait_info = ", tot_pending_res_wait_info = '{$actual_time["tot_pending_res_wait_info"]}'";
                $set_tot_pending_res_wait_sap = ", tot_pending_res_wait_sap = '{$actual_time["tot_pending_res_wait_sap"]}'";
                $set_tot_pending_res_wait_dev = ", tot_pending_res_wait_dev = '{$actual_time["tot_pending_res_wait_dev"]}'";
                $set_tot_pending_res_wait_test = ", tot_pending_res_wait_test = '{$actual_time["tot_pending_res_wait_test"]}'";

                $table = "helpdesk_tr_incident";
                $data = $set_actual_working_sec.$set_actual_pending_sec.$set_tot_pending_res_wait_info
                .$set_tot_pending_res_wait_sap.$set_tot_pending_res_wait_dev.$set_tot_pending_res_wait_test ;
                $condition = " id = {$incident_id}";

                $result = $this->db->update($table, $data, $condition);
            }
        }
    }

    public function get_incidents(){

        $field = " * ";
        $table = " helpdesk_tr_incident ";
        $condition = " create_date >= '2024-05-28'";
        $order_by = " create_date";

        $result = $this->db->select($field, $table, $condition, $order_by);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();
        while($row = $this->db->fetch_array($result)){
            $incident[] = $row;
        }

        return $incident;
    }

    public function get_incidents_workInfo_byid($id){

        $field = " * ";
        $table = " helpdesk_tr_workinfo ";
        $condition = " incident_id = ".$id ;
        $order_by = " workinfo_id ";

        $result = $this->db->select($field, $table, $condition, $order_by);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();
        while($row = $this->db->fetch_array($result)){
            $workinfo[] = $row;
        }

        return $workinfo;
    }


}
?>