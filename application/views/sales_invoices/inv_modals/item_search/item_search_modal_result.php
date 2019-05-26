
                 <table id="example1" class="table dataTable table-bordered table-striped">
                        <thead>
                           <tr>
                               <th>#</th> 
                               <th>Item code</th> 
                               <th>Variety</th>   
                               <th>Treatment</th>   
                               <th>Shape</th>   
                               <th>Color</th>   
                               <th>Units</th>   
                               <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php
                                $i=1;
                                foreach ($item_res as $item){
//                                    echo '<pre>';                                    print_r($item); die;
                                    echo '
                                            <tr class="item-search-pick" id="item-search-picktr_'.$item['item_code'].'" >
                                                <td>'.$i.'</td>
                                                <td>'.$item['item_code'].'</td>
                                                <td>'.$item['item_category_name'].'</td> 
                                                <td>'.$item['treatment_name'].'</td>  
                                                <td>'.$item['shape_name'].'</td>  
                                                <td>'.$item['color_name'].'</td>  
                                                <td>'.$item['tot_units_avlbl'].' '.$item['uom_name'].(($item['uom_id_2']>0)?' | '.$item['tot_units_avlbl_2'].' '.$item['uom_name_2']:'').'</td>  
                                                <td><a id="item-search-pick_'.$item['item_code'].'" class="btn btn-success btn-xs "><span class="fa fa-cart-plus"></span></a></td>
                                           </tr> 
                                        ';
                                }
                           ?>
                            
                       </tbody>
                          <tfoot>
                          <tr>
                               <th>#</th> 
                               <th>Item code</th> 
                               <th>Variety</th>   
                               <th>Treatment</th>   
                               <th>Shape</th>   
                               <th>Color</th>   
                               <th>Units</th>   
                               <th>Action</th>
                           </tr>
                          </tfoot>
                        </table> 