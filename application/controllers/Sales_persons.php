<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_persons extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Sales_persons_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->Sales_persons_model->search_result();
            $data['main_content']='sales_persons/search_sales_person';  
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data['action']		= 'Add';
            $data['main_content']='sales_persons/manage_sales_person'; 
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='sales_persons/manage_sales_person'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='sales_persons/manage_sales_person'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='sales_persons/manage_sales_person'; 
            $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
            $this->load->view('includes/template',$data);
	}
	
        
	function validate(){   
            $this->form_val_setrules(); 
            if($this->form_validation->run() == False){
                switch($this->input->post('action')){
                    case 'Add':
                            $this->session->set_flashdata('error','Not Saved! Please Recheck the form'); 
                            $this->add();
                            break;
                    case 'Edit':
                            $this->session->set_flashdata('error','Not Saved! Please Recheck the form');
                            $this->edit($this->input->post('id'));
                            break;
                    case 'Delete':
                            $this->delete($this->input->post('id'));
                            break;
                } 
            }
            else{
                switch($this->input->post('action')){
                    case 'Add':
                            $this->create();
                    break;
                    case 'Edit':
                        $this->update();
                    break;
                    case 'Delete':
                        $this->remove();
                    break;
                    case 'View':
                        $this->view();
                    break;
                }	
            }
	}
        
	function form_val_setrules(){
            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('sales_person_name','Name','required|min_length[2]'); 
      }	
                    
	function create(){   
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($inputs); die;
            $sales_person_id = get_autoincrement_no(SALES_PERSONS);
            
            $data = array(
                            'id' => $sales_person_id,
                            'sales_person_name' => $inputs['sales_person_name'],
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
                    
		$add_stat = $this->Sales_persons_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Sales_persons_model->get_single_row($add_stat[1]);
                    add_system_log(SALES_PERSONS, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class())); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
	
	function update(){ 
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($this->input->post()); die;
            $data = array(
                            'sales_person_name' => $inputs['sales_person_name'],
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        ); 
            
//            echo '<pre>'; print_r($data); die;
            //old data for log update
            $existing_data = $this->Sales_persons_model->get_single_row($inputs['id']);

            $edit_stat = $this->Sales_persons_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Sales_persons_model->get_single_row($inputs['id']);
                add_system_log(SALES_PERSONS, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post();
                                        
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                
            $existing_data = $this->Sales_persons_model->get_single_row($inputs['id']);
            $delete_stat = $this->Sales_persons_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(CONSIGNEES, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Sales_persons_model->get_single_row($inputs['id']);
            if($this->Sales_persons_model->delete2_db($id)){
                //update log data
                add_system_log(HOTELS, $this->router->fetch_class(), __FUNCTION__, '', $existing_data);
                
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url('company'));

            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url('company'));
            }  
	}
        
        function load_data($id){
            
            $data['user_data'] = $this->Sales_persons_model->get_single_row($id); 
            if(empty($data['user_data'])){
                $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                redirect(base_url($this->router->fetch_class()));
            }
            return $data;	
	}	
        
        function search(){
		$search_data=array( 'sales_person_name' => $this->input->post('name')); 
		$data_view['search_list'] = $this->Sales_persons_model->search_result($search_data);
                                        
		$this->load->view('sales_persons/search_sales_person_result',$data_view);
	}
                                    
                    
}
