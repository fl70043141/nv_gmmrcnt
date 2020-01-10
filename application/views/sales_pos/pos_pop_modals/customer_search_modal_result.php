
                 <table id="customer_tbl_rslt" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                               <th>#</th> 
                               <th>Customer Name</th> 
                               <th>Code</th> 
                               <th>Phone</th>  
                               <th>City</th>
                               <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php
                                $i=1;
//                echo '<pre>';            print_r($item_res); die;
                                foreach ($item_res as $item){
                                    echo '
                                            <tr class="customer-search-pick" id="customer-search-picktr_'.$item['id'].'" >
                                                <td>'.$i.'</td>
                                                <td>'.$item['customer_name'].'</td>
                                                <td><span id="cust_short_name_'.$item['id'].'">'.$item['short_name'].'</span></td>
                                                <td>'.$item['phone'].'</td>  
                                                <td>'.$item['city'].'</td>   
                                                <td><a id="customer-search-pick_'.$item['id'].'" class="btn btn-success btn-xs "><span class="fa fa-user-plus"></span></a></td>
                                           </tr> 
                                        ';
                                        $i++;
                                }
                           ?>
                            
                       </tbody>
                          <tfoot>
                           <tr>
                               <th>#</th> 
                               <th>Customer Name</th> 
                               <th>Code</th> 
                               <th>Phone</th>  
                               <th>City</th>
                               <th>Action</th>
                           </tr>
                          </tfoot>
                        </table> 
<script>
    $(document).ready(function() {
    $('#customer_tbl_rslt').DataTable();
} );
</script>