<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_costing extends CI_Controller {
  
        function __construct() {
            parent::__construct();
            $module =$this->load->model('Reports_all_model');
        }

        public function index(){ 
              //I'm just using rand() function for data example 
            $this->view_search_report();
	}
        public function view_search_report(){
            
//            $this->add();
//            $data['search_list'] = $this->Sales_invoices_model->search_result();
            $data['main_content']='reports_all/inventory/stock_costing/search_stock_costing_report'; 
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_name','id','Location');
            $data['item_cat_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','No Gem Category');
            
            $data['treatments_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Treatment','dropdown_id = 5'); //14 for treatments
            $data['shape_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Shape','dropdown_id = 16'); //16 for Shape
            $data['color_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Color','dropdown_id = 17'); //17 for Color
            $data['item_type_list'] = get_dropdown_data(ITEM_TYPES,'item_type_name','id','No Item Type'); 
            
            $this->load->view('includes/template',$data);
        }
        
        function fl_ajax(){
            
//            echo '<pre>';            print_r($this->input->post()); die;
            $func = $this->input->post('function_name');
            $param = $this->input->post();
            
            if(method_exists($this, $func)){ 
                (!empty($param))?$this->$func($param):$this->$func();
            }else{
                return false;
            }
        }
        
        public function search(){ //view the report
            $data['rep_data'] = $this->load_data(); 
            $this->load->view('reports_all/inventory/stock_costing/search_stock_costing_report_result',$data);
	} 
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
            $item_stocks_cat = $this->load_data(); 
            $inputs = $this->input->get();
            $first_page_header_only = (isset($inputs['print_firs_header_only']) && $inputs['print_firs_header_only']==1)?1:0;

//            echo '<pre>';            print_r($this->input->get()); die;
            $location_name = ($inputs['location_id'] != '')?get_single_row_helper(INV_LOCATION,'id = "'.$inputs['location_id'].'"')['location_name']:'All'; 
            $category_name = ($inputs['item_category_id'] != '')?get_single_row_helper(ITEM_CAT,'id = "'.$inputs['item_category_id'].'"')['category_name']:'All'; 
            $shape_name = ($inputs['shape_id'] != '')?get_single_row_helper(DROPDOWN_LIST,'id = "'.$inputs['shape_id'].'"')['dropdown_value']:'All'; 
            $treatment_name = ($inputs['treatment_id'] != '')?get_single_row_helper(DROPDOWN_LIST,'id = "'.$inputs['treatment_id'].'"')['dropdown_value']:'All'; 
            $color_name = ($inputs['color_id'] != '')?get_single_row_helper(DROPDOWN_LIST,'id = "'.$inputs['color_id'].'"')['dropdown_value']:'All'; 
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
             $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
           
            $pdf->fl_header= ($first_page_header_only==1)?'header_empty':'header_jewel';//invice bg
            $pdf->fl_header_title='Report';//invice bg
            $pdf->fl_header_title_RTOP='Stock Purchasing Valuation';//invice bg
            //
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF AM Invoice');
            $pdf->SetSubject('AM Invoice');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            
            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, (($first_page_header_only==1)?10:50), PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    
        
        
            $pdf->AddPage();      
            $html =""; 
            
            
            if($first_page_header_only == 1){
                $this->load->model('Company_model');
                $company_dets = $this->Company_model->get_single_row($_SESSION[SYSTEM_CODE]['company_id']);
        //        echo '<pre>'; print_r($company_dets); die;
                $header_info = '<table border="0"> 
                                    <tr>
                                        <td align="center">'.$company_dets[0]['street_address'].', '.$company_dets[0]['city'].', '.$company_dets[0]['country_name'].'.</td>
                                    </tr> 
                                    <tr>
                                        <td align="center">Phone: '.$company_dets[0]['phone'].(($company_dets[0]['other_phone']!='')?', '.$company_dets[0]['other_phone']:'').'</td>
                                    </tr>
                                    <tr>
                                        <td align="center">Email: '.(($company_dets[0]['email']!='')?$company_dets[0]['email']:'').'</td>
                                    </tr>
                                    <tr>
                                        <td align="center">Website: '.(($company_dets[0]['website']!='')?$company_dets[0]['website']:'').'</td>
                                    </tr>

                                </table> ';
                $header_right_info = '<table border=""> 
                                    <tr>
                                        <td style="height:50px;" align="right">'.$pdf->fl_header_title_RTOP.'</td>
                                    </tr>   
                                    <tr>
                                        <td style="height:35px;" align="right"><img src="'. base_url(DEFAULT_IMAGE_LOC.'gema.png').'"></td>
                                    </tr>   
                                    <tr>
                                        <td style="height:30px; font-size:25px;" align="right"><b>'.$pdf->fl_header_title.'</b></td>
                                    </tr>   
                                </table> ';


                $image_file = COMPANY_LOGO.$company_dets[0]['logo'];

                $source_properties = getimagesize($image_file); 
                $image_file = COMPANY_LOGO.$company_dets[0]['logo'];
                $pdf->Image($image_file, 9, 10, '', 35, (($source_properties[2]==IMAGETYPE_JPEG)?'JPG':'PNG'), '', 'T', false, 300, '', false, false, 0, false, false, false);


                $pdf->SetTextColor(48,75,105);
                $fontname = TCPDF_FONTS::addTTFfont('storage/fonts/CanelaBarkBold_PERSONAL.ttf', 'TrueTypeUnicode', '', 96);
                // use the font
                $pdf->SetFont($fontname, '', 35, '', false);
                $pdf->SetTextColor(48,75,105);
                $pdf->Text('60', 9, $company_dets[0]['company_name'], false, false, true, 0, 0, 'center', false,'',1);

                $pdf->SetTextColor(96,96,96);
                $fontname = TCPDF_FONTS::addTTFfont('storage/fonts/Lato-Light.ttf', 'TrueTypeUnicode', '', 96);
                $pdf->SetFont($fontname, 'I', 10.5);
                $pdf->writeHTMLCell(130,20,40,23,$header_info); 
        //        $this->writeHTMLCell(90,20,60,23,$header_info); 

                $pdf->writeHTMLCell(45,20,155,9,$header_right_info); 
  
                $pdf->Line(10, 48, 200, 48); 

            }
            
            
            // set font
            $pdf->SetFont('times', '', 9);
            $pdf->SetTextColor(32,32,32);  
            $all_tot_units = $all_tot_units_2 = $all_tot_amount = $item_count = 0;
            $i = 1; 
            foreach ($item_stocks_cat as $item_stocks){
//            echo '<pre>';            print_r($item_stocks); die;
            $html .= '<table  class="table-line" border="0">
                        <thead>
                            <tr class="">
                                <th align="left" colspan="6"></th>
                            </tr>
                            <tr class="">
                                <th align="left" colspan="6">'.$i.'. <u>'.$item_stocks['item_category_name'].'</u></th>
                            </tr>
                            <tr class="colored_bg">
                                <th width="3%" align="center">#</th> 
                                <th width="10%" align="center">Code</th> 
                                <th width="16%" align="center">Desc</th> 
                                <th width="9%" align="center">CDC</th> 
                                <th width="10%" align="center">Color</th> 
                                <th width="10%" align="center">Shape</th>  
                                <th width="16%" align="center">Units</th>  
                                <th width="13%" align="right">Unit Cost('.$def_cur['code'].')&nbsp;&nbsp;</th>  
                                <th width="13%" align="right">Total Cost('.$def_cur['code'].')&nbsp;&nbsp;</th>  
                            </tr> 
                        </thead>
                        <tbody>';
                        $j = 1;
                        $cat_tot_units = $cat_tot_units_2 = $cat_tot_amount = 0;
                       foreach ($item_stocks['item_list'] as $item){  
                                        $tot_units = $item['units_available'] + $item['units_on_workshop'] + $item['units_on_consignee'];
                                        $tot_units_2 = $item['units_available_2'] + $item['units_on_workshop_2'] + $item['units_on_consignee_2'];
                                        $cost = ($item['price_amount'] / $item['ip_curr_value']) * $tot_units;
                                        
                                        $cat_tot_units += $tot_units;
                                        $cat_tot_units_2 += $tot_units_2;
                                        $cat_tot_amount += $cost;
                                        
                                        $all_tot_units += $tot_units;
                                        $all_tot_units_2 += $tot_units_2;
                                        $all_tot_amount += $cost;
                                        
                                        if(isset($all_tot_uom[$item['uom_id']])){
                                            $all_tot_uom[$item['uom_id']]['unit1'] += $tot_units;
                                            $all_tot_uom[$item['uom_id']]['unit2'] += $tot_units_2; 
                                        }
                                        else{
                                            $all_tot_uom[$item['uom_id']]['unit1'] = $tot_units;
                                            $all_tot_uom[$item['uom_id']]['unit2'] = $tot_units_2; 
                                        }
                                        $all_tot_uom[$item['uom_id']]['unit_abr'] = $item['uom_name']; 
                                        $all_tot_uom[$item['uom_id']]['unit_abr_2'] = $item['uom_name_2']; 

                                        if($item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                                           $html .= '<tr>
                                                        <td width="3%" align="center" style="border-right: 1px solid #cdd0d4;border-left: 1px solid #cdd0d4;">'.$j.'</td>
                                                        <td width="10%" align="center" style="border-right: 1px solid #cdd0d4;border-left: 1px solid #cdd0d4;">'.$item['item_code'].'</td>
                                                        <td width="16%" align="center" style="border-right: 1px solid #cdd0d4;">'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].')</b>':'').'</td>
                                                        <td width="9%" align="center" style="border-right: 1px solid #cdd0d4;">'.$item['treatment_name'].'</td>
                                                        <td width="10%" align="center" style="border-right: 1px solid #cdd0d4;">'.$item['color_name'].'</td>
                                                        <td width="10%" align="center" style="border-right: 1px solid #cdd0d4;">'.$item['shape_name'].'</td>
                                                        <td width="16%" align="center" style="border-right: 1px solid #cdd0d4;" >'.$tot_units.' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$tot_units_2.' '.$item['uom_name_2']:'').'</td> 
                                                        <td width="13%" align="right" style="border-right: 1px solid #cdd0d4;">'. number_format(($item['price_amount'] / $item['ip_curr_value']),2).'&nbsp;&nbsp;</td>
                                                        <td width="13%" align="right" style="border-right: 1px solid #cdd0d4;">'. number_format($cost,2).' &nbsp;&nbsp;</td>

                                                    </tr>';
                                           
                                            $j++;
                                            $item_count++;
                                            }
                                        }      
                                            if($j>1){
                                                $html .= '<tr>
                                                                <td align="right" colspan="6" style="border-right: 1px solid #cdd0d4;border-left: 1px solid #cdd0d4;"><b>Total : </b></td>
                                                                <td width="16%" align="center" style="border-right: 1px solid #cdd0d4;">'.$cat_tot_units.' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$cat_tot_units_2.' '.$item['uom_name_2']:'').'</td>
                                                                <td ></td>
                                                                <td width="13%" align="right" style="border-right: 1px solid #cdd0d4;">'. number_format($cat_tot_amount,2).' &nbsp;&nbsp;</td>

                                                          </tr>';
                                            }
            $html .= '</tbody> 
                    </table> 
                ';               
                $i++;
            } 
