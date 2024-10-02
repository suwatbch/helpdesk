<?php
 include_once "model.class.php";

  class incident_summary extends model {
      
      public function getOverdueInc($assignee_id){
          
//          SELECT * 
//FROM  `helpdesk_tr_incident` 
//WHERE  `assignee_id_last` =2
//AND status_id
//IN ( 2, 3 ) 
                  
      }
      
      
      
       public function getPendingInc($assignee_id){
           $countInc = 0;
          
           $sql = "SELECT COUNT( id ) AS countInc
            FROM  helpdesk_tr_incident
            WHERE  assignee_id_last = $assignee_id
            AND status_id IN ( 4 )"; //pending status
           $result = $this->db->query($sql);
           $rows = $this->db->num_rows($result);

           if ($rows == 0) return 0;
            
           while($row = $this->db->fetch_array($result)){
               $countInc = $row["countInc"];
            }

            return $countInc;
      }
      
  }
?>
