<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function inv_print_congiguration($inv_data, $company_code='', $tmp_mail){
    if($company_code=='NV_GEM_MERCH_DEV')
        inv_html_generator_bangrak($inv_data,$tmp_mail);
    else
        inv_html_generator_default($inv_data,$tmp_mail);
}

function inv_html_generator_default($inv_data, $tmp_mail=''){

    $CI =& get_instance();

    $print_option = $CI->input->get();
    if(isset($print_option['prnt_optn']) && !empty($print_option['prnt_optn']))
        $print_option = json_decode($print_option['prnt_optn']);

    $bank_info = $cert_info = 0;
        if(isset($print_option) && !empty($print_option)){
            foreach ($print_option as $propt){
                if($propt == 'bank'){
                    $bank_info = 1;
                }
                if($propt == 'cert'){
                    $cert_info = 1;
                }
            }
        }

    
    $inv_dets = $inv_data['invoice_dets'];
    $inv_desc = $inv_data['invoice_desc'];

    $CI->load->model('Sales_invoices_model');
    $cur_det = $CI->Sales_invoices_model->get_currency_for_code($inv_dets['currency_code']);
    $cust_dets = get_single_row_helper(CUSTOMERS,'id='.$inv_dets['customer_id']);


    $payment = $old_gold = '';$addone_note = '';
    $payment_tot = $old_gold_tot = 0; 

    if(isset($inv_data['inv_transection']) && !empty($inv_data['inv_transection'])){
        $payment = '
                   <table id="example1" class="" style="padding:5px;" border="0">

                      <tbody> 
                       <tr><td width="65%" style="border-bottom: 1px solid #00000;text-align: left;"  colspan="2">Payments</td></tr>
                      '; 

                       $payment .= '<thead><tr style="background-color:#F5F5F5;">
                                   <th style="text-align: left;"  width="15%"><b>Paid Date</b></th> 
                                   <th style="text-align: center;"  width="15%"><b>Paymet ID</b></th> 
                                   <th style="text-align: center;"  width="15%"><b>Payment Method</b></th> 
                                   <th style="text-align: right;"  width="20%"><b>Amount</b></th> 
                               </tr></thead><tbody> ';
                                   foreach ($inv_data['inv_transection'] as $payment_info){
                                       $payment_tot += $payment_info['transection_amount'];
                                       $payment .= '<tr style="line-height: 10px;">
                                           <td style="text-align: left;"  width="15%">'. date(SYS_DATE_FORMAT,$payment_info['trans_date']).'</td> 
                                           <td style="text-align: center;"  width="15%">'.$payment_info['id'].'</td> 
                                           <td style="text-align: center;"  width="15%">'.$payment_info['payment_method'].'</td> 
                                           <td style="text-align: right;"  width="20%">'.number_format($payment_info['transection_amount'],2).'</td> 
                                       </tr> ';
                                   }
                       $payment .= '<tr><td width="65%" style="border-top: 1px solid #00000;text-align: right;"  colspan="2"></td></tr></tbody>
                   </table>  ';
    }
    if(isset($inv_data['so_og_info']) && !empty($inv_data['so_og_info'])){
         $old_gold = '
                    <table id="example1" class="" style="padding:5px;" border="0">

                       <tbody> 
                        <tr><td width="65%" style="border-bottom: 1px solid #00000;text-align: left;"  colspan="2">Old Gold</td></tr>
                       '; 

                        $old_gold .= '<thead><tr style="background-color:#F5F5F5;">
                                    <th style="text-align: left;"  width="22%"><b>Date</b></th> 
                                    <th style="text-align: center;"  width="23%"><b>OG No</b></th>  
                                    <th style="text-align: right;"  width="20%"><b>Amount</b></th> 
                                </tr></thead><tbody> ';
                                    foreach ($inv_data['so_og_info'] as $og){
                                        $old_gold_tot += $og['og_amount'];
                                        $old_gold .= '<tr style="line-height: 10px;">
                                            <td style="text-align: left;"  width="22%">'. date(SYS_DATE_FORMAT,$og['og_date']).'</td> 
                                            <td style="text-align: center;"  width="23%">'.$og['og_no'].'</td>  
                                            <td style="text-align: right;"  width="20%">'.number_format($og['og_amount'],2).'</td> 
                                        </tr> ';
                                    }
                        $old_gold .= '<tr><td width="65%" style="border-top: 1px solid #00000;text-align: right;"  colspan="2"></td></tr></tbody>
                    </table>  ';
    }
       
    
    // create new PDF document
    
    $CI->load->library('Pdf');
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->fl_header='header_jewel';//invice bg
    $pdf->fl_header_title='INVOICE';//invice bg
    $pdf->fl_header_title_RTOP='CUSTOMER COPY';//invice bg
    $pdf->fl_footer_text=1;//invice bg
    
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Fahry Lafir');
    $pdf->SetTitle('PDF JWL Invoice');
    $pdf->SetSubject('JWL Invoice');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(5, 50, 5);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            
    // set font 
    $fontname = TCPDF_FONTS::addTTFfont('storage/fonts/Lato-Regular.ttf', 'TrueTypeUnicode', '', 96);
    $pdf->SetFont($fontname, 'I', 9);
                
    $pdf->AddPage();   
    $pdf->SetTextColor(32,32,32);   

    $html = '<text>Customer Details:</text><br>';
    $html .= '<table style="padding:2;" border="0.4"> 
                <tr><td>
                    <table style="padding:0 50 2 0;">
                    <tr>
                        <td style="padding:10px;">Customer Code: '.$inv_dets['short_name'].'</td> 
                    </tr>   
                    <tr>
                        <td style="padding:10px;">Full Name: '.$inv_dets['customer_name'].'</td> 
                    </tr>   
                    <tr>
                        <td style="padding:10px;">Address: '.$inv_dets['address'].(($inv_dets['city']!='')?', '.$inv_dets['city']:'').'</td> 
                    </tr>   
                </table> 
            </td></tr>
            </table> ';
    $del_type = '';
    if($inv_dets['so_id']!=0){
        $so_desc1 = $CI->Sales_orders_model->get_so_desc($inv_dets['so_id']);
        if(count($so_desc1)==count($inv_data['invoice_desc_list'])){
            $del_type = 'FULL';
        }
        if(count($so_desc1)>count($inv_data['invoice_desc_list'])){
            $del_type = 'PART';
        }
    }

    $html .= '<table border="0">
                <tr><td  colspan="3"><br></td></tr>
                <tr>
                    <td align="left">TRX Type: '.$inv_dets['invoice_type'].'</td> 
                    <td align="center">Invoice Date '.date(SYS_DATE_FORMAT,$inv_dets['invoice_date']).'</td> 
                    <td align="right">Invoice  No: '.$inv_dets['invoice_no'].'</td> 
                </tr>  
                <tr '.(($inv_dets['so_id']>0)?'':'style="line-height:0px;"').'>
                    <td align="left">'.(($del_type=='')?'':'Delivery Type: '.$del_type).'</td> 
                    <td align="center">'.(($inv_dets['order_date']!='')?'Order Date: '.date(SYS_DATE_FORMAT,$inv_dets['order_date']):'').'</td> 
                    <td align="right">'.(($inv_dets['sales_order_no']!='')?'Order No: '.$inv_dets['sales_order_no']:'').'</td> 
                </tr>  
                <tr>
                    <td align="left"></td> 
                    <td align="center"></td> 
                    <td align="right">Currency: '.$cur_det['code'].'</td> 
                </tr>  
                <tr><td  colspan="3"><br></td></tr>
            </table>  ';
           
    $html .= '<table border="0" style=""><tr><td>';

    $inv_tot = 0;
    $is_gem_stat = $is_item_stat = 0;
    $item_list_html = $gem_list_html =  $html_certs = '';

    $gmcount=1;$gmqty1 =$gmqty2 =0; 
    foreach ($inv_data['invoice_desc_list'] as $inv_itm){
        if($inv_itm['is_gem']==1){
            $is_gem_stat++;
        }
        if($inv_itm['is_gem']==0){
            $is_item_stat++;
        }
        if($inv_itm['is_gem']==0){
            $item_list_html .= '<tr>
                            <td width="33%" style="text-align: left;">'.$inv_itm['item_description'].'</td> 
                            <td width="12%" style="text-align: left;">'.$inv_itm['item_cat_name'].'</td>  
                            <td width="12%">'.$inv_itm['item_code'].'</td>  
                            <td width="23%" style="text-align: center;">'.$inv_itm['item_quantity'].' '.$inv_itm['unit_abbreviation'].'</td> 
                            <td width="20%" style="text-align: right;"> '. number_format($inv_itm['sub_total'],2).'</td> 
                        </tr> ';
            $inv_tot+=$inv_itm['sub_total'];
        }
        if($inv_itm['is_gem']==1){
            $item_info = get_single_row_helper(ITEMS, 'id='.$inv_itm['item_id']);

            $gem_list_html .= '<tr>
                                <td width="16%" style="text-align: left;">'.$inv_itm['item_description'].'</td> 
                                <td width="10%" style="text-align: left;">'.$inv_itm['item_code'].'</td>  
                                <td width="10%">'. (($item_info['color']>0)?get_dropdown_value($item_info['treatment']):'-').'</td>  
                                <td width="10%">'. (($item_info['color']>0)?get_dropdown_value($item_info['shape']):'-').'</td>  
                                <td width="12%">'. (($item_info['color']>0)?get_dropdown_value($item_info['color']):'-').'</td>  
                                <td width="12%">'. (($item_info['color']>0 && get_dropdown_value($item_info['origin'])!='0')?get_dropdown_value($item_info['origin']):'-').'</td>  
                                <td width="18%" style="text-align: center;">'.$inv_itm['item_quantity'].' '.$inv_itm['unit_abbreviation'].(($inv_itm['item_quantity_uom_id_2']>0)?' / '.$inv_itm['item_quantity_2'].' '.$inv_itm['unit_abbreviation_2']:'').'</td> 
                                <td width="12%" style="text-align: right;"> '. number_format($inv_itm['sub_total'],2).'</td> 
                            </tr> ';
            $inv_tot+=$inv_itm['sub_total'];
            $gmqty1 +=$inv_itm['item_quantity'];
            $gmqty2 +=$inv_itm['item_quantity_2'];
            $gmcount++;
        }
        
        if($inv_itm['certificates_files'] !='' ){
            $img_arr = json_decode($inv_itm['certificates_files']);
            
            if(!empty($img_arr)){  
                    $html_certs .= '<tr>
                                        <td width="10%">'.($gmcount-1).'</td>
                                        <td width="20%">'.$inv_itm['item_code'].'</td>
                                        <td width="70%">';
                                            foreach ($img_arr as $imgcert){
                                                $html_certs .= '<img style="height:310px;" src="'. base_url(ITEM_IMAGES.$inv_itm['item_id'].'/certificates_files/'.$imgcert).'"> <br><br>';
                                            }
                     $html_certs .='    </td>
                                    </tr> '; 
            }
        }
        
    }
    
    //items
    if($is_item_stat>0){
        $html .='
                    <table id="example1" class="table-line" border="0">
                        <thead> 
                            <tr style=""> 
                                <th width="33%" style="text-align: left;"><u><b>Article Description</b></u></th>  
                                <th width="12%" style="text-align: left;"><u><b>Category</b></u></th>  
                                <th width="12%" style="text-align: left;"><u><b>Item code</b></u></th> 
                                <th  width="23%" style="text-align: center;" ><u><b>Weight</b></u></th>  
                                <th width="20%" style="text-align: right;"><u><b>Price ('.$cur_det['symbol_left'].')</b></u></th> 
                                </tr>
                        </thead>
                    <tbody>';
        $html .= $item_list_html;
        $html .= ' <tr><td  colspan="5"></td></tr></tbody></table>';  
    }
    //gemstones
    if($is_gem_stat>0){
        $html .= '<table id="example2" class="table-line" border="0">
                        <thead> 
                            <tr style=""> 
                                <th width="16%" style="text-align: left;"><u><b>Gemstone</b></u></th>  
                                <th width="10%" style="text-align: left;"><u><b>Item Code</b></u></th>  
                                <th width="10%" style="text-align: left;"><u><b>CDC</b></u></th> 
                                <th  width="10%" style="text-align: left;" ><u><b>Shape</b></u></th>  
                                <th  width="12%" style="text-align: left;" ><u><b>Color</b></u></th>  
                                <th  width="12%" style="text-align: left;" ><u><b>Origin</b></u></th>  
                                <th  width="18%" style="text-align: center;" ><u><b>Weight</b></u></th>  
                                <th width="12%" style="text-align: right;"><u><b>Price ('.$cur_det['symbol_left'].')</b></u></th> 
                                </tr>
                        </thead>
                    <tbody>';
        $html .= $gem_list_html;
        $html .= ' <tr><td  colspan="5"></td></tr></tbody></table>';  
    }
    
    $html .= '
            <table id="example1" class="table-line" border="0">
                <tbody>'; 
  
            $html .= '<tr>
                        <td  style="text-align: right;" colspan="4"><b>Sub Total</b></td> 
                        <td width="20%"  style="border-top: 1px solid #00000;text-align: right;"><b> '. number_format($inv_tot,2).'</b></td> 
                    </tr>';
      
    if(!empty($inv_data['invoice_addons'])){
            foreach ($inv_data['invoice_addons'] as $inv_addon){
                $inv_tot += $inv_addon['addon_amount'];
                $addon_info = json_decode($inv_addon['addon_info'],true)[0];
                $percent = '';
                if($addon_info['calculation_type']==2){
                    $percent = '('.$addon_info['addon_value'].' %)';
                }
                $html .= '<tr>
                            <td  style="text-align: right;" colspan="4"><b>'.$addon_info['addon_name'].' '.$percent.'</b></td> 
                            <td width="20%"  style="text-align: right;"><b> '. number_format($inv_addon['addon_amount'],2).'</b></td> 
                        </tr>';
            }
          
            $html .= '<tr>
                        <td  style="text-align: right;" colspan="4"><b>Total</b></td> 
                        <td width="20%"  style="border-top: 1.5px solid #00000;text-align: right;"><b> '. number_format($inv_tot,2).'</b></td> 
                    </tr>';
    }
      
    $balance = $inv_tot;
    if($payment_tot>0){
        $balance -= $payment_tot;
        $html .= '<tr>
                    <td  style="text-align: right;" colspan="4"><b>Payments</b></td> 
                    <td width="20%"  style="text-align: right;"><b> '. number_format($payment_tot,2).'</b></td> 
                </tr>';
    }
    if($old_gold_tot>0){
        $balance -= $old_gold_tot;
        $html .= '<tr>
                    <td  style="text-align: right;" colspan="4"><b>Old Gold</b></td> 
                    <td width="20%"  style="text-align: right;"><b> '. number_format($old_gold_tot,2).'</b></td> 
                </tr>';
    }
    
    if($balance>0){
    $html .= '<tr>
                <td  style="text-align: right;" colspan="4"><b>Balance</b></td> 
                <td width="20%" style="border-top: 1px solid #00000;text-align: right;" ><b> '. number_format($balance,2).'</b></td> 
            </tr>';
    }
    $html .= '</tbody></table>
              </td></tr></table>';

    
                        
                        
    $html .= $payment.$old_gold;

    if($cert_info==1 || $bank_info==1 || $html_certs!=''){
        $html .= '<table border="0">
                    <tr>
                        <th style="text-align: left;">Notes: </th>  
                    </tr>
                    <tr>
                        <td style="text-align: left;">
                            <ul>
                                '.(($cert_info==1 && $html_certs!='')?'<li>Certificate Copy Attached</li>':'').'
                                '.$addone_note.'
                                '.(($bank_info==1)?'<li>Bank Details Attached</li>':'').'
                            </ul>
                        </td>  
                    </tr>
                </table>';
    }       
    
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
    </style>';
    
    $pdf->writeHTML($html);
            
    $bank_details = '';
            
    //            if($bank_info==1){
    //                $pdf->AddPage();   
    //                $pdf->writeHTML($bank_details);
    //            }
    if($cert_info==1 && $html_certs!=''){
        $pdf->AddPage();
        $html_certs_top = '<table style="padding:20px;" class="table-line" border="0">
                            <tr>
                                <td colspan="3"><h2>Certificates</h2></td>
                            </tr> '; 
        $pdf->writeHTML($html_certs_top.$html_certs.'</table>');
    }
    $pdf->SetFont('times', '', 12.5, '', true);
    $pdf->SetTextColor(255,125,125);           

    if($tmp_mail==1){
        //echo '<pre>';                    print_r($cust_dets); die;
        $pd_file_path = BASEPATH.'.'.PDF_TMP_MAIL.'sales_invoices/INV_'.$inv_dets['invoice_no'].'.pdf';
        if(file_exists($pd_file_path)) unlink($pd_file_path);  //check and remove old file exists
        $pdf->Output($pd_file_path, 'F');
        
            if($cust_dets['email'] == ''){
                    $CI->session->set_flashdata('error','Error! Email not sent. Please Check Customer Email address.');
            }else{
                if(file_exists($pd_file_path) && $cust_dets['email'] != ''){
                    $message    = '<table width="100%" border="0">
                                                <br>
                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Please find attached invoice (Invoice No '.$inv_dets['invoice_no'].')  send  at '.date('Y-m-d H:i').'</td>
                                                </tr>
                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">&nbsp;</td>
                                                </tr> 
                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold"></td>
                                                </tr>
                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Best Regards</td>
                                                </tr>

                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">'.SYSTEM_NAME.'</td>
                                                </tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold"></td>
                                                </tr>
                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8;">Please note that this is an automatd email from the <a href="http://nveloop.com">Nveloop</a> Gem Merchant Software.</td>
                                                </tr>
                        </table>';
                    $attathments[0] = $pd_file_path;
                    // $attathments = '';
                    $CI->load->model('Sendmail_model');
                    if($CI->Sendmail_model->send_mail($cust_dets['email'],SMTP_USER,SYSTEM_NAME.' Billing',SYSTEM_SHOTR_NAME.' Invoice # :'.$inv_dets['invoice_no'],$message,$attathments)){
                            $CI->session->set_flashdata('warn','Success! Email send to  '.$cust_dets['email'].' Successfully');
                            unlink($pd_file_path);
                            echo '1';
                    }else{
                            //    echo 'bbbb';
                            $CI->session->set_flashdata('error','Error! Email not sent.');
                            echo '0';
                    }
                }else{
                    $CI->session->set_flashdata('error','Error!  Email not sent.');
                    echo '0';
                }
            }
    }else{ 
        
        if(BANK_INFO !='' && $bank_info=='1'){
            $bank_info = json_decode(BANK_INFO, true);
            $pdf->AddPage();
            $pdf->SetFont('times', '', 10.5, '', true);
            $pdf->SetTextColor(32,32,32); 
            // echo '<pre>'; print_r($bank_info);
            $bank_html = '<table border="0">';
            foreach($bank_info as  $bank_value){
                $tds = '';
                foreach($bank_value as $bank_key => $bank_col){
                    $tds .= '<td width="3%"> </td>';
                    $tds .= '<td width="20%">'.$bank_key.' </td>';
                    $tds .= '<td width="3%">'.(($bank_key!='')?':':'').' </td>';
                    $tds .= '<td width="60%">'.$bank_col.'</td>';
                }
                $bank_html .= '<tr>'.$tds.'</tr>';
            }
            $bank_html .= '</table>';
            $pdf->writeHTML($bank_html);
        }

        // force print dialog
        $js = 'this.print();';
        $js = 'print(true);';
        // set javascript
        $pdf->IncludeJS($js);
        $pdf->Output('INV_'.$inv_dets['invoice_no'].'.pdf', 'I');
    }
    echo '<pre>';print_r($inv_data); die;
}

