<?php
    include_once "model.class.php";

    class customer_group extends model {

        function searchLookup($carteria) {
            $sql = " SELECT"
                     . "    customer_group_id, customer_group_name"
                     . " FROM tb_customer_group"
                     . " WHERE customer_group_status = 'A'"   ;

            if (strUtil::isNotEmpty($carteria["customer_group_name"])) {
                $sql .= " AND company_name LIKE '%{$carteria["customer_group_name"]}%'";
            }

            $sql .= " ORDER BY customer_group_name";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if($rows == 0) return array();

            while ($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }

        function listCombo() {
            $sql = " SELECT"
                     . "    customer_group_id, customer_group_name"
                     . " FROM tb_customer_group"
                     . " WHERE customer_group_status = 'A'"
                     . " ORDER BY customer_group_name";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if($rows == 0) return null();

            while ($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
    }
?>
