
<table id="example1" class="table  dataTable table-bordered table-striped">
              <?php
              $html_row = "";
              $all_tot_units = $all_tot_units_2 = $all_tot_amount = $item_count = 0;
              $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//              echo '<pre>';              print_r($def_cur); die;
              $html_row .= '<thead>
                                <tr>
                                    <th>#</th>
                                    <th style="text-align:center;">Code</th> 
                                    <th style="text-align:center;">Desc</th>  
                                    <th style="text-align:center;">CDC</th> 
                                    <th style="text-align:center;">Color</th> 
                                    <th style="text-align:center;">Shape</th> 
                                    <th style="text-align:center;">Units</th>   
                                    <th style="text-align:right;">Unit Cost ('.$def_cur['code'].')</th>   
                                    <th style="text-align:right;">Total Cost('.$def_cur['code'].')</th>   
                                </tr>
                            </thead>
                            <tbody>';
              
                    $i = 0; 
                    $cat_tot_units = $cat_tot_units_2 = $cat_tot_amount = 0;
                    if(!empty($rep_data)){
                        foreach ($rep_data as $item){ 
//                            echo '<pre>';                       print_r($item); die;

                                     $tot_units = $item['units_available'] + $item['units_on_workshop'] + $item['units_on_consignee'];
                                     $tot_units_2 = $item['units_available_2'] + $item['units_on_workshop_2'] + $item['units_on_consignee_2'];
                                     $cost = (($item['price_amount'] / $item['ip_curr_value']) * $tot_units) + $item['total_lapidary_cost'];

                                     $cat_tot_units += $tot_units;
                                     $cat_tot_units_2 += $tot_units_2;
                                     $cat_tot_amount += $cost;

                                     $all_tot_units += $tot_units;
                                     $all_tot_units_2 += $tot_units_2;
                                     $all_tot_amount += $cost;

                                     if($item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                                         $html_row .= '
                                             <tr>
                                                 <td>'.($i+1).'</td> 
                                                 <td align="center">'.$item['item_code'].'</td>
                                                 <td align="center">'.$item['item_name'].'</td>
                                                 <td align="center">'.$item['treatment_name'].'</td>
                                                 <td align="center">'.$item['color_name'].'</td>
                                                 <td align="center">'.$item['shape_name'].'</td> 
                                                 <td align="center">'.$item['units_available'].' '.$item['uom_name'].' '.(($item['uom_id_2']!=0)?'| '.$item['units_available_2'].' '.$item['uom_name_2']:'-').'</td>
                                                 <td align="right">'. number_format(($item['price_amount'] / $item['ip_curr_value']),2).'</td>
                                                 <td align="right">'. number_format($cost,2).'</td>
                                                 </tr>';
                                         $i++;
                                         $item_count++;
                                     }
                                    
                        }
                    }else{
                            $html_row .= '<tr>
                                    <td>No Results found</td> 
                                </tr>';
                       }
                       $html_row .= '</tbody> </table>';
                   echo '<div class="row">
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Number of Items: </dt><dd>'.$item_count.'</dd>
                                </dl> 
                            </div>
                            
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Units: </dt><dd>'.$all_tot_units.' '.((isset($item)?$item['uom_name'].(($item['uom_id_2']!=0)?' |  '.$all_tot_units_2.' '.$item['uom_name_2']:'-'):'')).' </dd>
                                </dl> 
                            </div>
                                
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Costs: </dt><dd>'.$def_cur['code'].' '. number_format($all_tot_amount,2).'</dd>
                                </dl> 
                            </div>

                        </div>'.$html_row; 
              ?>   
        </tbody> 
         </table>
