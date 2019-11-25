<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function barcode_print_items($item_id, $purchase_id=''){
    $CI =& get_instance();
    $CI->load->model("Items_model");
    //load library
    $CI->load->library('Pdf');
    $pdf = new Pdf('L', 'mm', array('32','25'), true, 'UTF-8', false);
    
    $pdf->setPrintHeader(false);  // remove default header 
    $pdf->setPrintFooter(false);  // remove default footer 
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// set default monospaced font
    $pdf->SetMargins(10, 15, 10); // set margins
    $pdf->SetAutoPageBreak(TRUE, 0); // set auto page breaks
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);// set image scale factor
            
    // ---------------------------------------------------------
    $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
    $pdf->SetFont('helveticaB','',4.5);  // set font


    // Barcode
    require_once dirname(__FILE__) . '/../libraries/tcpdf/tcpdf_barcodes_1d.php';
    $html = '';
    
        $CI->load->model('Purchasing_items_model');
        $inv_items =  $CI->Purchasing_items_model->get_invc_desc($purchase_id);

        if($purchase_id==''){
            $inv_items[0]['item_id'] = $item_id;
        }
        
        if(!empty($inv_items)){
            foreach($inv_items as $item){
                $item_id = $item['item_id'];
                $pdf->AddPage('L',array('32','25'));
                $item_info = $CI->Items_model->get_single_row($item_id);
                $item_stock = $CI->Items_model->get_item_status($item_id);
                $item_standard_price_info = $CI->Items_model->get_item_purch_prices($item_id, 'ip.item_price_type=3'); //std cost type=1
                $item_sale__price_info = $CI->Items_model->get_item_purch_prices($item_id, 'ip.item_price_type=2 AND ip.sales_type_id=15'); //sale type=2
                $item_info = $item_info[0];

                // echo '<pre>' ; print_r($item_info);die; 
                $barcodeobj = new TCPDFBarcode($item_info['item_code'], 'C39');
                $img =  $barcodeobj->getBarcodePngData(1.5,35, array(25,25,25)); 
                $base64 = 'data:image/png;base64,' . base64_encode($img);  
                    
                $dimension = (($item_info['length']>0)?$item_info['length'].' x ':'').(($item_info['width']>0)?$item_info['width'].' x ':'').(($item_info['length']>0)?$item_info['height']:'');
                $dimension = ($dimension!="")?$dimension.' mm '.$item_info['size']:$item_info['size'];

                $purch_price = (!empty($item_standard_price_info))?$item_standard_price_info[0]:0;
                $sale_price = (!empty($item_sale__price_info))?$item_sale__price_info[0]:0;
                $html ='
                
                        <table border="0">
                            <tr>
                                <td align="center"  colspan="2"><h3>'.SYSTEM_NAME.'</h3></td>
                            </tr>
                            <tr>
                                <td  colspan="2">'.$item_info['item_name'].(($item_info['color']!='')?' ('.$item_info['color_name'].')':'').' </td>
                            </tr>
                            <tr>
                                <td  colspan="2">Size: '.(($dimension!="")?$dimension:'--').'</td>
                            </tr>
                            <tr>
                                <td  colspan="2">Treatment: '.$item_info['treatment_name'].'</td>
                            </tr>
                            <tr>
                                <td  colspan="2">Ref No: '.(($purch_price!=0)?$purch_price['supplier_invoice_no']:'').' </td>
                            </tr>
                            <tr>
                                <td  colspan="2">'.$item_info['cost_code'].'</td>
                            </tr>
                            <tr>
                                <td colspan="2">Price: '.(($sale_price!=0)?$sale_price['symbol_left'].number_format($sale_price['cost_amount'],2):'-').'</td>
                            </tr>
                            <tr>
                                <td colspan="1"> '.$item_stock[0]['units_available'].$item_stock[0]['uom_name'].' '.(($item_stock[0]['units_available_2']>0)?$item_stock[0]['units_available_2'].' '.$item_stock[0]['uom_name_2']:'').'</td>
                                <td align="right" colspan="1"> '.$item_info['item_code'].'</td>
                            </tr>
                            <tr>
                                <td  colspan="2"><img style="width:100px;" src="'.$base64.'"></td>
                            </tr>
                        </table>
                ';
                
                $pdf->writeHTMLCell(30, 22, 0.5, 0.5, $html); 
            }
        }
    
    
    


    

    $pdf_output = $pdf->Output('barcode_purch.pdf', 'I');
}