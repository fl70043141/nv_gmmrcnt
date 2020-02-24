<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function barcode_print_items($item_id, $purchase_id=''){
    $CI =& get_instance();
    $CI->load->model("Items_model");
    //load library
    $CI->load->library('Pdf');
    $pdf = new Pdf('L', 'mm', array('40','40'), true, 'UTF-8', false);
    
    $pdf->setPrintHeader(false);  // remove default header 
    $pdf->setPrintFooter(false);  // remove default footer 
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// set default monospaced font
    $pdf->SetMargins(10, 15, 10); // set margins
    $pdf->SetAutoPageBreak(TRUE, 0); // set auto page breaks
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);// set image scale factor
            
    // ---------------------------------------------------------
    $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
    $pdf->SetFont('helvetica','',6);  // set font


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
                $pdf->AddPage('L',array('40','40'));
                $item_info = $CI->Items_model->get_single_row($item_id);
                $item_stock = $CI->Items_model->get_item_status($item_id);
                $item_standard_price_info = $CI->Items_model->get_item_purch_prices($item_id, 'ip.item_price_type=3'); //std cost type=1
                $item_sale__price_info = $CI->Items_model->get_item_purch_prices($item_id, 'ip.item_price_type=2 AND ip.sales_type_id=15'); //sale type=2
                $item_info = $item_info[0];

                $barcodeobj = new TCPDFBarcode($item_info['item_code'], 'C39');
                $img =  $barcodeobj->getBarcodePngData(1.5,40, array(25,25,25)); 
                $base64 = 'data:image/png;base64,' . base64_encode($img);  
                    
                $dimension = (($item_info['length']>0)?$item_info['length'].' x ':'').(($item_info['width']>0)?$item_info['width'].' x ':'').(($item_info['length']>0)?$item_info['height']:'');
                $dimension = ($dimension!="")?$dimension.' mm '.$item_info['size']:$item_info['size'];

                $purch_price = (!empty($item_standard_price_info))?$item_standard_price_info[0]:0;
                $sale_price = (!empty($item_sale__price_info))?$item_sale__price_info[0]:0;

                // echo '<pre>' ; print_r($sale_price);die; 

                $html ='
                
                        <table border="0">
                            <tr>
                                <td align="center"  colspan="2"><h2>'.SYSTEM_NAME.'</h2></td>
                            </tr>
                            <tr><td colspan="2" style="line-height:5px;"></td></tr>
                            <tr>
                                <td  colspan="2"><b>'.$item_info['item_name'].(($item_info['color']!='')?' ('.$item_info['color_name'].')':'').(($item_info['certification']>0)?' - C':'').' </b></td>
                            </tr>
                            <tr>
                                <td  colspan="2">'.(($dimension=='')?'':$dimension.' ').$item_info['shape_name'].'</td>
                            </tr>
                            <tr>
                                <td  colspan="2">'.$item_info['treatment_name'].'</td>
                            </tr> 
                            <tr>
                                <td  colspan="2">'.$item_info['cost_code'].'</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="line-height:15px;"><h3>'.(($sale_price['cost_amount']>0)?$sale_price['symbol_left'].number_format($sale_price['price_amount'],2).' ('.$sale_price['symbol_left'].number_format($sale_price['cost_amount'],2).')':'-').'</h3></td>
                            </tr>
                        </table>
                        <style>
                            td{
                                line-height:10.5px;
                            }
                        </style>
                ';

                $html2 =  '<table border="0">
                                <tr>
                                    <td colspan="1"><b>'.$item_stock[0]['units_available'].$item_stock[0]['uom_name'].' '.(($item_stock[0]['units_available_2']>0)?'| '.$item_stock[0]['units_available_2'].' '.$item_stock[0]['uom_name_2']:'').'</b></td>
                                    <td align="right" colspan="1"> '.$item_info['item_code'].'</td>
                                </tr>
                            </table>';
                $pdf->Image($base64,1.5,31,37);
                $pdf->writeHTMLCell(39, 10, 0.5, 28, $html2); 
                $pdf->writeHTMLCell(39, 38, 0.5, 0.5, $html); 
            }
        }
    
    

    $pdf_output = $pdf->Output('barcode_purch.pdf', 'I');
}