//            echo '<pre>';            print_r($all_tot_uom); die;
            $html2 = '<table border="0">
                        <tr>
                            <td><b>Report: Gemstone Stock Purchasing Valuation</b></td>
                            <td align="center">Shape: '.$shape_name.' </td> 
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr>
                        <tr>
                            <td>Locarion: '.$location_name.' </td>
                            <td align="center">Color: '.$color_name.' </td>
                            <td align="right"></td>
                        </tr> 
                        <tr>
                            <td>Variety: '.$category_name.' </td>
                            <td align="center">CDC: '.$treatment_name.' </td>
                            <td align="right">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr> 
                        <tr><td colspan="3"></td></tr>
                        <tr>
                            <td colspan="3"><b>Total Valuation -</b><br>
                                Items: '.$item_count.'<br>
                                Units: ';
                                $i1=1;
                                foreach ($all_tot_uom as $uom_unts){
                                    $html2 .= $uom_unts['unit1'].' '.$uom_unts['unit_abr'].(($uom_unts['unit2']>0)?'  '.$uom_unts['unit2'].' '.$uom_unts['unit_abr_2']:''). (($i1 == count($all_tot_uom))?'':' | ');    
                                    $i1++;
                                }
                          $html2 .=  '<br> Total Cost: '.$def_cur['code'].' '. number_format($all_tot_amount,2).'</td>
                        </tr> 
                    </table> '.$html;
            $html2 .= '
                    <style>
                    .colored_bg{
                        background-color:#E0E0E0;
                    }
                    .table-line th, .table-line td {
                        padding-bottom: 2px;
                        border-bottom: 1px solid #ddd;
                        text-align:center; 
                    }
                    .text-right,.table-line.text-right{
                        text-align:right;
                    }
                    .table-line tr{
                        line-height: 20px;
                    }
                    .table-line td{ 
                        font-size: 6px;;
                    }
                    </style>';
            $pdf->writeHTMLCell(190,'',10,(($first_page_header_only==1)?50:''),$html2);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);            
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
//            $pdf->IncludeJS($js);
            $pdf->Output('Purchase_stock_valuation.pdf', 'I');
        }
        
        public function  load_data(){
            $invoices = array();
            $input_post = $this->input->post();
            $input_get = $this->input->get();
            $input = (empty($input_post))? $input_get:$input_post; 
//            echo '<pre>';            print_r($input); die;  
            $this->load->model("Reports_all_model");
            $item_stocks = $this->Reports_all_model->get_item_stocks_gemstones($input);
            
//            echo '<pre>';            print_r($item_stocks); die; 
            $ret_arr = array();
            foreach ($item_stocks as $item_stock){
                $ret_arr[$item_stock['item_category_id']]['item_category_name'] = $item_stock['item_category_name'];
                $ret_arr[$item_stock['item_category_id']]['item_list'][$item_stock['item_id']] = $item_stock;
            } 
            
//            echo '<pre>';            print_r($ret_arr); die; 
            return $ret_arr;
        }

        
        public function print_report2(){ 
//            $this->input->post() = 'aa';
            $item_stocks_cat = $this->load_data(); 
            $inputs = $this->input->get();
            $first_page_header_only = (isset($inputs['print_firs_header_only']) && $inputs['print_firs_header_only']==1)?1:0;

//            echo '<pre>';            print_r($this->input->get()); die;
            $location_name = ($inputs['location_id'] != '')?get_single_row_helper(INV_LOCATION,'id = "'.$inputs['location_id'].'"')['location_name']:'All'; 
            $category_name = ($inputs['item_category_id'] != '')?get_single_row_helper(ITEM_CAT,'id = "'.$inputs['item_category_id'].'"')['category_name']:'All'; 
            $shape_name = ($inputs['shape_id'] != '')?get_single_row_helper(DROPDOWN_LIST,'id = "'.$inputs['shape_id'].'"')['dropdown_value']:'All'; 
            $treatment_name = ($inputs['treatment_id'] != '')?get_single_row_helper(DROPDOWN_LIST,'id = "'.$inputs['treatment_id'].'"')['dropdown_value']:'All'; 
            $color_name = ($inputs['color_id'] != '')?get_single_row_helper(DROPDOWN_LIST,'id = "'.$inputs['color_id'].'"')['dropdown_value']:'All'; 
            $this->load->model('Items_model');
             $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//            
                 
            $html =""; 
              
            $all_tot_units = $all_tot_units_2 = $all_tot_amount = $item_count = 0;
            $i = 1; 
            foreach ($item_stocks_cat as $item_stocks){
//            echo '<pre>';            print_r($item_stocks); die;
            $html .= '<table  width="100%"  class="table-line" border="0">
                        <thead>
                            <tr class="">
                                <th align="left" colspan="9"></th>
                            </tr>
                            <tr class="">
                                <th style="text-align:left;" colspan="9">'.$i.'. <u>'.$item_stocks['item_category_name'].'</u></th>
                            </tr>
                            <tr class="colored_bg">
                                <th width="3%" align="center">#</th> 
                                <th width="10%" align="center">Code</th> 
                                <th width="16%" align="center">Desc</th> 
                                <th width="9%" align="center">CDC</th> 
                                <th width="10%" align="center">Color</th> 
                                <th width="10%" align="center">Shape</th>  
                                <th width="16%" align="center">Units</th>  
                                <th width="13%" align="right">Unit Cost('.$def_cur['code'].')&nbsp;&nbsp;</th>  
                                <th width="13%" align="right">Total Cost('.$def_cur['code'].')&nbsp;&nbsp;</th>  
                            </tr> 
                        </thead>
                        <tbody>';
                        $j = 1;
                        $cat_tot_units = $cat_tot_units_2 = $cat_tot_amount = 0;
                       foreach ($item_stocks['item_list'] as $item){  
                                        $tot_units = $item['units_available'] + $item['units_on_workshop'] + $item['units_on_consignee'];
                                        $tot_units_2 = $item['units_available_2'] + $item['units_on_workshop_2'] + $item['units_on_consignee_2'];
                                        $cost = ($item['price_amount'] / $item['ip_curr_value']) * $tot_units;
                                        
                                        $cat_tot_units += $tot_units;
                                        $cat_tot_units_2 += $tot_units_2;
                                        $cat_tot_amount += $cost;
                                        
                                        $all_tot_units += $tot_units;
                                        $all_tot_units_2 += $tot_units_2;
                                        $all_tot_amount += $cost;
                                        
                                        if(isset($all_tot_uom[$item['uom_id']])){
                                            $all_tot_uom[$item['uom_id']]['unit1'] += $tot_units;
                                            $all_tot_uom[$item['uom_id']]['unit2'] += $tot_units_2; 
                                        }
                                        else{
                                            $all_tot_uom[$item['uom_id']]['unit1'] = $tot_units;
                                            $all_tot_uom[$item['uom_id']]['unit2'] = $tot_units_2; 
                                        }
                                        $all_tot_uom[$item['uom_id']]['unit_abr'] = $item['uom_name']; 
                                        $all_tot_uom[$item['uom_id']]['unit_abr_2'] = $item['uom_name_2']; 

                                        if($item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                                           $html .= '<tr>
                                                        <td width="3%" align="center" style="border-right: 1px solid #cdd0d4;border-left: 1px solid #cdd0d4;">'.$j.'</td>
                                                        <td width="10%" align="center" style="border-right: 1px solid #cdd0d4;border-left: 1px solid #cdd0d4;">'.$item['item_code'].'</td>
                                                        <td width="16%" align="center" style="border-right: 1px solid #cdd0d4;">'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].')</b>':'').'</td>
                                                        <td width="9%" align="center" style="border-right: 1px solid #cdd0d4;">'.$item['treatment_name'].'</td>
                                                        <td width="10%" align="center" style="border-right: 1px solid #cdd0d4;">'.$item['color_name'].'</td>
                                                        <td width="10%" align="center" style="border-right: 1px solid #cdd0d4;">'.$item['shape_name'].'</td>
                                                        <td width="16%" align="center" style="border-right: 1px solid #cdd0d4;" >'.$tot_units.' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$tot_units_2.' '.$item['uom_name_2']:'').'</td> 
                                                        <td width="13%" align="right" style="border-right: 1px solid #cdd0d4;">'. number_format(($item['price_amount'] / $item['ip_curr_value']),2).'&nbsp;&nbsp;</td>
                                                        <td width="13%" align="right" style="border-right: 1px solid #cdd0d4;">'. number_format($cost,2).' &nbsp;&nbsp;</td>

                                                    </tr>';
                                           
                                            $j++;
                                            $item_count++;
                                            }
                                        }      
                                            if($j>1){
                                                $html .= '<tr>
                                                                <td align="right" colspan="6" style="border-right: 1px solid #cdd0d4;border-left: 1px solid #cdd0d4;"><b>Total : </b></td>
                                                                <td width="16%" align="center" style="border-right: 1px solid #cdd0d4;">'.$cat_tot_units.' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$cat_tot_units_2.' '.$item['uom_name_2']:'').'</td>
                                                                <td ></td>
                                                                <td width="13%" align="right" style="border-right: 1px solid #cdd0d4;">'. number_format($cat_tot_amount,2).' &nbsp;&nbsp;</td>

                                                          </tr>';
                                            }
            $html .= '</tbody> 
                    </table> 
                ';               
                $i++;
            } 
