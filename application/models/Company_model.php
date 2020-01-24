<?php 

class Company_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
         public function search_result($data=''){ 
            $this->db->select('*');
            $this->db->from(COMPANIES);  
            $this->db->where('deleted',0);
            if($data !=''){
                $this->db->like('company_name', $data['company_name']); 
               } 
            $result = $this->db->get()->result_array();  
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('cm.*');
            $this->db->select('b.bank_name,b.bank_code,b.swift_code, b.bank_account_number, b.bank_account_name, b.bank_account_branch,b.bank_account_branch_code, b.bank_account_branch_address');
            $this->db->select('(select c.country_name from '.COUNTRY_LIST.' c where c.country_code=cm.country) as country_name');
            $this->db->join(BANK_ACCOUNTS." b", "b.company_id = cm.id");
            $this->db->from(COMPANIES.' cm'); 
            $this->db->where('cm.id',$id);
            $this->db->where('cm.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){       
                $this->db->trans_start();
		$this->db->insert(COMPANIES, $data); 
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
                $this->db->update(COMPANIES, $data['company']);
                
                $this->db->where('company_id',$id);
                $this->db->update(BANK_ACCOUNTS, $data['bank']);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->where('id!=', 1);
                $this->db->where('deleted',0);
		$this->db->update(COMPANIES, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(COMPANIES, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>