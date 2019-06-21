<table id="example1" class="table  dataTable table-bordered table-striped"><thead>
            <tr>
                <th>#</th>
                <th style="text-align:center;">Code</th> 
                <th style="text-align:center;">Desc</th>  
                <th style="text-align:center;">CDC</th> 
                <th style="text-align:center;">Color</th> 
                <th style="text-align:center;">Shape</th> 
                <th style="text-align:center;">In Stock</th>  
                <th style="text-align:center;">On Lapidary</th>   
                <th style="text-align:center;">On Consignee</th>   
            </tr>
        </thead>
        <tbody>
              <?php
                        $i = 0;  
                   foreach ($rep_data as $cust_id => $item){ 
//                       echo '<pre>';                       print_r($item); die;
                        
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die;
                                if($item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                                    echo '
                                        <tr>
                                            <td>'.($i+1).'</td> 
                                            <td align="center">'.$item['item_code'].'</td>
                                            <td align="center">'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].')</b>':'').'</td>
                                            <td align="center">'.$item['treatment_name'].'</td>
                                            <td align="center">'.$item['color_name'].'</td>
                                            <td align="center">'.$item['shape_name'].'</td>
                                            <td align="center">'.$item['units_available'].' '.$item['uom_name'].' '.(($item['uom_id_2']!=0)?'| '.$item['units_available_2'].' '.$item['uom_name_2']:'').'</td>
                                            <td align="center">'.$item['units_on_workshop'].' '.$item['uom_name'].' '.(($item['uom_id_2']!=0)?'| '.$item['units_on_workshop_2'].' '.$item['uom_name_2']:'').'</td>
                                            <td align="center">'.$item['units_on_consignee'].' '.$item['uom_name'].' '.(($item['uom_id_2']!=0)?'| '.$item['units_on_consignee_2'].' '.$item['uom_name_2']:'').'</td>
                                        </tr>';
                                    $i++;
                                }else{
                                        echo '<tr>
                                                <td>No Results found</td> 
                                            </tr>';
                                   } 
                   }
              ?>   
        </tbody> 
         </table> 