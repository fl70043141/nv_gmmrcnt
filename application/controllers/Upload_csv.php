<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_csv extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Items_CSV_model');
        }


        public function index()
	{
            $this->view_form_csv();
	}
        
        function view_form_csv($datas=''){
//            $data = $this->load_data();
//            $data['log_list'] = $this->Audit_trial_model->search_result();
		$data['action']		= 'Add';
            $data['main_content']='upload_csv'; 
            $this->load->view('includes/template',$data);
	}
                                        
	  
        function validate(){
 //           echo 'INITIAL SETUPS FOR CSV UPLOAD<br> 01. REQUIRED TO SET SUPPLIER ID <br>02. REQUIRED TO SET LOCATION ID';die;
            $this->load->model('Items_model');
            $this->load->model('Purchasing_items_model');
            $file = $_FILES["file"]["tmp_name"];
            $file_open = fopen($file, "r");
            $j=0;
            $purch_data = array();
            while (($csv = fgetcsv($file_open, 1000, ",")) !== false && $csv[0]!='') {
                
//                    echo '<br>sp-'.$csv[5],'  == inv-'.$csv['22'];  
                if($j!=0){
                    if($csv['22']!=''){ //22 for invoice id
                        $purch_data[$csv['22']][] = $csv;
                    }
                }
                $j++;
            }
                           
                    
            if(!empty($purch_data)){
                
                foreach ($purch_data as $purch_inv_desc){
                    $data_arr = array(); 
                    $supplier_id =(isset($purch_inv_desc[0][5])?$purch_inv_desc[0][5]:1);
                    $location_id = 1;

                    $supplier_inv_id = get_autoincrement_no(SUPPLIER_INVOICE);
                    $supplier_invoice_no = gen_id(SUP_INVOICE_NO_PREFIX, SUPPLIER_INVOICE, 'id');


                    $cur_det = $this->Purchasing_items_model->get_currency_for_code($this->session->userdata(SYSTEM_CODE)['default_currency']);

                    $sdata['supp_inv_tbl'] = array(
                                            'id' => $supplier_inv_id,
                                            'supplier_invoice_no' => $supplier_invoice_no,
                                            'supplier_id' => $purch_inv_desc[0][5],
                                            'reference' => 'SUP_INV_CSV',
                                            'invoice_date' => strtotime("now"),
                                            'invoiced' => 1,
                                            'payment_term_id' => 2,
                                            'currency_code' =>$cur_det['code'],
                                            'currency_value' =>$cur_det['value'],
                                            'location_id' => $location_id,  
                                            'status' => 1,  
                                            'added_on' => date('Y-m-d'),
                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                        ); 
                    
                        $insert_stat = $this->Items_CSV_model->add_db_purch_invoice($sdata);
//                    $insert_stat = true;
                     $i=0;
        //            if(true){
                    if($insert_stat){ 
                        $total=0;
                        foreach($purch_inv_desc as $itm) {
//                            echo '<pre>';                            print_r($itm); die;
                                    $item_code = $itm[0];
                                    $item_desc = $itm[1];
                                    $cat_id = $itm[2];
                                    $sales_price = $itm[3];
                                    $purch_price = $itm[4];
                                    $supplier_id= $itm[5];
                                    $qty= $itm[6];
                                    $uom_id= 3;
//                                    $uom_id= $itm[7];
                                    $qty_2= $itm[8];
                                    $uom_id_2= 7;
//                                    $uom_id_2= $itm[9];
                                    $sales_excluded= $itm[11];
                                    $purchase_exclude= $itm[12];

                                    $purch_price = $purch_price;
//                                    $purch_price = $purch_price/$qty;

                                    //GEMS 
                                    $color = $itm[13];
                                    $certfication = $itm[14];
                                    $cert_no = $itm[15];
                                    $origin = $itm[16];
                                    $treatment = $itm[17];
                                    $shape = $itm[18];

                                    $sales_price2 = $itm[19];
                                    $sales_price2_id = $itm[20];
                                    $partnerhip = $itm[21];
                                    
                                    //jewelry Charges
                                    $crft_charge = $itm[23];
                                    $stine_charge = $itm[24];
                                    
                                    $item_id = get_autoincrement_no(ITEMS); 
        //                            $item_code = gen_id(ITEMCODE_PREFIX, ITEMS, 'id',4);
                                    $inputs['status'] = (isset($inputs['status']))?1:0;
                                    $sales_excluded = (isset($sales_excluded) && $sales_excluded!='')?1:0;
                                    $purchase_exclude = (isset($purchase_exclude) && $purchase_exclude!='')?1:0;

                                    //create Dir if not exists for store necessary images   
                                    if(!is_dir(ITEM_IMAGES.$item_id.'/')) mkdir(ITEM_IMAGES.$item_id.'/', 0777, TRUE); 
                                    if(!is_dir(ITEM_IMAGES.$item_id.'/other/')) mkdir(ITEM_IMAGES.$item_id.'/other/', 0777, TRUE);

                                    $dir_path = "F:/ZV_GEMS_CSV/images/".$cat_id.'/'.$shape;
                                    //$dir_path = "E:/My Study/Project/PROJECTS NVELOOP/NVELOOP/POS/CSV UPLOAD/20190821_CSV_UPLOAD/CSV_UPLOAD_JEWELRY/20190727/product_list/".$item_code;
                                    $file_in = $all_images = array();
                                    if(is_dir($dir_path))
                                        $file_in = scandir($dir_path,1);


                                    if(!empty($file_in)) sort($file_in);
                                    $first_img = '';
                                                                $count=0;
                                    foreach ($file_in as $key => $img){
                //                        echo $key; die;

                                        if($count==0 & $img!='.' & $img!='..'){
                                            $first_img = $img; 
                                            copy($dir_path.'/'.$img, ITEM_IMAGES.$item_id.'/'.$img);
                                                                                $count++;
                                        }
                                        else if($count!=0  & $img!='.' & $img!='..'){
                                            copy($dir_path.'/'.$img, ITEM_IMAGES.$item_id.'/other/'.$img);
                                            $all_images[]=$img;
                                                                                $count++;
                                        }
                                    }
//                                        echo '<pre>';        print_r($partnerhip); die;

                                        if($partnerhip!='')
                                            $partnership_ratio = calculate_string($partnerhip);
                                        else
                                            $partnership_ratio =1;
//            echo '<pre>';            print_r($partnership_ratio); die; 
                                    $data['item'] = array(
                                                            'id' => $item_id,
                                                            'item_code' => $item_code,
                                                            'item_name' => $item_desc,
                                                            'item_uom_id' => $uom_id,
                                                            'item_uom_id_2' => $uom_id_2,
                                                            'item_category_id' => $cat_id,
                                                            'item_type_id' => ($partnership_ratio<1 && $partnerhip!='')?5:1,  //5 forpartnership
                                                            'partnership' => ($partnership_ratio<1 && $partnerhip!='')?$partnership_ratio:1,  // forpartnership range
                                                            'description' => '',
                                                            'addon_type_id' => 0,
                                                            'sales_excluded' => $sales_excluded,
                                                            'purchases_excluded' => $purchase_exclude,
                                                            'image' => $first_img,
                                                            'images' => (isset($all_images))?json_encode($all_images):'',
                                                            'status' => 1, 
                                                            'added_on' => date('Y-m-d'),
                                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                        );

                                    if($color!='' && isset($color)){$data['item']['color'] = $color;}
                                    if($certfication!='' && isset($certfication)){$data['item']['certification'] = $certfication;}
                                    if($cert_no!='' && isset($cert_no)){$data['item']['certification_no'] = $cert_no;}
                                    if($treatment!='' && isset($treatment)){$data['item']['treatment'] = $treatment;}
                                    if($shape!='' && isset($shape)){$data['item']['shape'] = $shape;}
                                    if($origin!='' && isset($origin)){$data['item']['origin'] = $origin;}

                                    
                                        $supplier_inv_desc_id = get_autoincrement_no(SUPPLIER_INVOICE_DESC);
                                        $data['supplier_inv_desc'] = array(
                                                                    'id' => $supplier_inv_desc_id,
                                                                    'item_id' => $item_id,
                                                                    'supplier_invoice_id' => $supplier_inv_id,
                                                                    'supplier_item_desc' => $item_desc,
                                                                    'purchasing_unit' => $qty,
                                                                    'purchasing_unit_uom_id' => $uom_id,
                                                                    'secondary_unit_uom_id' => $uom_id_2,
                                                                    'secondary_unit' => $qty_2,
                                                                    'location_id' => $location_id,
                                                                    'purchasing_unit_price' => $purch_price,
                                                                    'status' => 1,   
                                                                );

                                          $data['item_stock_transection'] = array(
                                                                            'transection_type'=>1, //1 for purchsing transection
                                                                            'trans_ref'=>$supplier_inv_id, 
                                                                            'item_id'=>$item_id, 
                                                                            'units'=>$qty, 
                                                                            'uom_id'=>$uom_id, 
                                                                            'units_2'=>$qty_2, 
                                                                            'uom_id_2'=>$uom_id_2, 
                                                                            'location_id'=>$location_id, 
                                                                            'status'=>1, 
                                                                            'added_on' => date('Y-m-d'),
                                                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                                            );

                                        if($uom_id_2!=0)
                                            $item_stock_data = $this->stock_status_check($item_id,$location_id,$uom_id,$qty,$uom_id_2,$qty_2);
                                        else
                                            $item_stock_data = $this->stock_status_check($item_id,$location_id,$uom_id,$qty);

                                        if(!empty($item_stock_data)){
                                            $data['item_stock'] = $item_stock_data;
                                        }

                                        $data['prices'][0] = array(
                                                                        'item_id' => $item_id,
                                                                        'item_price_type' => 1, //2 Purch price
                                                                        'price_amount' =>$purch_price,
                                                                        'currency_code' =>$cur_det['code'],
                                                                        'currency_value' =>$cur_det['value'],
                                                                        'sales_type_id' =>0,
                                                                        'supplier_id' =>$supplier_id,
                                                                        'supplier_unit_conversation' =>1,
                                                                        'status' =>1,
                                                                        ); 
                                        $data['prices'][1] = array(
                                                                        'item_id' => $item_id,
                                                                        'item_price_type' => 2, //2 sales price
                                                                        'price_amount' =>$sales_price,
                                                                        'currency_code' =>$cur_det['code'],
                                                                        'currency_value' =>$cur_det['value'],
                                                                        'sales_type_id' =>15,//drop_down for retail sale
                                                                        'supplier_id' =>0,
                                                                        'supplier_unit_conversation' =>0,
                                                                        'status' =>1,
                                                                        ); 
                                        $data['prices'][2] = array( //standard price
                                                                        'item_id' => $item_id,
                                                                        'item_price_type' => 3, //2 sales price
                                                                        'price_amount' =>$purch_price,
                                                                        'currency_code' =>$cur_det['code'],
                                                                        'currency_value' =>$cur_det['value'],
                                                                        'sales_type_id' =>0,//drop_down for retail sale
                                                                        'supplier_id' =>0,
                                                                        'supplier_unit_conversation' =>0,
                                                                        'status' =>1,
                                                                        ); 
                                        if($sales_price2_id!=''){
                                            $data['prices'][3] = array(
                                                                            'item_id' => $item_id,
                                                                            'item_price_type' => 2, //2 sales price
                                                                            'price_amount' =>$sales_price2,
                                                                            'currency_code' =>$cur_det['code'],
                                                                            'currency_value' =>$cur_det['value'],
                                                                            'sales_type_id' =>$sales_price2_id,//drop_down for retail sale
                                                                            'supplier_id' =>0,
                                                                            'supplier_unit_conversation' =>0,
                                                                            'status' =>1,
                                                                            ); 
                                        }
                                        
                                        
//                            $lapd_cost_id = get_autoincrement_no(GEM_LAPIDARY_COSTING);  
//                            $lapd_cost_id2=$lapd_cost_id;
//                            //Quick entry Costing
//                                if($crft_charge>0){
//                                    $lapd_cost_id2++;
//                                        $data['lpd_costs'][] = array(
//                                                                    'id' => $lapd_cost_id,
//                                                                    'item_id' => $item_id,
//                                                                    'gem_issue_type_id' => 9, //Jewelry costing
//                                                                    'lapidarist_id' => 92, //craftman charge
//                                                                    'cost_entry_date' =>strtotime("now"),
//                                                                    'amount_cost' =>$crft_charge,
//                                                                    'currency_code' => $cur_det['code'],
//                                                                    'currency_value' => $cur_det['value'],
//                                                                    'status' => 1,
//                                                                    'added_on' => strtotime("now"),
//                                                                    'deleted' => 0,
//                                                                    );
//                                        //gl entry
//                                        $gem_issue_type_info = get_single_row_helper(GEM_ISSUE_TYPES,'id = 9');
//                                        $gl_credit_acc_id = $gem_issue_type_info['gl_credit_delay'];
//                                        $gl_debit_acc_info = get_single_row_helper(GL_CHART_MASTER, 'id = '.$gem_issue_type_info['gl_debit']);
//                                        $gl_credit_acc_info = get_single_row_helper(GL_CHART_MASTER, 'id = '.$gl_credit_acc_id);
//
//                                        $data['gl_trans'][] = array(
//                                                                        'person_type' => 51, //lapidarist item quick entry for costing
//                                                                        'person_id' => 92,
//                                                                        'trans_ref' => $lapd_cost_id, //lapidary_cost_id
//                                                                        'trans_date' => strtotime("now"),
//                                                                        'account' => $gl_debit_acc_info['id'], 
//                                                                        'account_code' => $gl_debit_acc_info['account_code'], 
//                                                                        'memo' => 'LAPIDARY_COST',
//                                                                        'amount' => ($crft_charge),
//                                                                        'currency_code' => $cur_det['code'], 
//                                                                        'currency_value' => $cur_det['value'], 
//                                                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
//                                                                        'status' => 1,
//                                                                );
//                                        $data['gl_trans'][] = array(
//                                                                        'person_type' => 51, //lapidarist
//                                                                        'person_id' => 92,
//                                                                        'trans_ref' => $lapd_cost_id,
//                                                                        'trans_date' => strtotime("now"),
//                                                                        'account' => $gl_credit_acc_info['id'], 
//                                                                        'account_code' => $gl_credit_acc_info['account_code'], 
//                                                                        'memo' => 'LAPIDARY_COST',
//                                                                        'amount' => (-$crft_charge),
//                                                                        'currency_code' => $cur_det['code'], 
//                                                                        'currency_value' => $cur_det['value'], 
//                                                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
//                                                                        'status' => 1,
//                                                                );
//                                        $lapd_cost_id++; 
//
//                                }      
//                            //Quick entry Costing stomne costing
//                                if($stine_charge>0){   
// 
//                                        $data['lpd_costs'][] = array(
//                                                                    'id' => $lapd_cost_id2,
//                                                                    'item_id' => $item_id,
//                                                                    'gem_issue_type_id' => 9, //Jewelry costing
//                                                                    'lapidarist_id' => 90, //craftman charge
//                                                                    'cost_entry_date' =>strtotime("now"),
//                                                                    'amount_cost' =>$stine_charge,
//                                                                    'currency_code' => $cur_det['code'],
//                                                                    'currency_value' => $cur_det['value'],
//                                                                    'status' => 1,
//                                                                    'added_on' => strtotime("now"),
//                                                                    'deleted' => 0,
//                                                                    );
//                                        //gl entry
//                                        $gem_issue_type_info = get_single_row_helper(GEM_ISSUE_TYPES,'id = 9');
//                                        $gl_credit_acc_id = $gem_issue_type_info['gl_credit_delay'];
//                                        $gl_debit_acc_info = get_single_row_helper(GL_CHART_MASTER, 'id = '.$gem_issue_type_info['gl_debit']);
//                                        $gl_credit_acc_info = get_single_row_helper(GL_CHART_MASTER, 'id = '.$gl_credit_acc_id);
//
//                                        $data['gl_trans'][] = array(
//                                                                        'person_type' => 51, //lapidarist item quick entry for costing
//                                                                        'person_id' => 90,
//                                                                        'trans_ref' => $lapd_cost_id2, //lapidary_cost_id
//                                                                        'trans_date' => strtotime("now"),
//                                                                        'account' => $gl_debit_acc_info['id'], 
//                                                                        'account_code' => $gl_debit_acc_info['account_code'], 
//                                                                        'memo' => 'LAPIDARY_COST',
//                                                                        'amount' => ($stine_charge),
//                                                                        'currency_code' => $cur_det['code'], 
//                                                                        'currency_value' => $cur_det['value'], 
//                                                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
//                                                                        'status' => 1,
//                                                                );
//                                        $data['gl_trans'][] = array(
//                                                                        'person_type' => 51, //lapidarist
//                                                                        'person_id' => 90,
//                                                                        'trans_ref' => $lapd_cost_id2,
//                                                                        'trans_date' => strtotime("now"),
//                                                                        'account' => $gl_credit_acc_info['id'], 
//                                                                        'account_code' => $gl_credit_acc_info['account_code'], 
//                                                                        'memo' => 'LAPIDARY_COST',
//                                                                        'amount' => (-$stine_charge),
//                                                                        'currency_code' => $cur_det['code'], 
//                                                                        'currency_value' => $cur_det['value'], 
//                                                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
//                                                                        'status' => 1,
//                                                                );
//                                        $lapd_cost_id++; 
//
//                                }


                                        $total += $purch_price*$qty;
        //                                echo '<br>'.$item_code.'  => '.$qty.' x '.$purch_price.' = '.($purch_price*$qty) .' [total = '.$total.']';

//                                        echo '<pre>';        print_r($data); die;
                        //            if(!empty($def_image)) $data['image'] = $def_image[0]['name'];
//                                                            echo '<pre>';                                print_r($data); die;

                                    $add_stat = $this->Items_CSV_model->add_db_item($data); 
                                    if($add_stat[0]){
                                        echo $csv[0].' Added Successfully ('.$supplier_invoice_no.')<br>';
                                    }else{
                                        echo ' <p style="color:red"> '.$csv[0].' - Error</p><br>';
                                    } 
                            $i++;
                        }

                    //GL TRANSECTIONS
                    $data_1['gl_trans'] = array(array(
                                                'person_type' => 20,
                                                'person_id' => $supplier_id,
                                                'trans_ref' => $supplier_inv_id,
                                                'trans_date' => strtotime("now"),
                                                'account' => 5, //5 inventory GL
                                                'account_code' => 1510, //5 inventory GL
                                                'memo' => '',
                                                'amount' => +($total),
                                                'currency_code' =>$cur_det['code'],
                                                'currency_value' =>$cur_det['value'],
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        ),array(
                                                'person_type' => 20,
                                                'person_id' => $supplier_id,
                                                'trans_ref' => $supplier_inv_id,
                                                'trans_date' => strtotime("now"),
                                                'account' => 14, //14 AC Payable GL
                                                'account_code' => 2100, //inventory GL
                                                'memo' => '',
                                                'amount' => (-$total),
                                                'currency_code' =>$cur_det['code'],
                                                'currency_value' =>$cur_det['value'],
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        )
                                    );

                                    $add_stat = $this->Items_CSV_model->add_db_gl($data_1);
                                    if($add_stat[0]){
                                        echo '<br> GL ENTRY UPDATED SUCCESFULLY<br><br><br>...........................................<br> ';
                                    }else{
                                        echo ' <p style="color:red"> GL ENTRY - Error</p><br>';
                                    }
                    }
                }
            }else{
                echo 'No Data Found';
            } 

            
            
           
        }
        
        function validate2(){
//            echo 'INITIAL SETUPS FOR CSV UPLOAD<br> 01. REQUIRED TO SET SUPPLIER ID <br>02. REQUIRED TO SET LOCATION ID';die;
            $file = $_FILES["file"]["tmp_name"];
            $file_open = fopen($file, "r");

            $data_arr = array(); 
            $supplier_id =1;
            $location_id = 1;

            $supplier_inv_id = get_autoincrement_no(SUPPLIER_INVOICE);
            $supplier_invoice_no = gen_id(SUP_INVOICE_NO_PREFIX, SUPPLIER_INVOICE, 'id');
             
            $this->load->model('Purchasing_items_model');
            $cur_det = $this->Purchasing_items_model->get_currency_for_code($this->session->userdata(SYSTEM_CODE)['default_currency']);
            
            $sdata['supp_inv_tbl'] = array(
                                    'id' => $supplier_inv_id,
                                    'supplier_invoice_no' => $supplier_invoice_no,
                                    'supplier_id' => $supplier_id,
                                    'reference' => 'UPLOAD CSV',
                                    'invoice_date' => strtotime("now"),
                                    'invoiced' => 1,
                                    'payment_term_id' => 2,
                                    'currency_code' =>$cur_det['code'],
                                    'currency_value' =>$cur_det['value'],
                                    'location_id' => $location_id,  
                                    'status' => 1,  
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                ); 
            $insert_stat = $this->Items_CSV_model->add_db_purch_invoice($sdata);
//            $insert_stat = true;
            
            $i=0;
//            if(true){
            if($insert_stat){
                $total=0;
                while (($csv = fgetcsv($file_open, 1000, ",")) !== false && $csv[0]!='') {
                    
                        if($i!=0){
                            $item_code = $csv[0];
                            $item_desc = $csv[1];
                            $cat_id = $csv[2];
                            $sales_price = $csv[3];
                            $purch_price = $csv[4];
                            $supplier_id= $csv[5];
                            $qty= $csv[6];
                            $uom_id= $csv[7];
                            $qty_2= $csv[8];
                            $uom_id_2= $csv[9];
                            $sales_excluded= $csv[11];
                            $purchase_exclude= $csv[12];
                            
                            $purch_price = $purch_price/$qty;
                            
                            //GEMS 
                            $color = $csv[13];
                            $certfication = $csv[14];
                            $cert_no = $csv[15];
                            $origin = $csv[16];
                            $treatment = $csv[17];
                            $shape = $csv[18];
                            
                            $sales_price2 = $csv[19];
                            $sales_price2_id = $csv[20];
                            $partnerhip = $csv[21];
                          
                            $item_id = get_autoincrement_no(ITEMS); 
//                            $item_code = gen_id(ITEMCODE_PREFIX, ITEMS, 'id',4);
                            $inputs['status'] = (isset($inputs['status']))?1:0;
                            $sales_excluded = (isset($sales_excluded) && $sales_excluded!='')?1:0;
                            $purchase_exclude = (isset($purchase_exclude) && $purchase_exclude!='')?1:0;

                            //create Dir if not exists for store necessary images   
                            if(!is_dir(ITEM_IMAGES.$item_id.'/')) mkdir(ITEM_IMAGES.$item_id.'/', 0777, TRUE); 
                            if(!is_dir(ITEM_IMAGES.$item_id.'/other/')) mkdir(ITEM_IMAGES.$item_id.'/other/', 0777, TRUE);

                            $dir_path = "F:/ZV_GEMS_CSV11/images/".$cat_id.'/'.$shape;
                            //$dir_path = "E:/My Study/Project11/PROJECTS NVELOOP/NVELOOP/JWL_POS/CSV_UPLOAD/product_list/".$item_code;
                            $file_in = $all_images = array();
                            if(is_dir($dir_path))
                                $file_in = scandir($dir_path,1);
 
							
                            if(!empty($file_in)) sort($file_in);
                            $first_img = '';
							$count=0;
                            foreach ($file_in as $key => $img){
        //                        echo $key; die;
								
                                if($count==0 & $img!='.' & $img!='..'){
                                    $first_img = $img; 
                                    copy($dir_path.'/'.$img, ITEM_IMAGES.$item_id.'/'.$img);
									$count++;
                                }
                                else if($count!=0  & $img!='.' & $img!='..'){
                                    copy($dir_path.'/'.$img, ITEM_IMAGES.$item_id.'/other/'.$img);
                                    $all_images[]=$img;
									$count++;
                                }
                            }
                               // echo '<pre>';        print_r($all_images); die;

                            $data['item'] = array(
                                                    'id' => $item_id,
                                                    'item_code' => $item_code,
                                                    'item_name' => $item_desc,
                                                    'item_uom_id' => $uom_id,
                                                    'item_uom_id_2' => $uom_id_2,
                                                    'item_category_id' => $cat_id,
                                                    'item_type_id' => ($partnerhip>0 && $partnerhip!='')?5:1,  //5 forpartnership
                                                    'partnership' => ($partnerhip>0 && $partnerhip!='')?$partnerhip:1,  // forpartnership range
                                                    'description' => '',
                                                    'addon_type_id' => 0,
                                                    'sales_excluded' => $sales_excluded,
                                                    'purchases_excluded' => $purchase_exclude,
                                                    'image' => $first_img,
                                                    'images' => (isset($all_images))?json_encode($all_images):'',
                                                    'status' => 1, 
                                                    'added_on' => date('Y-m-d'),
                                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                );
                            
                            if($color!='' && isset($color)){$data['item']['color'] = $color;}
                            if($certfication!='' && isset($certfication)){$data['item']['certification'] = $certfication;}
                            if($cert_no!='' && isset($cert_no)){$data['item']['certification_no'] = $cert_no;}
                            if($treatment!='' && isset($treatment)){$data['item']['treatment'] = $treatment;}
                            if($shape!='' && isset($shape)){$data['item']['shape'] = $shape;}
                            if($origin!='' && isset($origin)){$data['item']['origin'] = $origin;}
                            

                                $supplier_inv_desc_id = get_autoincrement_no(SUPPLIER_INVOICE_DESC);
                                $data['supplier_inv_desc'] = array(
                                                            'id' => $supplier_inv_desc_id,
                                                            'item_id' => $item_id,
                                                            'supplier_invoice_id' => $supplier_inv_id,
                                                            'supplier_item_desc' => $item_desc,
                                                            'purchasing_unit' => $qty,
                                                            'purchasing_unit_uom_id' => $uom_id,
                                                            'secondary_unit_uom_id' => $uom_id_2,
                                                            'secondary_unit' => $qty_2,
                                                            'location_id' => $location_id,
                                                            'purchasing_unit_price' => $purch_price,
                                                            'status' => 1,   
                                                        );

                                  $data['item_stock_transection'] = array(
                                                                    'transection_type'=>1, //1 for purchsing transection
                                                                    'trans_ref'=>$supplier_inv_id, 
                                                                    'item_id'=>$item_id, 
                                                                    'units'=>$qty, 
                                                                    'uom_id'=>$uom_id, 
                                                                    'units_2'=>$qty_2, 
                                                                    'uom_id_2'=>$uom_id_2, 
                                                                    'location_id'=>$location_id, 
                                                                    'status'=>1, 
                                                                    'added_on' => date('Y-m-d'),
                                                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                                    );

                                if($uom_id_2!=0)
                                    $item_stock_data = $this->stock_status_check($item_id,$location_id,$uom_id,$qty,$uom_id_2,$qty_2);
                                else
                                    $item_stock_data = $this->stock_status_check($item_id,$location_id,$uom_id,$qty);

                                if(!empty($item_stock_data)){
                                    $data['item_stock'] = $item_stock_data;
                                }

                                $data['prices'][0] = array(
                                                                'item_id' => $item_id,
                                                                'item_price_type' => 1, //2 Purch price
                                                                'price_amount' =>$purch_price,
                                                                'currency_code' =>$cur_det['code'],
                                                                'currency_value' =>$cur_det['value'],
                                                                'sales_type_id' =>0,
                                                                'supplier_id' =>$supplier_id,
                                                                'supplier_unit_conversation' =>1,
                                                                'status' =>1,
                                                                ); 
                                $data['prices'][1] = array(
                                                                'item_id' => $item_id,
                                                                'item_price_type' => 2, //2 sales price
                                                                'price_amount' =>$sales_price,
                                                                'currency_code' =>$cur_det['code'],
                                                                'currency_value' =>$cur_det['value'],
                                                                'sales_type_id' =>15,//drop_down for retail sale
                                                                'supplier_id' =>0,
                                                                'supplier_unit_conversation' =>0,
                                                                'status' =>1,
                                                                ); 
                                $data['prices'][2] = array( //standard price
                                                                'item_id' => $item_id,
                                                                'item_price_type' => 3, //2 sales price
                                                                'price_amount' =>$purch_price,
                                                                'currency_code' =>$cur_det['code'],
                                                                'currency_value' =>$cur_det['value'],
                                                                'sales_type_id' =>0,//drop_down for retail sale
                                                                'supplier_id' =>0,
                                                                'supplier_unit_conversation' =>0,
                                                                'status' =>1,
                                                                ); 
                                if($sales_price2_id!=''){
                                    $data['prices'][3] = array(
                                                                    'item_id' => $item_id,
                                                                    'item_price_type' => 2, //2 sales price
                                                                    'price_amount' =>$sales_price2,
                                                                    'currency_code' =>$cur_det['code'],
                                                                    'currency_value' =>$cur_det['value'],
                                                                    'sales_type_id' =>$sales_price2_id,//drop_down for retail sale
                                                                    'supplier_id' =>0,
                                                                    'supplier_unit_conversation' =>0,
                                                                    'status' =>1,
                                                                    ); 
                                }

                                
                                $total += $purch_price*$qty;
//                                echo '<br>'.$item_code.'  => '.$qty.' x '.$purch_price.' = '.($purch_price*$qty) .' [total = '.$total.']';
                
//                                echo '<pre>';        print_r($data); die;
                //            if(!empty($def_image)) $data['image'] = $def_image[0]['name'];
        //                                            echo '<pre>';                                print_r($data); die;

                            $add_stat = $this->Items_CSV_model->add_db_item($data); 
                            if($add_stat[0]){
                                echo $csv[0].' Added Successfully <br>';
                            }else{
                                echo ' <p style="color:red"> '.$csv[0].' - Error</p><br>';
                            }
                    }
                    $i++;
                }
                
            //GL TRANSECTIONS
            $data_1['gl_trans'] = array(array(
                                        'person_type' => 20,
                                        'person_id' => $supplier_id,
                                        'trans_ref' => $supplier_inv_id,
                                        'trans_date' => strtotime("now"),
                                        'account' => 5, //5 inventory GL
                                        'account_code' => 1510, //5 inventory GL
                                        'memo' => '',
                                        'amount' => +($total),
                                        'currency_code' =>$cur_det['code'],
                                        'currency_value' =>$cur_det['value'],
                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                        'status' => 1,
                                ),array(
                                        'person_type' => 20,
                                        'person_id' => $supplier_id,
                                        'trans_ref' => $supplier_inv_id,
                                        'trans_date' => strtotime("now"),
                                        'account' => 14, //14 AC Payable GL
                                        'account_code' => 2100, //inventory GL
                                        'memo' => '',
                                        'amount' => (-$total),
                                        'currency_code' =>$cur_det['code'],
                                        'currency_value' =>$cur_det['value'],
                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                        'status' => 1,
                                )
                            );
            
                            $add_stat = $this->Items_CSV_model->add_db_gl($data_1);
                            if($add_stat[0]){
                                echo '<br><br>...........................................<br> GL ENTRY UPDATED SUCCESFULLY<br>';
                            }else{
                                echo ' <p style="color:red"> GL ENTRY - Error</p><br>';
                            }
            }
        }
        
        
        function stock_status_check($item_id,$loc_id,$uom,$units=0,$uom_2='',$units_2=0){ //updatiuon for item_stock table
            $this->load->model('Item_stock_model');
            $stock_det = $this->Item_stock_model->get_single_row('',"location_id = '$loc_id' and item_id = '$item_id'");
            $available_units= $available_units_2 = 0;
            $update_arr = array();
            if(empty($stock_det)){
                $insert_data = array(
                                        'location_id'=>$loc_id,
                                        'item_id'=>$item_id,
                                        'uom_id'=>$uom,
                                        'units_available'=>0,
                                        'units_on_order'=>0,
                                        'units_on_demand'=>0,
                                        );
                if($uom_2!=''){
                    $insert_data['units_available_2'] = 0;
                    $insert_data['uom_id_2'] = $uom_2;
                }
                $this->Item_stock_model->add_db($insert_data);
                $available_units = $units;
                $available_units_2 = $units_2;
            }else{
                $available_units = $stock_det['units_available'] + $units;
                $available_units_2 = $stock_det['units_available_2'] + $units_2;
            }
                $update_arr = array('location_id'=>$loc_id,'item_id'=>$item_id,'new_units_available'=>$available_units,'new_units_available_2'=>$available_units_2);
            return $update_arr;
        }
}
