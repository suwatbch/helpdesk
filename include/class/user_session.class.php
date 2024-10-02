<?php
    class user_session{
        const LOG_ID = "_LOG_ID";
        const USER_LOGIN = "_USER_LOGIN";
        const USER_NAME = "_USER_NAME";
        const USER_EMAIL = "_USER_EMAIL";
        const EMPLOYEE_CODE = "_EMPLOYEE_CODE";
        const SALE_ID = "_SALE_ID";
        const SALE_GROUP_ID = "_SALE_GROUP_ID";
        const SALE_GROUP_NAME = "_SALE_GROUP_NAME"; 
		
		#helpdesk
        const USER_COMPANY_ID = "_USER_COMPANY_ID";
        const USER_COMPANY_NAME = "_USER_COMPANY_NAME";
        const USER_ID = "_USER_ID";
		const USER_CODE = "_USER_CODE";
        const USER_ORG_ID = "_USER_ORG_ID";
        const USER_ORG_NAME = "_USER_ORG_NAME";
        const USER_MY_ORGCODE = "_USER_MY_ORGCODE";
        const USER_MY_GRPCODE = "_USER_MY_GRPCODE";
        const USER_GRP_ID = "_USER_GRP_ID";
        const USER_GRP_NAME = "_USER_GRP_NAME";
        const USER_SUBGRP_ID = "_USER_SUBGRP_ID";
        const USER_SUBGRP_NAME = "_USER_SUBGRP_NAME";
		const USER_ADMIN = "_USER_ADMIN";
		const USER_TRAN_INC_PER = "_USER_TRAN_INC_PER";
		const USER_ADMIN_PER = "_USER_ADMIN_PER";
		//const USER_MONTHLY_RPT_PER = "_USER_MONTHLY_RPT_PER";
        const USER_EDIT_RPT_PER = "_USER_EDIT_RPT_PER";
        const USER_APPV_RPT_PER = "_USER_APPV_RPT_PER";
		const USER_ADVS_PER = "_USER_ADVS_PER";
		
		const USER_IDENT_RUN_PROJECT = "_USER_IDENT_RUN_PROJECT";
		const USER_IDENT_RUN_DIGIT = "_USER_IDENT_RUN_DIGIT";
		const USER_IDENT_PREFIX = "_USER_IDENT_PREFIX";
		
		const USER_EMAIL_ADMIN = "_USER_EMAIL_ADMIN";
		const USER_SUBGRP_ID_SPEC = "_USER_SUBGRP_ID_SPEC";
        const FIRST_NAME = "_FIRST_NAME";
        const LAST_NAME = "_LAST_NAME";

		const CUS_COMPANY_ID = "_CUS_COMPANY_ID";

        public static function set_log_id($value){
            $_SESSION[self::LOG_ID] = $value;
        }

        public static function get_log_id(){
            return $_SESSION[self::LOG_ID];
        }
        public static function set_user_login($value){
            $_SESSION[self::USER_LOGIN] = $value;
        }

        public static function get_user_login(){
            return $_SESSION[self::USER_LOGIN];
        }

        public static function set_user_name($value){
            $_SESSION[self::USER_NAME] = $value;
        }

        public static function get_user_name(){
            return $_SESSION[self::USER_NAME];
        }

        public static function set_employee_code($value){
            $_SESSION[self::EMPLOYEE_CODE] = $value;
        }

        public static function get_employee_code(){
            return $_SESSION[self::EMPLOYEE_CODE];
        }

        public static function set_sale_id($value){
            $_SESSION[self::SALE_ID] = $value;
        }

        public static function get_sale_id(){
            return $_SESSION[self::SALE_ID];
        }

        public static function set_sale_group_id($value){
            $_SESSION[self::SALE_GROUP_ID] = $value;
        }

        public static function get_sale_group_id(){
            return $_SESSION[self::SALE_GROUP_ID];
        }

        public static function set_sale_group_name($value){
            $_SESSION[self::SALE_GROUP_NAME] = $value;
        }

        public static function get_sale_group_name(){
            return $_SESSION[self::SALE_GROUP_NAME];
        }
		

		#Helpdesk  
        public static function set_user_company_id($value){
            $_SESSION[self::USER_COMPANY_ID] = $value;
        }
		
        public static function get_user_company_id(){
            return $_SESSION[self::USER_COMPANY_ID];
        }
		
        public static function set_user_company_name($value){
            $_SESSION[self::USER_COMPANY_NAME] = $value;
        }
		
        public static function get_user_company_name(){
            return $_SESSION[self::USER_COMPANY_NAME];
        }
		  
		public static function set_user_my_orgcode($value){
            $_SESSION[self::USER_MY_ORGCODE] = $value;
        }
		
        public static function get_user_my_orgcode(){
            return $_SESSION[self::USER_MY_ORGCODE];
        }  
		
		public static function set_user_my_grpcode($value){
            $_SESSION[self::USER_MY_GRPCODE] = $value;
        }
		
        public static function get_user_my_grpcode(){
            return $_SESSION[self::USER_MY_GRPCODE];
        }
		
		public static function set_user_org_id($value){
            $_SESSION[self::USER_ORG_ID] = $value;
        }
		
        public static function get_user_org_id(){
            return $_SESSION[self::USER_ORG_ID];
        }
		  
		public static function set_user_org_name($value){
            $_SESSION[self::USER_ORG_NAME] = $value;
        }
		
        public static function get_user_org_name(){
            return $_SESSION[self::USER_ORG_NAME];
        }
		
		public static function set_user_grp_id($value){
            $_SESSION[self::USER_GRP_ID] = $value;
        }
		
        public static function get_user_grp_id(){
            return $_SESSION[self::USER_GRP_ID];
        }
		  
		public static function set_user_grp_name($value){
            $_SESSION[self::USER_GRP_NAME] = $value;
        }
		
        public static function get_user_grp_name(){
            return $_SESSION[self::USER_GRP_NAME];
        }
		
		public static function set_user_subgrp_id($value){
            $_SESSION[self::USER_SUBGRP_ID] = $value;
        }
		
        public static function get_user_subgrp_id(){
            return $_SESSION[self::USER_SUBGRP_ID];
        }
		  
		public static function set_user_subgrp_name($value){
            $_SESSION[self::USER_SUBGRP_NAME] = $value;
        }
		
        public static function get_user_subgrp_name(){
            return $_SESSION[self::USER_SUBGRP_NAME];
        }
		
        /*  
		
        
		*/
		
        public static function set_user_id($value){
            $_SESSION[self::USER_ID] = $value;
        }
		
        public static function get_user_id(){
            return $_SESSION[self::USER_ID];
        }
		
		
        public static function set_user_code($value){
            $_SESSION[self::USER_CODE] = $value;
        }
		
        public static function get_user_code(){
            return $_SESSION[self::USER_CODE];
        }
		
        public static function set_user_admin($value){
            $_SESSION[self::USER_ADMIN] = $value;
        }
		
        public static function get_user_admin(){
            return $_SESSION[self::USER_ADMIN];
        }
		
        public static function set_user_tra_inc_per($value){
            $_SESSION[self::USER_TRAN_INC_PER] = $value;
        }
		
        public static function get_user_tra_inc_per(){
            return $_SESSION[self::USER_TRAN_INC_PER];
        }
		
        public static function set_user_admin_permission($value){
            $_SESSION[self::USER_ADMIN_PER] = $value;
        }
		
        public static function get_user_admin_permission(){
            return $_SESSION[self::USER_ADMIN_PER];
        }
		
        public static function set_user_IncidentRunProject($value){
            $_SESSION[self::USER_IDENT_RUN_PROJECT] = $value;
        }
		
        public static function get_user_IncidentRunProject(){
            return $_SESSION[self::USER_IDENT_RUN_PROJECT];
        }
		
        public static function set_user_IncidentRunDigit($value){
            $_SESSION[self::USER_IDENT_RUN_DIGIT] = $value;
        }
		
        public static function get_user_IncidentRunDigit(){
            return $_SESSION[self::USER_IDENT_RUN_DIGIT];
        }
		
        public static function set_user_IncidentPrefix($value){
            $_SESSION[self::USER_IDENT_PREFIX] = $value;
        }
		
        public static function get_user_IncidentPrefix(){
            return $_SESSION[self::USER_IDENT_PREFIX];
        }
				
        public static function set_user_Email($value){
            $_SESSION[self::USER_EMAIL] = $value;
        }
		
        public static function get_user_Email(){
            return $_SESSION[self::USER_EMAIL];
        }
				
        public static function set_Email_admin($value){
            $_SESSION[self::USER_EMAIL_ADMIN] = $value;
        }
		
        public static function get_Email_admin(){
            return $_SESSION[self::USER_EMAIL_ADMIN];
        }
		
		public static function set_subgrp_id_spec_arr($value){
            $_SESSION[self::USER_SUBGRP_ID_SPEC] = $value;
        }
		
        public static function get_subgrp_id_spec_arr(){
            return $_SESSION[self::USER_SUBGRP_ID_SPEC];
        }
		
		
		
         public static function set_edit_rpt_per($value){
            $_SESSION[self::USER_EDIT_RPT_PER] = $value;
        }

        public static function get_edit_rpt_per(){
            return $_SESSION[self::USER_EDIT_RPT_PER];
        }
		
         public static function set_appv_rpt_per($value){
            $_SESSION[self::USER_APPV_RPT_PER] = $value;
        }

        public static function get_appv_rpt_per(){
            return $_SESSION[self::USER_APPV_RPT_PER];
        }
        
         public static function set_first_name($value){
            $_SESSION[self::FIRST_NAME] = $value;
        }

        public static function get_first_name(){
            return $_SESSION[self::FIRST_NAME];
        }
        
        public static function set_last_name($value){
            $_SESSION[self::LAST_NAME] = $value;
        }

        public static function get_last_name(){
            return $_SESSION[self::LAST_NAME];
        }
		
		public static function set_cus_company_id($value){
            $_SESSION[self::CUS_COMPANY_ID] = $value;
        }

        public static function get_cus_company_id(){
            return $_SESSION[self::CUS_COMPANY_ID];
        }
		
		public static function set_advs_per($value){
            $_SESSION[self::USER_ADVS_PER] = $value;
        }

        public static function get_advs_per(){
            return $_SESSION[self::USER_ADVS_PER];
        }
		
		
    }
?>