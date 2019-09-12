<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode_jewelrt_print extends CI_Controller {
  
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
            $data['main_content']='reports_all/inventory/barcode_print_tags/search_summary_report'; 
            $data['supplier_list'] = get_dropdown_data(SUPPLIERS,'supplier_name','id','Supplier');
            $data['item_category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','No Category');
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
            $invoices = $this->load_data(); 
            $this->load->view('reports_all/inventory/barcode_print_tags/search_summary_report_result',$invoices);
	} 
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
//            $report_data = $this->load_data_barcode();
            $get_data = $this->input->get();
            $company_dets = get_single_row_helper(COMPANIES,'id = '.$this->session->userdata(SYSTEM_CODE)['company_id']);
            $tag_list = array();
            
            if(isset($get_data['item_ids']) && !empty($get_data['item_ids'])){
                $tag_list = $get_data['item_ids'];
            }
//            echo '<pre>';            print_r($tag_list); die; 
            
            
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, array(210,313), true, 'UTF-8', false);
            $pdf->fl_header='header_empty';//invice bg
            
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF AM Invoice');
            $pdf->SetSubject('AM Invoice');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            
            $pdf->setPrintHeader(false);  // remove default header 
            $pdf->setPrintFooter(false);  // remove default footer 
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// set default monospaced font
            $pdf->SetMargins(10, 1, 10); // set margins
            $pdf->SetAutoPageBreak(FALSE, 0); // set auto page breaks
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);// set image scale factor
                    
            // ---------------------------------------------------------
            $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
                    
            // set font
            $pdf->SetFont('times', '', 10);
        
        
            $pdf->AddPage('P', array(210,313));  
            
            // define barcode style
                $style = array(
                    'position' => '',
                    'align' => 'C',
                    'stretch' => false,
                    'fitwidth' => true,
                    'cellfitalign' => '',
                    'border' => false,
                    'hpadding' => 'auto',
                    'vpadding' => 'auto',
                    'fgcolor' => array(0,0,0),
                    'bgcolor' => false, //array(255,255,255),
                    'text' => true,
                    'font' => 'helvetica',
                    'fontsize' => 8,
                    'stretchtext' => 4
                );
                
                
                $from=1; $to=100;$arr_key=0;
                $bc_arr = array(); 
                $count=1;
                $html = '<table border="0" style="padding:3 0 0 -1;"><tbody>
                            <tr> 
                                <td class="left-tbl-td" width="34mm">
                                    <table border="0">';
                                        foreach($tag_list as $tag){
                                             
                                            require_once dirname(__FILE__) . '/../../libraries/tcpdf/tcpdf_barcodes_1d.php';
                                            $barcodeobj = new TCPDFBarcode($tag['code'], 'C128');
                                            $img =  $barcodeobj->getBarcodePngData(1.5,20); 
                                            $base64 = 'data:image/png;base64,' . base64_encode($img);  

                                            $item_seriel = $tag['code'];
                                            $item_desc = $tag['cat_code'];
                                            $supcode = $tag['supcode'];
                                            for($k=1;$k<=$tag['nos'];$k++){
                                                $bc_arr[$count] = array(
                                                                    'sup_info'=>'AG',
                                                                    'base64'=>$base64,
                                                                    'item_serial'=>$item_seriel,
                                                                    'item_desc'=>$item_desc,
                                                                    'supcode'=>$supcode,
                                                                    );
                                                $count++;
                                            }
                                        }
                                        
                                        $chunked = array_chunk($bc_arr, 23);