//            echo '<pre>';            print_r($all_tot_uom); die;
            $html2 = '<table width="100%" border="0">
                        <tr>
                            <td><b>Report: Gemstone Stock Purchasing Valuation</b></td>
                            <td align="center">Shape: '.$shape_name.' </td> 
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr>
                        <tr>
                            <td>Locarion: '.$location_name.' </td>
                            <td align="center">Color: '.$color_name.' </td>
                            <td align="right"></td>
                        </tr> 
                        <tr>
                            <td>Variety: '.$category_name.' </td>
                            <td align="center">CDC: '.$treatment_name.' </td>
                            <td align="right">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr> 
                        <tr><td colspan="3"></td></tr>
                        <tr>
                            <td colspan="3"><b>Total Valuation -</b><br>
                                Items: '.$item_count.'<br>
                                Units: ';
                                $i1=1;
                                foreach ($all_tot_uom as $uom_unts){
                                    $html2 .= $uom_unts['unit1'].' '.$uom_unts['unit_abr'].(($uom_unts['unit2']>0)?'  '.$uom_unts['unit2'].' '.$uom_unts['unit_abr_2']:''). (($i1 == count($all_tot_uom))?'':' | ');    
                                    $i1++;
                                }
                          $html2 .=  '<br> Total Cost: '.$def_cur['code'].' '. number_format($all_tot_amount,2).'</td>
                        </tr> 
                    </table> '.$html;
            $html2 .= '
                    <style>
                    .colored_bg{
                        background-color:#E0E0E0;
                    }
                    .table-line th, .table-line td {
                        padding-bottom: 2px;
                        border-bottom: 1px solid #ddd;
                        text-align:center; 
                    }
                    .text-right,.table-line.text-right{
                        text-align:right;
                    }
                    .table-line tr{
                        line-height: 20px;
                        font-family: "arial";
                        font-size:11px;
                    } 
                    </style>'; 
            
            $this->load->model('Company_model');
            $company_dets = $this->Company_model->get_single_row($_SESSION[SYSTEM_CODE]['company_id']);
            $header_info = '<table width="100%"  style="border-bottom: 2px solid #404040;">
                                <tr>
                                    <td width="15%">
                                        <img style="width:120px;"src="'. base_url(COMPANY_LOGO.$company_dets[0]['logo']).'">
                                    </td>
                                    <td width="65%"  align="center">
                                        <table border="0"> 
                                            <tr>
                                                <td align="center" style=" color: #105d8a; font-family: Lobster, cursive; font-size: 32px; font-weight: normal; line-height: 46px; margin: 0 0 18px; text-shadow: 1px 0 0 #fff;">'.$company_dets[0]['company_name'].'.</td>
                                            </tr> 
                                            <tr>
                                                <td align="center">'.$company_dets[0]['street_address'].', '.$company_dets[0]['city'].', '.$company_dets[0]['country_name'].'.</td>
                                            </tr> 
                                            <tr>
                                                <td align="center">Phone: '.$company_dets[0]['phone'].(($company_dets[0]['other_phone']!='')?', '.$company_dets[0]['other_phone']:'').'</td>
                                            </tr>
                                            <tr>
                                                <td align="center">Email: '.(($company_dets[0]['email']!='')?$company_dets[0]['email']:'').'</td>
                                            </tr>
                                            <tr>
                                                <td align="center">Website: '.(($company_dets[0]['website']!='')?$company_dets[0]['website']:'').'</td>
                                            </tr>

                                        </table> 
                                    </td>
                                    <td width="20%" align="right">
                                        <table border="0"> 
                                            <tr>
                                                <td style="height:50px;" align="right">Report</td>
                                            </tr>   
                                            <tr>
                                                <td style="height:35px;" align="right"><img src="'. base_url(DEFAULT_IMAGE_LOC.'gema.png').'"></td>
                                            </tr>   
                                            <tr>
                                                <td style="height:30px; font-size:25px;" align="right"><b>Stock Sheet</b></td>
                                            </tr>   
                                        </table> 
                                    </td>
                                </tr>
                            </table>'; 
            echo $header_info.$html2.$html;
            echo '<script> this.print(); </script>';
        }
}
