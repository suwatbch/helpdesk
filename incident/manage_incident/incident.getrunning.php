<?php
    //function incident_getrunning($incidentID="",$ident_id_run_project="",$IncidentRunProject="",$IncidentRunDigit="",$IncidentPrefix=""){
    function incident_getrunning($incidentID="",$ident_id_run_project=""){
      	$IncidentRunProject = user_session::get_user_IncidentRunProject($IncidentRunProject); 
		$IncidentRunDigit = user_session::get_user_IncidentRunDigit($IncidentRunDigit); 
		$IncidentPrefix = user_session::get_user_IncidentPrefix($IncidentPrefix);
	 	#Show Incident Running Number
		if($incidentID){ 
			if($IncidentRunProject == "Y"){ //มีการกำหนดให้ incident running by project code
				$incident_run = $ident_id_run_project; 
			}else{
				$incident_run = $IncidentPrefix.sprintf("%0".$IncidentRunDigit."d",$incidentID);
			}
		}else{	return flase; }
		
		return $incident_run;
    }
	
	
?>
