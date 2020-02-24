<table id="example1" class="table dataTable11 table-bordered table-striped">
         <thead>
            <tr>
                <th>#</th>
                <th>Image</th> 
                <th>Item code</th> 
                <th <?php echo ((NO_GEM==0)?"hidden":""); ?>>Item</th> 
                <th>Category</th> 
                <th <?php echo ((NO_GEM==0)?"hidden":""); ?>>Supplier</th>  
                <th>Selling price</th>
                <th>Shape</th>
                <th>Dimension</th>
                <th>Units</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
              <?php
                  $i = 0;
                   foreach ($search_list as $search){ 
                    //    echo"<pre>"; print_r($search); die;
                       $item_price = get_single_row_helper(ITEM_PRICES, "item_id= ".$search['id']." and item_price_type=2 and sales_type_id=15 and status=1 and deleted=0", '-id');
                         
                       $dimension = (($search['length']>0)?$search['length'].' x ':'').(($search['width']>0)?$search['width'].' x ':'').(($search['length']>0)?$search['height']:'');
                       $dimension = ($dimension!="")?$dimension.' mm '.$search['size']:$search['size'];

                       echo '
                           <tr>
                               <td>'.($i+1).'</td>
                               <td><img style="width:30px;height:30px;" src="'. base_url(ITEM_IMAGES.(($search['image']!="")?$search['id'].'/'.$search['image']:'../default/default.jpg')).'"></td> 
                               <td>'.$search['item_code'].'</td> 
                               <td '.((NO_GEM==0)?"hidden":"").'>'.$search['item_name'].'</td> 
                               <td>'.$search['category_name'].'</td> 
                               <td>'.((isset($item_price['price_amount'])?number_format($item_price['price_amount'],2):"")).'</td> 
                               <td>'.$search['shape_name'].'</td> 
                               <td>'.$dimension.'</td> 
                               <td '.((NO_GEM==0)?"hidden":"").'>'.((isset($search['supplier_name']))?$search['supplier_name']:'--').'</td> 
                               <td>'.((isset($search['purchasing_unit']))?$search['purchasing_unit'].' '.$search['unit_abbreviation'].' '.((isset($search['secondary_unit']) && $search['secondary_unit']>0 )?$search['secondary_unit'].' '.$search['unit_abbreviation_2']:'--'):'--').'</td> 
                               <td>'; 
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'view'))?'<a href="'. base_url($this->router->fetch_class().'/view/'.$search['id']).'" title="View" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span></a> ':'';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'. base_url($this->router->fetch_class().'/edit/'.$search['id']).'" title="Edit" class="btn btn-success btn-xs"><span class="fa fa-edit"></span></a> ':'';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'. base_url($this->router->fetch_class().'/delete/'.$search['id']).'" title="Delete" class="btn btn-danger btn-xs"><span class="fa fa-remove"></span></a> ':'';
                                   
                                echo '</td>  ';
                       $i++;
                   }
              ?>   
        </tbody>
           <tfoot>
           <tr>
                <th>#</th>
                <th>Image</th> 
                <th>Item code</th> 
                <th  <?php echo ((NO_GEM==0)?"hidden":""); ?>>Item name</th> 
                <th>Category</th> 
                <th <?php echo ((NO_GEM==0)?"hidden":""); ?>>Supplier</th>  
                <th>Selling price</th>
                <th>Shape</th>
                <th>Dimension</th>
                <th>Units</th>
                <th>Action</th>
           </tr>
           </tfoot>
         </table>
<script>
    $(document).ready(function() {
   
  $(".dataTable11").DataTable({"scrollX": true });
} );
</script>