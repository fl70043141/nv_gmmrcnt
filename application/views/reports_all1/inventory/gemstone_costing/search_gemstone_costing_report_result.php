
<table id="example1" class="table  dataTable table-bordered table-striped">
              <?php
              $html_row = "";
              $all_tot_units = $all_tot_units_2 = $all_tot_amount = $item_count = 0;
              $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//              echo '<pre>';              print_r($def_cur['value']); die;
              $html_row .= '<thead>
                                <tr>
                                    <th>#</th>
                                    <th style="text-align:center;">Code</th> 
                                    <th style="text-align:center;">Desc</th>  
                                    <th style="text-align:center;">Shape/CDC</th>  
                                    <th style="text-align:center;">Unit 1</th> 
                                    <th style="text-align:center;">Unit 2</th>   
                                    <th style="text-align:left;">Type</th>    
                                    <th style="text-align:left;">Person</th>    
                                    <th style="text-align:right;">Cost</th>    
                                    <th style="text-align:right;">Total Cost</th>    
                                </tr>
                            </thead>
                            <tbody>';
              
                    $i = 0; 
                    $cat_tot_units = $cat_tot_units_2 = $cat_tot_amount = 0;
                    if(!empty($rep_data)){
                        foreach ($rep_data as $item){ 
//                            echo '<pre>';                       print_r($item); die;
 
                                    $tot_lapid_cost =0 ;
                                    if($stock_stat==2 || $item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                                         $html_1 = $html_2 = '';
                                        $bg_colr = ($i%2==0)?'#F5F5F5':'#FFFFFF';
                                        if(!empty($item['lapidary_costs'])){
                                            foreach ($item['lapidary_costs'] as $lcost){ 
                                               $price_in_def = $lcost['amount_cost'] * ($def_cur['value'] / $lcost['currency_value']);
                                               $tot_lapid_cost +=$price_in_def;
                                               $html_2 .= '<tr style="background-color: '.$bg_colr.'">
                                                                   <td colspan="6"></td> 
                                                                   <td>'.(($lcost['gem_issue_type_name']!='')?$lcost['gem_issue_type_name']:$lcost['lapidary_type']).'</td>
                                                                   <td>'.(($lcost['dropdown_value']!='')?$lcost['dropdown_value']:$lcost['lapidary_name']).'</td>
                                                                   <td align="right">'. number_format($price_in_def,2).'</td>

                                                              </tr>';
                                           }
                                        }
                                        
                                        $tot_units = $item['units_available'] + $item['units_on_workshop'] + $item['units_on_consignee'];
                                        $tot_units_2 = $item['units_available_2'] + $item['units_on_workshop_2'] + $item['units_on_consignee_2'];
                                        $purch_cost = ($item['cost_amount'] / $item['ip_curr_value'])*$def_cur['value'];
                                        $cost = $purch_cost + $tot_lapid_cost;

                                        $cat_tot_units += $tot_units;
                                        $cat_tot_units_2 += $tot_units_2;
                                        $cat_tot_amount += $cost;

                                        $all_tot_units += $tot_units;
                                        $all_tot_units_2 += $tot_units_2;
                                        $all_tot_amount += $cost;
                                         $html_1 = '
                                             <tr style="background-color: '.$bg_colr.'">
                                                 <td>'.($i+1).'</td> 
                                                 <td align="center">'.$item['item_code'].'</td>
                                                 <td align="center">'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].':'. float2rat($item['partnership']).')</b>':'').'</td>
                                                 <td align="center">'.$item['shape_name'].(($item['treatment_name']!='' && $item['shape_name']!='')?'/':'').$item['treatment_name'].'</td>
                                                 <td align="center">'.$item['units_available'].' '.$item['uom_name'].'</td>
                                                 <td align="center">'.(($item['uom_id_2']!=0)?$item['units_available_2'].' '.$item['uom_name_2']:'-').'</td>
                                                 <td align="left">Purchase</td>
                                                 <td align="left">'.$item['supplier_name'].'</td> 
                                                 <td align="right">'. number_format($purch_cost,2).'</td>
                                                 <td rowspan="'.(count($item['lapidary_costs'])+1).'" align="right" style="vertical-align: bottom;">'. number_format($cost,2).'</td>
                                            </tr>';
                                         $i++;
                                         $item_count++;
                                         $html_row .= $html_1.$html_2;
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
                                    <dt>Units Available: </dt><dd>'.$all_tot_units.' '.((isset($item)?$item['uom_name'].(($item['uom_id_2']!=0)?' |  '.$all_tot_units_2.' '.$item['uom_name_2']:'-'):'')).' </dd>
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
