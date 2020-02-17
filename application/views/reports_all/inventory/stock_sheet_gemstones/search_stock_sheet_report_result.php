<table id="example1" class="table  dataTable table-bordered table-striped"><thead>
    <?php
        $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"'); 
        $html_row = '<tr>
                        <th>#</th>
                        <th style="text-align:center;">Code</th> 
                        <th style="text-align:center;">Desc</th>  
                        <th style="text-align:center;">Dimension</th>  
                        <th style="text-align:center;">CDC</th> 
                        <th style="text-align:center;">Color</th> 
                        <th style="text-align:center;">Shape</th> 
                        <th style="text-align:right;">Selling price</th> 
                        <th style="text-align:center;">In Stock</th>  
                        <th style="text-align:center;">On Lapidary</th>   
                        <th style="text-align:center;">On Consignee</th>   
                    </tr>
                </thead>
                <tbody>';
        
        $i = 0;  
                   foreach ($rep_data as $cust_id => $item){
                        $tot_units = $item['units_available'] + $item['units_on_workshop'] + $item['units_on_consignee'];
                        $tot_units_2 = $item['units_available_2'] + $item['units_on_workshop_2'] + $item['units_on_consignee_2'];
                                 
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
//                       echo '<pre>';                       print_r($item); die;
                        
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die;
                                if($item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                                    $html_row .= '
                                        <tr>
                                            <td>'.($i+1).'</td> 
                                            <td align="center">'.$item['item_code'].'</td>
                                            <td align="center">'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].')</b>':'').'</td>
                                            <td align="center">'.$item['dimension'].'</td>
                                            <td align="center">'.$item['treatment_name'].'</td>
                                            <td align="center">'.$item['color_name'].'</td>
                                            <td align="center">'.$item['shape_name'].'</td>
                                            <td align="right">'.$item['selling_price'].'</td>
                                            <td align="center">'.$item['units_available'].' '.$item['uom_name'].' '.(($item['uom_id_2']!=0)?'| '.$item['units_available_2'].' '.$item['uom_name_2']:'').'</td>
                                            <td align="center">'.$item['units_on_workshop'].' '.$item['uom_name'].' '.(($item['uom_id_2']!=0)?'| '.$item['units_on_workshop_2'].' '.$item['uom_name_2']:'').'</td>
                                            <td align="center">'.$item['units_on_consignee'].' '.$item['uom_name'].' '.(($item['uom_id_2']!=0)?'| '.$item['units_on_consignee_2'].' '.$item['uom_name_2']:'').'</td>
                                        </tr>';
                                    $i++;
                                }
                   }
                   if($i==0){
                       $html_row .= '<tr>
                                <td>No Results found</td> 
                            </tr>';
                   }
                   
                   $html_tots = '<div class="row">
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Number of Items: </dt><dd>'.($i+1).'</dd>
                                </dl> 
                            </div>
                            
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Units: </dt>';
                            foreach ($all_tot_uom as $uom_unts){
                                $html_tots .= ' <dd>'.$uom_unts['unit1'].' '.$uom_unts['unit_abr'].(($uom_unts['unit2']>0)?'  |  '.$uom_unts['unit2'].' '.$uom_unts['unit_abr_2']:'').' </dd>';
                            }
                            
                          $html_tots .= '</dl> 
                            </div>
                        </div>';
                          
                          echo $html_tots.$html_row;
              ?>   
        </tbody> 
         </table> 