function inv_html_generator_bangrak($inv_data, $tmp_mail=''){

    $CI =& get_instance();
    // echo '<pre>'; print_r($inv_data); die;
    $print_option = $CI->input->get();
    if(isset($print_option['prnt_optn']) && !empty($print_option['prnt_optn']))
        $print_option = json_decode($print_option['prnt_optn']);

    $bank_info = $cert_info = 0;
        if(isset($print_option) && !empty($print_option)){
            foreach ($print_option as $propt){
                if($propt == 'bank'){
                    $bank_info = 1;
                }
                if($propt == 'cert'){
                    $cert_info = 1;
                }
            }
        }

    
    $inv_dets = $inv_data['invoice_dets'];
    $inv_desc = $inv_data['invoice_desc'];

    $CI->load->model('Sales_invoices_model');
    $cur_det = $CI->Sales_invoices_model->get_currency_for_code($inv_dets['currency_code']);
    $cust_dets = get_single_row_helper(CUSTOMERS,'id='.$inv_dets['customer_id']);


    $payment = $old_gold = '';$addone_note = '';
    $payment_tot = $old_gold_tot = 0; 

    if(isset($inv_data['inv_transection']) && !empty($inv_data['inv_transection'])){
        $payment = '
                   <table id="example1" class="" style="padding:5px;" border="0">

                      <tbody> 
                       <tr><td width="65%" style="border-bottom: 1px solid #00000;text-align: left;"  colspan="2">Payments</td></tr>
                      '; 

                       $payment .= '<thead><tr style="background-color:#F5F5F5;">
                                   <th style="text-align: left;"  width="15%"><b>Paid Date</b></th> 
                                   <th style="text-align: center;"  width="15%"><b>Paymet ID</b></th> 
                                   <th style="text-align: center;"  width="15%"><b>Payment Method</b></th> 
                                   <th style="text-align: right;"  width="20%"><b>Amount</b></th> 
                               </tr></thead><tbody> ';
                                   foreach ($inv_data['inv_transection'] as $payment_info){
                                       $payment_tot += $payment_info['transection_amount'];
                                       $payment .= '<tr style="line-height: 10px;">
                                           <td style="text-align: left;"  width="15%">'. date(SYS_DATE_FORMAT,$payment_info['trans_date']).'</td> 
                                           <td style="text-align: center;"  width="15%">'.$payment_info['id'].'</td> 
                                           <td style="text-align: center;"  width="15%">'.$payment_info['payment_method'].'</td> 
                                           <td style="text-align: right;"  width="20%">'.number_format($payment_info['transection_amount'],2).'</td> 
                                       </tr> ';
                                   }
                       $payment .= '<tr><td width="65%" style="border-top: 1px solid #00000;text-align: right;"  colspan="2"></td></tr></tbody>
                   </table>  ';
    }
    if(isset($inv_data['so_og_info']) && !empty($inv_data['so_og_info'])){
         $old_gold = '
                    <table id="example1" class="" style="padding:5px;" border="0">

                       <tbody> 
                        <tr><td width="65%" style="border-bottom: 1px solid #00000;text-align: left;"  colspan="2">Old Gold</td></tr>
                       '; 

                        $old_gold .= '<thead><tr style="background-color:#F5F5F5;">
                                    <th style="text-align: left;"  width="22%"><b>Date</b></th> 
                                    <th style="text-align: center;"  width="23%"><b>OG No</b></th>  
                                    <th style="text-align: right;"  width="20%"><b>Amount</b></th> 
                                </tr></thead><tbody> ';
                                    foreach ($inv_data['so_og_info'] as $og){
                                        $old_gold_tot += $og['og_amount'];
                                        $old_gold .= '<tr style="line-height: 10px;">
                                            <td style="text-align: left;"  width="22%">'. date(SYS_DATE_FORMAT,$og['og_date']).'</td> 
                                            <td style="text-align: center;"  width="23%">'.$og['og_no'].'</td>  
                                            <td style="text-align: right;"  width="20%">'.number_format($og['og_amount'],2).'</td> 
                                        </tr> ';
                                    }
                        $old_gold .= '<tr><td width="65%" style="border-top: 1px solid #00000;text-align: right;"  colspan="2"></td></tr></tbody>
                    </table>  ';
    }
       
    
    // create new PDF document
    
    $CI->load->library('Pdf');
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->fl_header='header_jewel';//invice bg
    $pdf->fl_header_title='INVOICE';//invice bg
    $pdf->fl_header_title_RTOP='FINAL INVOICE';//invice bg
    $pdf->fl_footer_text=1;//invice bg
    
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Fahry Lafir');
    $pdf->SetTitle('PDF JWL Invoice');
    $pdf->SetSubject('JWL Invoice');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(5, 50, 5);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            
    // set font 
    $fontname = TCPDF_FONTS::addTTFfont('storage/fonts/Lato-Regular.ttf', 'TrueTypeUnicode', '', 96);
    $pdf->SetFont($fontname, 'I', 9);
                
    $pdf->AddPage();   
    $pdf->SetTextColor(32,32,32);   

    $html = $bank_html = '';
    if(BANK_INFO !='' && $bank_info=='1'){
        $bank_info = json_decode(BANK_INFO, true);
        // echo '<pre>'; print_r($bank_info);
        foreach($bank_info as  $bank_value){
            foreach($bank_value as $bank_key => $bank_col){
                $bank_html .=  '<tr><td style="padding:10px; text-align:right">'.(($bank_key!='')?$bank_key.': ':'').$bank_col.'</td></tr>';
            }
        }
    }
    $html .= '<table style="padding:2;" border="0.0"> 
                <tr>
                    <td>
                        <table style="padding:0 50 2 0;">
                            <tr>
                                <td style="padding:10px;"><u>To</u>: </td> 
                            </tr>   
                            <tr>
                                <td style="padding:10px;">Customer Code: '.$inv_dets['short_name'].'</td> 
                            </tr>   
                            <tr>
                                <td style="padding:10px;">Full Name: '.$inv_dets['customer_name'].'</td> 
                            </tr>   
                            <tr>
                                <td style="padding:10px;">Address: '.$inv_dets['address'].(($inv_dets['city']!='')?', '.$inv_dets['city']:'').'</td> 
                            </tr>   
                        </table> 
                    </td>
                    <td>
                        <table style="padding:0 0 2 0;">
                            <tr><td style="padding:10px; text-align:right">Invoice No: '.$inv_dets['invoice_no'].'</td> </tr>
                            <tr><td style="padding:10px; text-align:right">Date: '.date(SYS_DATE_FORMAT,$inv_dets['invoice_date']).'</td> </tr>
                            <tr><td style="padding:10px; text-align:right">Currency: '.$cur_det['code'].'</td> </tr>
                            '.$bank_html.'
                        </table>
                    </td>
                </tr>
            </table> ';
    $del_type = '';
    if($inv_dets['so_id']!=0){
        $so_desc1 = $CI->Sales_orders_model->get_so_desc($inv_dets['so_id']);
        if(count($so_desc1)==count($inv_data['invoice_desc_list'])){
            $del_type = 'FULL';
        }
        if(count($so_desc1)>count($inv_data['invoice_desc_list'])){
            $del_type = 'PART';
        }
    }
           
    $html .= '<table border="0" style=""><tr><td>';

    $inv_tot = 0;
    $is_gem_stat = $is_item_stat = 0;
    $item_list_html = $gem_list_html =  $html_certs = '';

    $gmcount=1;$gmqty1 =$gmqty2 =0; 
    foreach ($inv_data['invoice_desc_list'] as $inv_itm){
        if($inv_itm['is_gem']==1){
            $is_gem_stat++;
        }
        if($inv_itm['is_gem']==0){
            $is_item_stat++;
        }
        if($inv_itm['is_gem']==0){
            $item_list_html .= '<tr>
                            <td width="33%" style="text-align: left;">'.$inv_itm['item_description'].'</td> 
                            <td width="12%" style="text-align: left;">'.$inv_itm['item_cat_name'].'</td>  
                            <td width="12%">'.$inv_itm['item_code'].'</td>  
                            <td width="23%" style="text-align: center;">'.$inv_itm['item_quantity'].' '.$inv_itm['unit_abbreviation'].'</td> 
                            <td width="20%" style="text-align: right;"> '. number_format($inv_itm['sub_total'],2).'</td> 
                        </tr> ';
            $inv_tot+=$inv_itm['sub_total'];
        }
        if($inv_itm['is_gem']==1){
            $item_info = get_single_row_helper(ITEMS, 'id='.$inv_itm['item_id']);
            // echo '<pre>'; print_r($item_info);die;
            $lwh =  (($item_info['length']>0)?$item_info['length']:'-') .'x'. (($item_info['width']>0)?$item_info['width']:'-') .'x'. (($item_info['height']>0)?$item_info['height']:'-').' mm';
            // echo $lwh; die;
            if($lwh == '-x-x- mm'){
                if($item_info['size']=='')
                    $lwh = $item_info['size'];
                else
                    $lwh = '';
            }
            $gem_list_html .= '<tr>
                                <td width="19%" style="text-align: left;">'.$inv_itm['item_description'].'</td> 
                                <td width="10%" style="text-align: left;">'.$inv_itm['item_code'].'</td>  
                                <td width="10%">'. (($item_info['treatment']>0)?get_dropdown_value($item_info['treatment']):'-').'</td>  
                                <td width="15%">'. (($item_info['shape']>0)?get_dropdown_value($item_info['shape']):'-').(($lwh.="")?' <br>'.$lwh:'').'</td>  
                                <td width="18%" style="text-align: center;">'.$inv_itm['item_quantity'].' '.$inv_itm['unit_abbreviation'].(($inv_itm['item_quantity_uom_id_2']>0)?' / '.$inv_itm['item_quantity_2'].' '.$inv_itm['unit_abbreviation_2']:'').'</td> 
                                <td width="14%" style="text-align: right;"> '. number_format($inv_itm['unit_price'],2).'</td> 
                                <td width="14%" style="text-align: right;"> '. number_format($inv_itm['sub_total'],2).'</td> 
                            </tr> ';
            $inv_tot+=$inv_itm['sub_total'];
            $gmqty1 +=$inv_itm['item_quantity'];
            $gmqty2 +=$inv_itm['item_quantity_2'];
            $gmcount++;
        }
        
        if($inv_itm['certificates_files'] !='' ){
            $img_arr = json_decode($inv_itm['certificates_files']);
            
            if(!empty($img_arr)){  
                    $html_certs .= '<tr>
                                        <td width="10%">'.($gmcount-1).'</td>
                                        <td width="20%">'.$inv_itm['item_code'].'</td>
                                        <td width="70%">';
                                            foreach ($img_arr as $imgcert){
                                                $html_certs .= '<img style="height:310px;" src="'. base_url(ITEM_IMAGES.$inv_itm['item_id'].'/certificates_files/'.$imgcert).'"> <br><br>';
                                            }
                     $html_certs .='    </td>
                                    </tr> '; 
            }
        }
        
    }
    
    //items
    if($is_item_stat>0){
        $html .='
                    <table id="example1" class="table-line" border="0">
                        <thead> 
                            <tr style=""> 
                                <th width="33%" style="text-align: left;"><u><b>Article Description</b></u></th>  
                                <th width="12%" style="text-align: left;"><u><b>Category</b></u></th>  
                                <th width="12%" style="text-align: left;"><u><b>Item code</b></u></th> 
                                <th  width="23%" style="text-align: center;" ><u><b>Weight</b></u></th>  
                                <th width="20%" style="text-align: right;"><u><b>Price ('.$cur_det['symbol_left'].')</b></u></th> 
                                </tr>
                        </thead>
                    <tbody>';
        $html .= $item_list_html;
        $html .= ' <tr><td  colspan="5"></td></tr></tbody></table>';  
    }
    //gemstones
    if($is_gem_stat>0){
        
        $html .= '<table id="example2" class="table-line" border="0">
                        <thead> 
                            <tr style=""> 
                                <th width="19%" style="text-align: left;"><u><b>Gemstone</b></u></th>  
                                <th width="10%" style="text-align: left;"><u><b>Item Code</b></u></th>  
                                <th width="10%" style="text-align: left;"><u><b>CDC</b></u></th> 
                                <th  width="15%" style="text-align: left;" ><u><b>Shape</b></u></th>   
                                <th  width="18%" style="text-align: center;" ><u><b>Weight</b></u></th>  
                                <th width="14%" style="text-align: right;"><u><b>Unit Prc. ('.$cur_det['symbol_left'].')</b></u></th> 
                                <th width="14%" style="text-align: right;"><u><b>Price ('.$cur_det['symbol_left'].')</b></u></th> 
                                </tr>
                        </thead>
                    <tbody>';
        $html .= $gem_list_html;
        $html .= '<tr>
                        <td  style="text-align: right;" colspan="5"><b>Total units: </b></td> 
                        <td  style="border-top: 1px solid #00000;text-align: center;"><b> '.$gmqty1.' / '.$gmqty2.' </b></td> 
                        <td  style="text-align: right;" colspan="2"></td> 
                    </tr>';
        $html .= ' <tr><td  colspan="5"></td></tr></tbody></table>';  
    }
    
    $html .= '
            <table id="example1" class="table-line" border="0">
                <tbody>'; 
            $html .= '<tr>
                        <td  style="text-align: right;" colspan="4"><b>F.O.B. Bangkok</b></td> 
                        <td width="20%"  style="border-top: 1px solid #00000;text-align: right;"><b> '. number_format($inv_tot,2).'</b></td> 
                    </tr>';
      
    if(!empty($inv_data['invoice_addons'])){
            foreach ($inv_data['invoice_addons'] as $inv_addon){
                $inv_tot += $inv_addon['addon_amount'];
                $addon_info = json_decode($inv_addon['addon_info'],true)[0];
                $percent = '';
                if($addon_info['calculation_type']==2){
                    $percent = '('.$addon_info['addon_value'].' %)';
                }
                $html .= '<tr>
                            <td  style="text-align: right;" colspan="4"><b>'.$addon_info['addon_name'].' '.$percent.'</b></td> 
                            <td width="20%"  style="text-align: right;"><b> '. number_format($inv_addon['addon_amount'],2).'</b></td> 
                        </tr>';
            }
          
            $html .= '<tr>
                        <td  style="text-align: right;" colspan="4"><b>Total</b></td> 
                        <td width="20%"  style="border-top: 1.5px solid #00000;text-align: right;"><b> '. number_format($inv_tot,2).'</b></td> 
                    </tr>';
    }
      
    $balance = $inv_tot;
    if($payment_tot>0){
        $balance -= $payment_tot;
        $html .= '<tr>
                    <td  style="text-align: right;" colspan="4"><b>Payments</b></td> 
                    <td width="20%"  style="text-align: right;"><b> '. number_format($payment_tot,2).'</b></td> 
                </tr>';
    }
    if($old_gold_tot>0){
        $balance -= $old_gold_tot;
        $html .= '<tr>
                    <td  style="text-align: right;" colspan="4"><b>Old Gold</b></td> 
                    <td width="20%"  style="text-align: right;"><b> '. number_format($old_gold_tot,2).'</b></td> 
                </tr>';
    }
    
    if($balance>0){
    $html .= '<tr>
                <td  style="text-align: right;" colspan="4"><b>Balance</b></td> 
                <td width="20%" style="border-top: 1px solid #00000;text-align: right;" ><b> '. number_format($balance,2).'</b></td> 
            </tr>';
    }
    $html .= '</tbody></table>
              </td></tr></table>';

    
                        
                        
    $html .= $payment.$old_gold;
    $html .= '<table><tr>
                <td>('.strtoupper($cur_det['title']).' '.numberTowords($inv_tot).')</td> 
            </tr></table';

    if($cert_info==1 || $bank_info==1 || $html_certs!=''){
        $html .= '<table border="0">
                    <tr>
                        <th style="text-align: left;">Notes: </th>  
                    </tr>
                    <tr>
                        <td style="text-align: left;">
                            <ul>
                                '.(($cert_info==1 && $html_certs!='')?'<li>Certificate Copy Attached</li>':'').'
                                '.$addone_note.'
                                '.(($bank_info==1)?'<li>Bank Details Attached</li>':'').'
                            </ul>
                        </td>  
                    </tr>
                </table>';
    }       
    
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
    </style>';
    
    $pdf->writeHTML($html);
            
    $bank_details = '';
            
    //            if($bank_info==1){
    //                $pdf->AddPage();   
    //                $pdf->writeHTML($bank_details);
    //            }
    if($cert_info==1 && $html_certs!=''){
        $pdf->AddPage();
        $html_certs_top = '<table style="padding:20px;" class="table-line" border="0">
                            <tr>
                                <td colspan="3"><h2>Certificates</h2></td>
                            </tr> '; 
        $pdf->writeHTML($html_certs_top.$html_certs.'</table>');
    }
    $pdf->SetFont('times', '', 12.5, '', true);
    $pdf->SetTextColor(255,125,125);           

    if($tmp_mail==1){
        //echo '<pre>';                    print_r($cust_dets); die;
        $pd_file_path = BASEPATH.'.'.PDF_TMP_MAIL.'sales_invoices/INV_'.$inv_dets['invoice_no'].'.pdf';
        if(file_exists($pd_file_path)) unlink($pd_file_path);  //check and remove old file exists
        $pdf->Output($pd_file_path, 'F');
        
            if($cust_dets['email'] == ''){
                    $CI->session->set_flashdata('error','Error! Email not sent. Please Check Customer Email address.');
            }else{
                if(file_exists($pd_file_path) && $cust_dets['email'] != ''){
                    $message    = '<table width="100%" border="0">
                                                <br>
                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Please find attached invoice (Invoice No '.$inv_dets['invoice_no'].')  send  at '.date('Y-m-d H:i').'</td>
                                                </tr>
                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">&nbsp;</td>
                                                </tr> 
                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold"></td>
                                                </tr>
                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Best Regards</td>
                                                </tr>

                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">'.SYSTEM_NAME.'</td>
                                                </tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold"></td>
                                                </tr>
                                                <tr>
                                                <td width="7%">&nbsp;</td>
                                                <td colspan="2" style="font:Verdana; color:#A8A8A8;">Please note that this is an automatd email from the <a href="http://nveloop.com">Nveloop</a> Gem Merchant Software.</td>
                                                </tr>
                        </table>';
                    $attathments[0] = $pd_file_path;
                    // $attathments = '';
                    $CI->load->model('Sendmail_model');
                    if($CI->Sendmail_model->send_mail($cust_dets['email'],SMTP_USER,SYSTEM_NAME.' Billing',SYSTEM_SHOTR_NAME.' Invoice # :'.$inv_dets['invoice_no'],$message,$attathments)){
                            $CI->session->set_flashdata('warn','Success! Email send to  '.$cust_dets['email'].' Successfully');
                            unlink($pd_file_path);
                            echo '1';
                    }else{
                            //    echo 'bbbb';
                            $CI->session->set_flashdata('error','Error! Email not sent.');
                            echo '0';
                    }
                }else{
                    $CI->session->set_flashdata('error','Error!  Email not sent.');
                    echo '0';
                }
            }
    }else{ 
        
        

        // force print dialog
        $js = 'this.print();';
        $js = 'print(true);';
        // set javascript
        $pdf->IncludeJS($js);
        $pdf->Output('INV_'.$inv_dets['invoice_no'].'.pdf', 'I');
    }
    echo '<pre>';print_r($inv_data); die;
}