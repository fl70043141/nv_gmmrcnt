<table id="example1" class="table  dataTable table-bordered table-striped"> 
            <thead>
                <tr>
                    <th>#</th>
                    <th style="text-align:center;">Item Code</th> 
                    <th style="text-align:center;">Desc</th>   
                    <th style="text-align:center;">Category</th>   
                    <th style="text-align:center;">Available</th>   
                    <th style="text-align:center;">Number of tags</th>   
                    <th style="text-align:center;">Action <input type="checkbox" value="1" id="all_add_check"></th>
                </tr>
            </thead>
            <tbody> 
              <?php 
//                       echo '<pre>';                       print_r($search); die; 
                       
                        
                        
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die;
                        $i = 0; 
                        if(!empty($search)){
                            foreach ($search as $item){
                                if($item['tot_units_avl_2'] > 0){
                                    echo '
                                        <tr class="tr_left_side" id="trid__'.$item['item_id'].'">
                                            <td>'.($i+1).'</td> 
                                            <td align="center">'.$item['item_code'].'<input hidden id="itemcode__'.$item['item_id'].'" class="itm_inpts" value="'.$item['item_code'].'"></td>
                                            <td align="center">'.$item['item_name'].'<input hidden id="itemname__'.$item['item_id'].'" class="itm_inpts" value="'.$item['item_name'].'"><input hidden id="supcode__'.$item['item_id'].'" class="itm_inpts" value="'.$item['supplier_ref'].'"></td>
                                            <td align="center">'.$item['category_code'].'<input hidden id="catcode__'.$item['item_id'].'" class="itm_inpts" value="'.$item['category_code'].'"></td>
                                            <td align="center">'.$item['tot_units_avl'].' '.$item['uom_name'].(($item['tot_units_avl_2']>0)?'/'.$item['tot_units_avl_2'].' '.$item['uom_name_2']:'').'</td>
                                            <td align="center"><input type="number" pad="1" min="1"  id="print-nos__'.$item['item_id'].'" class="itm_inpts" value="1"></td>
                                            <td align="center"> 
                                                 <a id="printrool__'.$item['item_id'].'" class="btn btn-sm bg-aqua print_btn_rolltype"><span class="fa fa-plus"></span></a>
                                           </td>   
                                        </tr>';
                                    $i++;
                                }
                            }
                       }else{ 
                       }  
              ?>   
        </tbody> 
         </table> 
<script>
    $(document).ready(function(){
        $('.print_btn').click(function(){
            
            var purchse_id = (this.id).split('_')[1];
//            fl_alert('info',this.id)  
            window.open('<?php echo $this->router->fetch_class()."/print_report?";?>'+'prc_id='+purchse_id,'ZV VINDOW',width=600,height=300)
        });
    });
    $(document).ready(function(){
        $('.print_btn_rolltype').click(function(){
            
            var item_id = (this.id).split('__')[1];
            var item_code =  $('#itemcode__'+item_id).val();
            var item_name =  $('#itemname__'+item_id).val();
            var supcode =  $('#supcode__'+item_id).val();
            var cat_code =  $('#catcode__'+item_id).val();
            var tags_nos =  $('#print-nos__'+item_id).val();
//            fl_alert('info',cat_code);
//            return false;
            var trow = '<tr class="row_class_rt" id="row-r_'+item_id+'">'+
                            '<td><span  class="num_list"></span></td>'+
                            '<td>'+item_code+'<input hidden name="item_ids['+item_id+'][supcode]" value="'+supcode+'"><input hidden name="item_ids['+item_id+'][id]" value="'+item_id+'"><input hidden name="item_ids['+item_id+'][code]" value="'+item_code+'"></td>'+
                            '<td>'+item_name+'</td><input hidden name="item_ids['+item_id+'][desc]" value="'+item_name+'"></td>'+
                            '<td>'+cat_code+'<input hidden name="item_ids['+item_id+'][cat_code]" value="'+cat_code+'"></td>'+
                            '<td align="center">'+tags_nos+'<input hidden name="item_ids['+item_id+'][nos]" value="'+tags_nos+'"></td>'+
                            '<td><a id="remv__'+item_id+'" class="btn btn-sm btn-danger rmv_btn"><span class="fa fa-chevron-circle-left"></span></a></td>'+
                        '</tr>';
                $('#print_list_div').prepend(trow);
                var j=1; 
                $($(".num_list").get().reverse()).each(function() {
                    $(this).text(j); j++;
        //                                        console.log(this); 
        
                });
                $('.rmv_btn').click(function(){
                    $(this).closest('tr').remove();
                });
                
                
                
            window.open('<?php echo $this->router->fetch_class()."/print_report_rolltype?";?>'+'prc_id='+purchse_id,'ZV VINDOW',width=600,height=300)
        });
        
        $('#all_add_check').click(function(){
//            alert()
//            $('.tr_left_side a').trigger('click');
        });
    });
</script>