function barcode_print_jwl_items($item_id, $purchase_id=''){
    $CI =& get_instance();
    $CI->load->model("Items_model");
    //load library
    $CI->load->library('Pdf');
    $pdf = new Pdf('L', 'mm', array('85','12'), true, 'UTF-8', false);
    
    $pdf->setPrintHeader(false);  // remove default header 
    $pdf->setPrintFooter(false);  // remove default footer 
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// set default monospaced font
    $pdf->SetMargins(2,2, 2); // set margins
    $pdf->SetAutoPageBreak(TRUE, 0); // set auto page breaks
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);// set image scale factor
            
    // ---------------------------------------------------------
    $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
    $pdf->SetFont('helvetica','',7);  // set font


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
                $pdf->AddPage('L',array('63','22.5'));
                $item_info = $CI->Items_model->get_single_row($item_id);
                // $item_stock = $CI->Items_model->get_item_status($item_id);
                $item_standard_price_info = $CI->Items_model->get_item_purch_prices($item_id, 'ip.item_price_type=1'); //std cost type=1
                // $item_sale__price_info = $CI->Items_model->get_item_purch_prices($item_id, 'ip.item_price_type=2 AND ip.sales_type_id=15'); //sale type=2
                $item_info = $item_info[0];

                // echo '<pre>' ; print_r($item_standard_price_info);die; 
                $barcodeobj = new TCPDFBarcode($item_info['item_code'], 'C39');
                $img =  $barcodeobj->getBarcodePngData(1.5,40, array(25,25,25)); 
                $base64 = 'data:image/png;base64,' . base64_encode($img);  
                    
                // $dimension = (($item_info['length']>0)?$item_info['length'].' x ':'').(($item_info['width']>0)?$item_info['width'].' x ':'').(($item_info['length']>0)?$item_info['height']:'');
                // $dimension = ($dimension!="")?$dimension.' mm '.$item_info['size']:$item_info['size'];

                // $purch_price = (!empty($item_standard_price_info))?$item_standard_price_info[0]:0;
                // $sale_price = (!empty($item_sale__price_info))?$item_sale__price_info[0]:0;

                $html = '
                        <table border="0">
                            <tr>
                                <td class="td_std" width="34.5mm"></td>
                                <td class="td_std" width="26.5mm">
                                    <table border="0">
                                        <tr>
                                            <td colspan="2" style="text-align:center; line-height:6mm;"><img style="width:87px;height:6mm" src="'.$base64.'"></td>
                                        </tr>
                                        <tr><td colspan="2" style="text-align:center; line-height:1mm;"><b>'.$item_info['item_code'].' / '.$item_info['category_code'].'</b></td></tr>
                                        <tr><td colspan="2" style="text-align:center; line-height:2mm;"></td></tr>
                                        
                                        <tr>
                                            <td colspan="2" style="text-align:center; line-height:5mm;"><img style="height:5mm;" src="'.OTHER_IMAGES.'carablack.png"></td>
                                        </tr>
                                        <tr><td colspan="2" style="text-align:center; line-height:1mm;"></td></tr>
                                        <tr>
                                            <td style="text-align:left; line-height:2mm;"><b>('.$item_standard_price_info[0]['purchasing_unit'].' '.$item_info['unit_abbreviation'].')</b></td>
                                            <td style="text-align:right; line-height:2mm;"><b>'.$item_standard_price_info[0]['supplier_code'].'</b></td>
                                        </tr>
                                        
                                    </table>
                                </td>
                            </tr>
                        </table>
                               
                ';
                
                $pdf->writeHTMLCell(63, 22, 0.5, 0.5, $html); 
            }
        }
    
    

    $pdf_output = $pdf->Output('barcode_purch.pdf', 'I');
}