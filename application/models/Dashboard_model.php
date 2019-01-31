<?php 

class Dashboard_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
        
         public function get_tbl_couts($table_name,$where=''){ 
            $this->db->select('*');
            $this->db->from($table_name); 
            $this->db->where('status',1);
            $this->db->where('deleted',0);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
            return count($result);
	}
         public function get_number_inv($tbl,$start='',$end='',$where=''){ 
            $this->db->select('id');
            $this->db->from($tbl); 
            $this->db->where('deleted',0);
            if(isset($start) && $start!='')$this->db->where('added_on >=', $start);
            if(isset($end) && $end!='')$this->db->where('added_on <=', $end);
            if(isset($where) && $where!='')$this->db->where($where);
            $result = $this->db->get()->result_array(); 
            return count($result);
	}
        public function get_available_items($where='',$limit=''){
//            echo '<pre>';            print_r($limit); die;
            $this->db->select("is.*,itm.item_code,itm.item_category_id,CONCAT(itm.item_name,'-',itm.item_code) as item_name");
            $this->db->select('(select category_name from '.ITEM_CAT.' where id = itm.item_category_id)  as item_category_name');
            $this->db->select('(select location_name from '.INV_LOCATION.' where id = is.location_id)  as location_name');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = is.uom_id)  as uom_name');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = is.uom_id_2)  as uom_name_2');
            $this->db->join(ITEMS.' itm','itm.id = is.item_id','left');
            $this->db->from(ITEM_STOCK.' is');     
//            $this->db->where('is.units_available >',0);
            $this->db->where('is.units_available > 0 OR is.units_on_consignee OR is.units_on_workshop');
            $this->db->where('is.units_available > is.units_on_reserve');
            $this->db->where('is.deleted',0);
            $this->db->where('is.status',1);
            $this->db->where('itm.sales_excluded',0);
            $this->db->where('itm.item_type_id !=',4);
            if($where!='') $this->db->where($where);
            if($limit!='') $this->db->limit($limit);
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
//            echo '<pre>';            print_r($result); die;
            return count($result);
	}
 
}
?>