//                echo '<pre>';                print_r($chunked); die;
                                foreach ($chunked[0] as $bc){
                                    
                                            $html.='<tr>
                                                        <td style="line-height:11.8mm;">
                                                            <table>
                                                                <tr><td style=" text-align:center;line-height:7mm"><img style="width:45px;" src="'.$bc["base64"].'"></td></tr>
                                                                <tr><td style="font-size:8px; text-align:center; line-height:1mm">'.$bc['item_serial'].'</td></tr>
                                                            </table>
                                                        </td>
                                                        <td style="font-size:5px; text-align:center;line-height:11.8mm;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td colspan="2" style="font-size:5px; text-align:center;line-height:5.5mm;"><img style="height:4mm;" src="'.OTHER_IMAGES.'carablack.png"></td>
                                                                     
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size:6px; text-align:center;line-height:5.5mm;">'.$bc['item_desc'].'</td>
                                                                    <td style="font-size:6px; text-align:center;line-height:5.5mm;">'.$bc['supcode'].'</td>
                                                                </tr>
                                                            </table>
                                                            
                                                        </td>
                                                    </tr> 
                                                    <tr><td style="line-height:1.45mm;"></td></tr>';
                                }
//                                            echo '<pre>';                                            print_r($bc_arr); die;
                                $html .= '</table>
                                </td> 
                                <td width="35mm"></td> 
                                <td class="left-tbl-td" width="34mm">
                                    <table border="0">
                                        <tr><td colspan="2" style="line-height:5mm;"></td></tr>';
                                        if(isset($chunked[1]) && !empty($chunked[1])){
                                            
                                            foreach ($chunked[1] as $bc){

                                                        $html.='<tr>
                                                                    <td style="line-height:11.8mm;">
                                                                        <table>
                                                                            <tr><td style=" text-align:center;line-height:7mm"><img style="width:45px;" src="'.$bc["base64"].'"></td></tr>
                                                                            <tr><td style="font-size:8px; text-align:center; line-height:1mm">'.$bc['item_serial'].'</td></tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="font-size:5px; text-align:center;line-height:11.8mm;">
                                                                        <table border="0">
                                                                            <tr>
                                                                                <td colspan="2" style="font-size:5px; text-align:center;line-height:5.5mm;"><img style="height:4mm;" src="'.OTHER_IMAGES.'carablack.png"></td>

                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-size:6px; text-align:center;line-height:5.5mm;">'.$bc['item_desc'].'</td>
                                                                                <td style="font-size:6px; text-align:center;line-height:5.5mm;">'.$bc['supcode'].'</td>
                                                                            </tr>
                                                                        </table>

                                                                    </td>
                                                                </tr> 
                                                                <tr><td style="line-height:1.45mm;"></td></tr>';
                                            }
                                }
                                $html .= '</table>
                                </td> 
                                <td width="2mm"></td>
                            </tr>
                        <tbody></table> 
                        <style>
                        </style>
                        ';
                $pdf->writeHTMLCell(105,308,50,8,$html);
            $pdf->Output('barcode_.pdf', 'I');die; 
                if(!empty($tag_list)){
                    foreach ($tag_list as $tag_data){
                        
                    }
                }
                foreach ($report_data as $item_bc){

                    require_once dirname(__FILE__) . '\..\..\libraries\tcpdf\tcpdf_barcodes_1d.php';
                    $barcodeobj = new TCPDFBarcode($item_bc['item_code'], 'C128');
                    $img =  $barcodeobj->getBarcodePngData(1.5,20); 
                    $base64 = 'data:image/png;base64,' . base64_encode($img);  

                    $item_seriel = $item_bc['item_code'];
                    $item_desc = $item_bc['supplier_item_desc'];
                    for($i=0;$i<$item_bc['purchasing_unit'];$i++){
                        $bc_arr[$count] = array(
                                            'sup_info'=>'AG',
                                            'base64'=>$base64,
                                            'item_serial'=>$item_seriel,
                                            'item_desc'=>$item_desc,
                                            );
                        $count++;
                    }
                    
                }
                $bc_count = count($bc_arr);
                $to=$bc_count;
