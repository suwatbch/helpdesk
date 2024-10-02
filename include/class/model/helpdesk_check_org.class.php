<? 
include_once "model.class.php";

class Check_helpdesk_org extends model {
        public function check_org($user){
            //select group id
            $field = "org_code";
            $table = "helpdesk_org";
            $condition = "org_id = '{$user["group_id"]}' ";
            $result = $this->db->select($field, $table, $condition);
            $fe_grp = $this->db->fetch_array($result);
            $ss_grp_id = substr($fe_grp["org_code"],-2,2);
            
            //select org id
            $field = "org_code";
            $table = "helpdesk_org";
            $condition = "org_id = '{$user["org_id"]}' ";
            $result = $this->db->select($field, $table, $condition);
            $fe_org_id = $this->db->fetch_array($result);
            $ss_org_id = $fe_org_id["org_code"];
            
            //select subgrp id
            $field = "org_code";
            $table = "helpdesk_org";
            $condition = "org_id = '{$user["subgrp_id"]}' ";
            $result = $this->db->select($field, $table, $condition);
            $fe_subgrp = $this->db->fetch_array($result);
            $ss_subgrp_id = substr($fe_subgrp["org_code"],-2);
            
    
            
            
            $ss_org_code = $ss_org_id."".$ss_grp_id."".$ss_subgrp_id;
            //select org id
            $field = "org_id";
            $table = "helpdesk_org";
            $condition = "org_code = '{$ss_org_code}' ";
            $result = $this->db->select($field, $table, $condition);
            $fe_org = $this->db->fetch_array($result);
            $ss_org_id = $fe_org["org_id"];
            
            return $ss_org_id;
        }
        
        public function check_org_id($s_org_id){
            //select org code
            //$s_org_id = $user["org_id"];
            
            $field = "org_code,org_comp";
            $table = "helpdesk_org";
            $condition = "org_id= '$s_org_id' ";
            $result = $this->db->select($field, $table, $condition);
            $f_org_code = $this->db->fetch_array($result);
            $s_org_code_org = substr($f_org_code["org_code"],0,2);
            $s_org_code_grp = substr($f_org_code["org_code"],0,4);
            $s_org_code_subgrp = substr($f_org_code["org_code"],0,6);
            $s_org_comp = $f_org_code["org_comp"];
            
            
            $field ="org_id,org_name";
            $table = "helpdesk_org";
            $condition = "org_code='$s_org_code_org' AND org_comp = '$s_org_comp' ";
            $result = $this->db->select($field, $table, $condition);
            $f_org_user = $this->db->fetch_array($result);
            $user["s_org_user_id"] = $f_org_user["org_id"];
            $user["s_org_user_name"] = $f_org_user["org_name"];
            
            $field ="org_id,org_name";
            $table = "helpdesk_org";
            $condition = "org_code='$s_org_code_grp' AND org_comp = '$s_org_comp'";
            $result = $this->db->select($field, $table, $condition);
            $f_org_user = $this->db->fetch_array($result);
            $user["s_grp_user_id"] = $f_org_user["org_id"];
            $user["s_grp_user_name"] = $f_org_user["org_name"];
            
            return $user;
        }
        
}