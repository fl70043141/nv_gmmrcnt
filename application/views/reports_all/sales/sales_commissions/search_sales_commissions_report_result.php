<table id="example1" class="table  dataTable table-bordered table-striped"><thead>
    <?php
        $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"'); 
        $html_row = '<tr>
                        <th>#</th>
                        <th style="text-align:center;">Consignee</th> 
                        <th style="text-align:center;">Code</th> 
                        <th style="text-align:center;">Desc</th>  
                        <th style="text-align:center;">Date</th> 
                        <th style="text-align:center;">Invoice#</th> 
                        <th style="text-align:center;">CR No</th> 
                        <th style="text-align:center;">Units</th>  
                        <th style="text-align:center;">Commission Type</th>   
                        <th style="text-align:center;">Commission</th>   
                    </tr>
                </thead>
                <tbody>';
        
                    $i = 0;  $tot_commish= $tot_unit1 = $tot_unit2 = 0;
                    $unit_abr = $unit_abr2= '';
                   foreach ($rep_data as $item){
//                       echo '<pre>';                       print_r($item); die; 
                        $tot_commish += $item['consignment_amount'];
                        $tot_unit1 += $item['commision_unit'];
                        $tot_unit2 += $item['commision_unit_2'];
                        $unit_abr = $item['uom_name'];
                        $unit_abr2 = $item['uom_name_2'];
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die; 
                        $html_row .= '
                            <tr>
                                <td>'.($i+1).'</td> 
                                <td align="center">'.$item['consignee_name'].'</td>
                                <td align="center">'.$item['item_code'].'</td>
                                <td align="center">'.$item['item_name'].'</td>
                                <td align="center">'. date(SYS_DATE_FORMAT,$item['invoice_date']).'</td>
                                <td align="center">'.$item['invoice_no'].'</td>
                                <td align="center">'.$item['cr_no'].'</td>
                                <td align="center">'.$item['commision_unit'].' '.$item['uom_name'].' '.(($item['commision_unit_2']>0)?' | '.$item['commision_unit_2'].' '.$item['uom_name_2']:'').'</td>
                                <td align="center">'.(($item['consignment_type_id']==1 || $item['consignment_type_id']==2)?'Percentage ('.$item['consignment_rate'].'%)':'Fixed Amount').'</td>
                                <td align="center">'. number_format($item['consignment_amount'],2).'</td>
                            </tr>';
                        $i++;
                   }
                   if($i==0){
                       $html_row .= '<tr>
                                <td>No Results found</td> 
                            </tr>';
                   }
                   
                   $html_tots = '<div class="row">
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Total Commission: </dt><dd>'. number_format($tot_commish, 2).'</dd>
                                </dl> 
                            </div>
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Number of Items: </dt><dd>'.($i).'</dd>
                                </dl> 
                            </div>
                            
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Units: </dt><dd>'.$tot_unit1.' '.$unit_abr.(($tot_unit2>0)?' | '.$tot_unit2.' '.$unit_abr2:'').'</dd>';
//                                        foreach ($all_tot_uom as $uom_unts){
//                                            $html_tots .= ' <dd>'.$uom_unts['unit1'].' '.$uom_unts['unit_abr'].(($uom_unts['unit2']>0)?'  |  '.$uom_unts['unit2'].' '.$uom_unts['unit_abr_2']:'').' </dd>';
//                                        }
                            
                          $html_tots .= '</dl> 
                            </div>
                        </div>';
                          
                          echo $html_tots.$html_row;
              ?>   
        </tbody> 
         </table> 