
                 <table id="itm_tbl_search_res1" class="table  table-bordered table-striped">
                        <thead>
                           <tr>
                               <th>#</th> 
                               <th>Item code</th> 
                               <th>Item name</th> 
                               <th>Category</th>   
                               <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php
                                $i=1;
                                foreach ($item_res as $item){
                                    echo '
                                            <tr class="item-search-pick" id="item-search-picktr_'.$item['item_code'].'" >
                                                <td>'.$i.'</td>
                                                <td>'.$item['item_code'].'</td>
                                                <td>'.$item['item_name'].'</td>
                                                <td>'.$item['item_category_name'].'</td>   
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
                               <th>Item name</th> 
                               <th>Category</th>   
                               <th>Action</th>
                           </tr>
                          </tfoot>
                        </table> 

<script>
    $(document).ready(function(){
        $('#itm_tbl_search_res1').DataTable();
    });
</script>