//            echo '<pre>';            print_r($bc_count); die; 
                   
                $rows = ($bc_count-($bc_count%6))/6; 
                if(($bc_count%6)>0){
                    $rows++;
                }
                //if($rows < 1){$rows=1;}
                $html = '<table border="0.2" cellpadding="2" ><tbody>
                    <tr>
                        <td width="2.9%"></td>
                        <td width="96.2%" colspan="6" style="line-height:9mm;"></td>
                        <td width="2.9%"></td>
                    </tr>';
                $sticker_count = 1;
                //$rows =18;
                for($i=0;$i<$rows;$i++){
                 $html .= '<tr> 
                                       <td width="2.9%"></td>';
                                       for($k=0;$k<6;$k++){
                                           if($sticker_count>=$from & $sticker_count<=$to){
                                            $html .= '<td style="padding:10px; overflow:hidden;"><table border="0" >
                                                         <tr>
                                                             <td colspan="4"  style="line-height:1.2mm;padding-top: 2px;"></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:2.30mm;padding-top: 2px;"><span style="text-align:center;font-size:9px;">'.$_SESSION[SYSTEM_CODE]['company_name'].'</span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td width="5%" style="line-height:1mm;"></td>
                                                             <td width="18%" style="line-height:6mm;"><p style="font-size:6px;">'.$bc_arr[$sticker_count]["sup_info"].'</p></td>
                                                             <td width="65%" style="line-height:6mm;"><img src="'.$bc_arr[$sticker_count]["base64"].'"></td>
                                                             <td width="3%" style="line-height:6mm;"></td>
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:1.9mm;"><span style="font-size:7.5px;text-align:center">'.$bc_arr[$sticker_count]["item_serial"].'</span></td>
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:1.9mm;"><span style="font-size:7px;text-align:center">'.$bc_arr[$sticker_count]["item_desc"].'</span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:0.8mm;padding-top: 2px;"></td> 
                                                         </tr>
                                                     </table>
                                                     </td>  '; 
                                            }else{
                                                $html .= '<td style="padding:10px; overflow:hidden;"><table border="0" >
                                                         <tr>
                                                             <td colspan="4"  style="line-height:1.2mm;padding-top: 2px;"></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:2.30mm;padding-top: 2px;"><span style="text-align:center;font-size:9px;"></span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td width="5%" style="line-height:1mm;"></td>
                                                             <td width="18%" style="line-height:6mm;"><p style="font-size:6px;"></p></td>
                                                             <td width="65%" style="line-height:6mm;"></td>
                                                             <td width="3%" style="line-height:6mm;"></td>
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:1.9mm;"><span style="font-size:7.5px;text-align:center"></span></td>
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:1.9mm;"><span style="font-size:7px;text-align:center"></span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:0.8mm;padding-top: 2px;"></td> 
                                                         </tr>
                                                     </table>
                                                     </td>  '; 
                                            }
                                           $sticker_count++;
                                       }

                                     $html .= '   <td width="2.9%"></td>
                                </tr> ';
                        }
                         $html .= '</tbody></table>'; 
                //         echo $html; die;
                // print a block of text using Write()
                $pdf->writeHTMLCell(210,20,0,0,$html);

        // ---------------------------------------------------------



        //Close and output PDF document
        $pdf->Output('barcode_.pdf', 'I');
        }
        public function print_report_rolltype($width='63',$height='25'){ 
            
            $content_height = $height-4; //top and bottom margin 2mm
//            $this->input->post() = 'aa';
            $this->load->model('Company_model');
            $company_dets = $this->Company_model->get_single_row($_SESSION[SYSTEM_CODE]['company_id']);
            $comp_logo = COMPANY_LOGO.$company_dets[0]['logo'];
            
            $report_data = $this->load_data_barcode(); 
            //load library
            $this->load->library('Pdf');
            $pdf = new Pdf('L', 'mm', array($width,$height), true, 'UTF-8', false);
                    
           
            $pdf->setPrintHeader(false);  // remove default header 
            $pdf->setPrintFooter(false);  // remove default footer 
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// set default monospaced font
            $pdf->SetMargins(0, 1, 0); // set margins
            $pdf->SetAutoPageBreak(TRUE, 0); // set auto page breaks
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);// set image scale factor
                    
            // ---------------------------------------------------------
            $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
            $pdf->SetFont('helveticaB','',7);  // set font 
            $pdf->AddPage('L',array($width,$height));
          
                
                 
                
