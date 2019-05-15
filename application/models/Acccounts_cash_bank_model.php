<?php 

class Acccounts_cash_bank_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('b.*');
            $this->db->select("CONCAT(glm.account_name,' (',glm.account_code,')') as master_account");
            $this->db->from(BANK_ACCOUNTS.' b');  
            $this->db->join(GL_CHART_MASTER.' glm','glm.id = b.gl_chart_master_id','left');
            $this->db->where('b.deleted',0);
            if(isset($data['account_name']) && $data['account_name']!='')$this->db->like('b.bank_account_name', $data['account_name']);   
            if(isset($data['account_type']) && $data['account_type']!='')$this->db->where('b.account_type', $data['account_type']);   
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('*');
            $this->db->from(CONSIGNEES); 
            $this->db->where('id',$id);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){
//            echo '<pre>';            print_r($data); die;       
                $this->db->trans_start();
		$this->db->insert(CONSIGNEES, $data); 
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(CONSIGNEES, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(CONSIGNEES, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(CONSIGNEES, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>