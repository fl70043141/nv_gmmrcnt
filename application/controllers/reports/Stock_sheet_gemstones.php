<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_sheet_gemstones extends CI_Controller {
  
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
            $data['main_content']='reports_all/inventory/stock_sheet_gemstones/search_stock_sheet_report'; 
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_name','id','Location');
            $data['item_cat_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','No Gem Category','is_gem = 1');
            
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
            $this->load->view('reports_all/inventory/stock_sheet_gemstones/search_stock_sheet_report_result',$data);
	} 
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
            $item_stocks_cat = $this->load_data(); 
            $input_get = $this->input->get();
            $first_page_header_only = (isset($input_get['print_firs_header_only']) && $input_get['print_firs_header_only']==1)?1:0;
//            echo '<pre>';            print_r($input_get); die; 
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header= ($first_page_header_only==1)?'header_empty':'header_jewel';//invice bg//invice bg
            $pdf->fl_header_title='Report';//invice bg
            $pdf->fl_header_title_RTOP='Stock Sheet';//invice bg
            
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
            $html = '';
             
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
                $pdf->SetFont('times', '', 9.4);
                $pdf->SetTextColor(32,32,32);
            
            $html .= '<table id="example1" class="table-line" border="0">
                                                    <thead> 
                                                        <tr style=""> 
                                <th width="12%" align="center"><b>Code</b></th> 
                                <th width="23%" align="center"><b>Desc</b></th> 
                                <th width="9%" align="center"><b>Treatment</b></th> 
                                <th width="9%" align="center"><b>color</b></th> 
                                <th width="9%" align="center"><b>shape</b></th> 
                                <th width="13%" align="right" colspan="1"><b>In Stock</b></th> 
                                <th width="13%" align="right" colspan="1"><b>On Lapidary</b></th>  
                                <th width="13%" align="right" colspan="1"><b>On Consignee</b></th>
                            </tr> 
                        </thead>
                        <tbody>';  
            $i=1; 
            
            foreach ($item_stocks_cat as $item){
//            echo '<pre>';            print_r($item); die;
             
                        if($item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                           $html .= '<tr>
                                        <td width="12%" align="center">'.$item['item_code'].'</td>
                                        <td width="23%" align="center" >'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].')</b>':'').'</td>
                                        <td width="9%" align="center" >'.$item['treatment_name'].'</td>
                                        <td width="9%" align="center" >'.$item['color_name'].'</td>
                                        <td width="9%" align="center" >'.$item['shape_name'].'</td>
                                        <td width="13%" align="right" >'.$item['units_available'].' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$item['units_available_2'].' '.$item['uom_name_2']:'').'</td> 
                                        <td width="13%" align="right">'.$item['units_on_workshop'].' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$item['units_on_workshop_2'].' '.$item['uom_name_2']:'').'</td>
                                        <td width="13%" align="right">'.$item['units_on_consignee'].' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$item['units_on_consignee_2'].' '.$item['uom_name_2']:'').'</td>

                                    </tr>';
                            }   
                $i++;
            } 
            
            $html .= '</tbody> </table> ';
            
           $html .= '
            <style>
            .colored_bg{
                background-color:#E0E0E0;
            }
            .table-line th, .table-line td {
                padding-bottom: 2px;
                border-bottom: 1px solid #ddd; 
            }
            .text-right,.table-line.text-right{
                text-align:right;
            }
            .table-line tr{
                line-height: 20px;
            }
            </style>
                    ';
//           echo $header_info.$html; die;
//            echo '<pre>';            print_r($html); die;
            $pdf->writeHTMLCell(190,'',10,(($first_page_header_only==1)?50:''),$html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);            
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
//            $pdf->IncludeJS($js);
            $pdf->Output('Purchase_Summary.pdf', 'I');
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
//            foreach ($item_stocks as $item_stock){
//                $ret_arr[$item_stock['item_category_id']]['item_category_name'] = $item_stock['item_category_name'];
//                $ret_arr[$item_stock['item_category_id']]['item_list'][$item_stock['item_id']] = $item_stock;
//            } 
            
//            echo '<pre>';            print_r($ret_arr); die; 
            return $item_stocks;
        }
        
        function print_report2(){
//            echo 'kokoko';
             
//            $this->input->post() = 'aa';
            $item_stocks_cat = $this->load_data(); 
            $input_get = $this->input->get();
            $first_page_header_only = (isset($input_get['print_firs_header_only']) && $input_get['print_firs_header_only']==1)?1:0;
//            echo '<pre>';            print_r($input_get); die;  
            $this->load->model('Items_model');
             
            $html = ''; 
            
            $html .= '<table width="100%" id="example1" class="table-line" border="0">
                                                    <thead> 
                                                        <tr style=""> 
                                <th width="12%" align="center"><b>Code</b></th> 
                                <th width="23%" align="center"><b>Desc</b></th> 
                                <th width="9%" align="center"><b>Treatment</b></th> 
                                <th width="9%" align="center"><b>color</b></th> 
                                <th width="9%" align="center"><b>shape</b></th> 
                                <th width="13%" align="right" colspan="1"><b>In Stock</b></th> 
                                <th width="13%" align="right" colspan="1"><b>On Lapidary</b></th>  
                                <th width="13%" align="right" colspan="1"><b>On Consignee</b></th>
                            </tr> 
                        </thead>
                        <tbody>';  
            $i=1; 
            
            foreach ($item_stocks_cat as $item){
//            echo '<pre>';            print_r($item); die;
             
                        if($item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                           $html .= '<tr>
                                        <td width="12%" align="center">'.$item['item_code'].'</td>
                                        <td width="23%" align="center" >'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].')</b>':'').'</td>
                                        <td width="9%" align="center" >'.$item['treatment_name'].'</td>
                                        <td width="9%" align="center" >'.$item['color_name'].'</td>
                                        <td width="9%" align="center" >'.$item['shape_name'].'</td>
                                        <td width="13%" align="right" >'.$item['units_available'].' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$item['units_available_2'].' '.$item['uom_name_2']:'').'</td> 
                                        <td width="13%" align="right">'.$item['units_on_workshop'].' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$item['units_on_workshop_2'].' '.$item['uom_name_2']:'').'</td>
                                        <td width="13%" align="right">'.$item['units_on_consignee'].' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$item['units_on_consignee_2'].' '.$item['uom_name_2']:'').'</td>

                                    </tr>';
                            }   
                $i++;
            } 
            
            $html .= '</tbody> </table> ';
            
           $html .= '
            <style>
            .colored_bg{
                background-color:#E0E0E0;
            }
            .table-line th, .table-line td {
                padding-bottom: 2px;
                border-bottom: 1px solid #ddd; 
            }
            .text-right,.table-line.text-right{
                text-align:right;
            }
            .table-line tr{
                line-height: 20px;
                font-family: "arial";
                font-size:11px;
            }
            </style>
                    ';
//           echo $html; die; 
           
            $this->load->library('DomPDFgen');
            // Instantiate and use the dompdf class 
          
            $dompdf = new DomPDFgen();

            // Load HTML content 
            $dompdf->loadHtml($html); 
//            $dompdf->
            // (Optional) Setup the paper size and orientation 
            $dompdf->setPaper('A4', 'portrait'); 

            // Render the HTML as PDF 
            $dompdf->render(); 

            // Output the generated PDF to Browser 
            $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        }
}