//            echo '<pre>';            print_r($company_dets); die; 
                $from=1; $to=100;$arr_key=0;
                $bc_arr = array(); 
                $count=1;
                $html = '';
                foreach ($report_data as $item_bc){
                    
//            echo '<pre>';            print_r($item_bc); die; 
                    require_once dirname(__FILE__) . '/../../libraries/tcpdf/tcpdf_barcodes_1d.php';
                    $barcodeobj = new TCPDFBarcode($item_bc['item_code'], 'C128');
                    $img =  $barcodeobj->getBarcodePngData(1.5,20, array(80,80,80)); 
                    $base64 = 'data:image/png;base64,' . base64_encode($img);
                    
                $pdf->SetTextColor(80,80,80);
                $fontname = TCPDF_FONTS::addTTFfont('storage/fonts/Lato-Light.ttf', 'TrueTypeUnicode', '', 96);
                $pdf->SetFont($fontname, 'I', 8.5);
                
                    $item_seriel = $item_bc['item_code'];
                    $item_desc = $item_bc['supplier_item_desc']; 
                        $bc_arr = array(
                                            'sup_info'=>'AG',
                                            'base64'=>$base64,
                                            'item_serial'=>$item_seriel,
                                            'item_desc'=>$item_desc,
                                            );
                        
                    $html .= '<table style="width:'.$width.'mm;height:'.$height.';mm" border="0">
                                <tr><td colspan="2" style="line-height:1mm;"></td></tr>
                                <tr>
                                    <td width="20%" style="text-align:center; line-height:'.($content_height*0.35).'mm;"><img style="height:'.($content_height*0.35).'mm;" src="'.$comp_logo.'"></td>
                                    <td width="90%">'.$company_dets[0]['company_name'].'</td> 
                                </tr> 
                                <tr>
                                    <td width="50%" style="text-align:left; line-height:'.($content_height*0.15).'mm;">'.$item_seriel.'</td>
                                    <td width="50%" style="text-align:right;">'.$item_bc['purchasing_unit'].' '.$item_bc['unit_abbreviation'].' '.(($item_bc['secondary_unit']>0)?' | '.$item_bc['secondary_unit'].' '.$item_bc['unit_abbreviation_2']:'').'</td> 
                                </tr> 
                                <tr><td colspan="2" style="line-height:1mm;"></td></tr>
                                <tr>
                                    <td colspan="2" width="100%" style="text-align:center;line-height:'.($content_height*0.45).'mm;"><img style="height:'.($content_height*0.35).'mm;"src="'.$base64.'"></td>
                                </tr>  
                            </table>';
                    
                }
                $pdf->writeHTMLCell($width,'',0,0,$html);
//                         echo $html; die;
//                 print a block of text using Write()

        // ---------------------------------------------------------



        //Close and output PDF document
        $pdf->Output('barcode_.pdf', 'I');
        }
        
        public function  load_data(){
            $invoices = array();
            $input_post = $this->input->post();
            $input_get = $this->input->get();
            $input = (empty($input_post))? $input_get:$input_post; 
            $this->load->model("Payments_model"); 
             
            $list['search'] = $this->Reports_all_model->get_purchased_items($input);
            //search invoices  
//            echo '<pre>';            print_r($invoice_list); die; 
            return $list;
        }
        public function  load_data_barcode(){
            $invoices = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post(); 
            $this->load->model("Purchasing_invoices_model");
            $purch_info = $this->Purchasing_invoices_model->get_invc_desc($input['prc_id']);
             
            return $purch_info;
        }
}
