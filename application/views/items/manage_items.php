<?php
//	echo '<pre>';        print_r($stock_status); die;
	$result = array(
                        'id'=>"",
                        'item_code'=>(isset($new_item_code))?$new_item_code:'',
                        'item_name'=>"",
                        'treatment'=>"",
                        'color'=>"",
                        'certification'=>"",
                        'certification_no'=>"",
                        'length'=>0,
                        'width'=>0,
                        'height'=>0,
                        'description'=>"",
                        'item_category_id'=>"",
                        'item_uom_id'=>"",
                        'item_uom_id_2'=>"",
                        'item_type_id'=>"",
                        'addon_type_id'=>"",
                        'sales_excluded'=>0, 
                        'purchases_excluded'=>0, 
                        'image' => 'default.jpg', 
                        'images' => array(), 
                        'certificates_files' => array(), 
                        'status'=>"1",
            
                        'stock_unit'=>"0",
                        'stock_unit_2'=>"0",
                        'location_id'=>"0",
                        );   		
	
	 
	
	 $hide_spec='';
	 $hide_spec_add='';
	switch($action):
        case 'Add': 
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
                $hide_spec_add  = 'hidden';
                
	break;
	
	case 'Edit':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'Edit';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
		$hide_spec	= 'hidden'; 
                
                
	break;
	
	case 'Delete':
		if(!empty($user_data[0])){$result= $user_data[0];}  
		$heading	= 'Delete';
		$dis		= 'readonly';
		$view		= 'hidden';
		$o_dis		= ''; 
		$check_bx_dis		= 'disabled'; 
	break;
      
	case 'View':
		if(!empty($user_data[0])){$result= $user_data[0];}  
		$heading	= 'View';
		$view		= 'hidden';
		$dis        = 'readonly';
		$o_dis		= 'disabled'; 
	break;
endswitch;	 

         $show_gem = ($result['is_gem']==1)?'':'hidden';
//                echo '<pre>';print_r(($result));
        
            // add files to our array with
            // made to use the correct structure of a file
            if( isset($result['images']) && $result['images'] != null && $result['images'] != 'null'){
                foreach(json_decode($result['images']) as $file) {
                        // skip if directory
                        if(is_dir($file))
                                continue; 
                        // add file to our array
                        // !important please follow the structure below
                        $appendedFiles[] = array(
                                                "name" => $file,
                                                "type" => get_mime_by_extension(ITEM_IMAGES.$result['id'].'/other/'.$file),
                                                "size" => (file_exists(ITEM_IMAGES.$result['id'].'/other/'.$file))?filesize(ITEM_IMAGES.$result['id'].'/other/'.$file):'',
                                                "file" => base_url(ITEM_IMAGES.$result['id'].'/other/'.$file),
                                                "data" => array(  "url" => base_url(ITEM_IMAGES.$result['id'].'/other/'.$file)
                                            )
                        ); 
                }

                // convert our array into json string
                if(isset($appendedFiles))$result['images'] = json_encode($appendedFiles);
            }
            
//            ///certificates files
            if( isset($result['certificates_files']) && $result['certificates_files'] != null && $result['certificates_files'] != 'null'){
                foreach(json_decode($result['certificates_files']) as $file) {
                        // skip if directory
                        if(is_dir($file))
                                continue; 
                        // add file to our array
                        // !important please follow the structure below
                        $appendedFiles_cert[] = array(
                                                "name" => $file,
                                                "type" => get_mime_by_extension(ITEM_IMAGES.$result['id'].'/certificates_files/'.$file),
                                                "size" => (file_exists(ITEM_IMAGES.$result['id'].'/certificates_files/'.$file))?filesize(ITEM_IMAGES.$result['id'].'/certificates_files/'.$file):'',
                                                "file" => base_url(ITEM_IMAGES.$result['id'].'/certificates_files/'.$file),
                                                "data" => array(  "url" => base_url(ITEM_IMAGES.$result['id'].'/certificates_files/'.$file)
                                            )
                        ); 
                }

                // convert our array into json string
                if(isset($appendedFiles_cert))$result['certificates_files'] = json_encode($appendedFiles_cert);
            }
//            echo '<pre>';            print_r($appendedFiles); die;
        
?> 
<style>
    
    .modal-dialog {width:800px;}
    .thumbnail {margin-bottom:6px;}
    .modal-body {width:800px; align:center;}
    .model_img {width: 500px;}
    .policy_tbl td, .pets_tbl  td{
        padding: 5px;
    }
</style>
<!-- Main content -->
 <br>
        <div class="col-md-12">
            
             <!--Flash Error Msg-->
                             <?php  if($this->session->flashdata('error') != ''){ ?>
					<div class='alert alert-danger ' id="msg2">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<i ></i>&nbsp;<?php echo $this->session->flashdata('error'); ?>
					<script>jQuery(document).ready(function(){jQuery('#msg2').delay(1500).slideUp(1000);});</script>
					</div>
				<?php } ?>
				
					<?php  if($this->session->flashdata('warn') != ''){ ?>
					<div class='alert alert-success ' id="msg2">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<i ></i>&nbsp;<?php echo $this->session->flashdata('warn'); ?>
					<script>jQuery(document).ready(function(){jQuery('#msg2').delay(1500).slideUp(1000);});</script>
					</div>
				<?php } ?>  
            <div class="top_links">
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-backward"></i>Back</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'.base_url($this->router->fetch_class().'/edit/'.$result['id']).'" class="btn btn-app "><i class="fa fa-pencil"></i>Edit</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$result['id']).'" class="btn btn-app  '.(($action=='Delete')?'hide ':'').' "><i class="fa fa-trash"></i>Delete</a>':''; ?>
                <!--<a class="btn btn-app "><i class="fa fa-trash"></i>Delete</a>-->
            </div>
        </div>
 <br><hr>
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $action;?> Item <?php echo ($result['item_code']!='')?'['.$result['item_code'].']':'';?> </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
             <?php echo form_open_multipart("Items/validate",'id="form_mng"'); ?> 
   
                    <div class="box-body ">
                              
                        <div class="row"> 
                            
                            <div class="col-md-12">
                                 <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                  <ul class="nav nav-tabs">
                                    <li id="nv_tab_1" class="active"><a href="#tab_1" data-toggle="tab">Information</a></li>  
                                    <li id="nv_tab_2"><a href="#tab_2" data-toggle="tab">Sales Pricing</a></li>
                                    <!--<li id="nv_tab_3"><a href="#tab_3" data-toggle="tab">Purchasing Pricing</a></li>--> 
                                    <li id="nv_tab_4"><a href="#tab_31" data-toggle="tab">Costing</a></li> 
                                    <li id="nv_tab_5"><a href="#tab_4" data-toggle="tab">Images/Certificates</a></li> 
                                    <!--<li><a href="#tab_5" data-toggle="tab">Transection</a></li>--> 
                                    <li id="nv_tab_6"><a href="#tab_6" data-toggle="tab">Status</a></li> 

                                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                                  </ul>
                                  <div class="tab-content fl_scrollable_x_y">
                                      <div class="tab-pane active" id="tab_1"> 
                                              <div class="row"> 
                                                  <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Item Code<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('item_code', set_value('item_code', $result['item_code']), 'id="item_code" class="form-control" placeholder="Enter Item unique code"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('item_code');?></span>
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Item Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('item_name', set_value('item_name', $result['item_name']), 'id="item_name" class="form-control" placeholder="Inte item name"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('item_name');?></span>
                                                    </div> 
                                                </div> 
                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Description<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       <?php echo form_textarea(array('name'=>'description','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter description' ), set_value('description',$result['description']),$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('description');?></span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Category<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_category_id',$item_category_list,set_value('item_category_id',$result['item_category_id']),' class="form-control select2" data-live-search="true" id="item_category_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_category_id');?></span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Unit of Measure<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_uom_id',$item_uom_list,set_value('item_uom_id',$result['item_uom_id']),' class="form-control " data-live-search="true" id="item_uom_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_uom_id');?></span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Secondary UOM<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_uom_id_2',$item_uom_list_2,set_value('item_uom_id_2',$result['item_uom_id_2']),' class="form-control " data-live-search="true" id="item_uom_id_2" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_uom_id_2');?></span>
                                                    </div> 
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Item Type<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_type_id',$item_type_list,set_value('item_type_id',$result['item_type_id']),' class="form-control " data-live-search="true" id="item_type_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_type_id');?></span>
                                                    </div> 
                                                </div>
                                                <div hidden class="form-group">
                                                    <label class="col-md-3 control-label">Addon/Tax Type<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('addon_type_id',$addon_type_list,set_value('addon_type_id',$result['addon_type_id']),' class="form-control " data-live-search="true" id="addon_type_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('addon_type_id');?></span>
                                                    </div> 
                                                </div>
                                            </div>
                                          
                                         <div class="col-md-6">
                                             <div <?php echo $show_gem;?>  class="form-group gem_field">
                                                <label class="col-md-3 control-label">Treatments<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                   <?php  echo form_dropdown('treatment',$treatments_list,set_value('treatment',$result['treatment']),' class="form-control select2" data-live-search="true" id="treatment" '.$o_dis.'');?> 
                                                    <?php echo form_error('treatment');?>&nbsp;
                                                </div> 
                                            </div>
											
                                             <div <?php echo $show_gem;?> class="form-group gem_field">
                                                    <label class="col-md-3 control-label">Color<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                             <?php  echo form_dropdown('color',$color_list,set_value('color',$result['color']),' class="form-control select2" data-live-search="true" id="color" '.$o_dis.'');?> 
                                                  <?php echo form_error('color');?>&nbsp;
                                                    </div> 
                                            </div>
											
                                                <div  <?php echo $show_gem;?> class="form-group gem_field">
                                                    <label class="col-md-3 control-label">Shape<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       	 <?php  echo form_dropdown('shape',$shape_list,set_value('shape',$result['shape']),' class="form-control select2" data-live-search="true" id="shape" '.$o_dis.'');?> 
														<?php echo form_error('shape');?>&nbsp;
                                                    </div> 
                                                </div>
                                             
                                                <div  <?php echo $show_gem;?> class="form-group gem_field">
                                                    <label class="col-md-3 control-label">Measurement/mm<span style="color: red"></span></label>

                                                    <div class="col-md-3">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="">L</span></span>
                                                            <?php echo form_input('length', set_value('length',$result['length']), 'id="length" class="form-control" placeholder="Length mm"'); ?>
                                                            <span class="help-block"><?php echo form_error('length');?></span>
                                                        </div>     
                                                        &nbsp;                                       
                                                    </div>

                                                    <div class="col-md-3">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="">W</span></span>
                                                            <?php echo form_input('width', set_value('width',$result['width']), 'id="width" class="form-control" placeholder="Width mm"'); ?>
                                                            <span class="help-block"><?php echo form_error('width');?></span>
                                                        </div> 
                                                        &nbsp;                                           
                                                    </div>

                                                    <div class="col-md-3">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="">H</span></span>
                                                            <?php echo form_input('height', set_value('height',$result['height']), 'id="height" class="form-control" placeholder="Height mm"'); ?>
                                                            <span class="help-block"><?php echo form_error('height');?></span>
                                                        </div>        
                                                        &nbsp;
                                                    </div> 
                                                </div> 
                                             
                                            <div <?php echo $show_gem;?> class="form-group gem_field">
                                                <label class="col-md-3 control-label">Certification<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                   <?php  echo form_dropdown('certification',$certification_list,set_value('certification',$result['certification']),' class="form-control select2" data-live-search="true" id="certification" '.$o_dis.'');?> 
                                                    <?php echo form_error('certification');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div <?php echo $show_gem;?>  class="form-group gem_field">
                                                <label class="col-md-3 control-label">Certification No<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('certification_no', set_value('certification_no', $result['certification_no']), 'id="certification_no" class="form-control" style=" text-transform:capitalize;"  placeholder="Enter Certification Number"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('certification_no');?>&nbsp;
                                                </div> 
                                            </div>
                                             			
                                                <div  <?php echo $show_gem;?> class="form-group gem_field">
                                                    <label class="col-md-3 control-label">Origin<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       	 <?php  echo form_dropdown('origin',$origin_list,set_value('origin',$result['origin']),' class="form-control select2" data-live-search="true" id="origin" '.$o_dis.'');?> 
														<?php echo form_error('origin');?>&nbsp;
                                                    </div> 
                                                </div>
                                             <div class="form-group">
                                                    <label class="col-md-3 control-label">Exclude from Purchase</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('purchases_excluded', set_value('purchases_excluded','1'),$result['purchases_excluded'], 'id="purchases_excluded" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('purchases_excluded');?></span>
                                                    </div>
                                                </div> 
                                             
                                                      
                                             <div class="form-group">
                                                    <label class="col-md-3 control-label">Exclude from sales</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('sales_excluded', set_value('sales_excluded','1'),$result['sales_excluded'], 'id="sales_excluded" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('sales_excluded');?></span>
                                                    </div>
                                                </div> 

                                                <div class="form-group">
                                                       <label class="col-md-3 control-label">Active</label>
                                                       <div class="col-md-9">                                            
                                                           <div class="input-group">
                                                                <label class="switch  switch-small">
                                                                   <!--<input type="checkbox"  value="0">-->
                                                                   <?php echo form_checkbox('status', set_value('status','1'),$result['status'], 'id="status" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                   <span></span>
                                                               </label>
                                                            </div>                                            
                                                           <span class="help-block"><?php echo form_error('status');?></span>
                                                       </div>
                                                   </div> 
                                             
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Item Image</label>
                                                <div class="col-md-6">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                         <?php // echo form_input(array('name'=>'pic1[]', 'multiple'=>'multiple','id'=>'pic1', 'class'=>'form-control fl_file', 'type'=>'file'));?>
                                                        <?php echo form_input(array('name'=>'image','id'=>'image', 'class'=>'form-control fl_file', 'type'=>'file'));?>
                                                    </div>    
                                                    <span class="help-block"><?php echo form_error('image');?></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <img id="def_img_holder" class="profile-user-img img-responsive img-circle thumbnail" src="<?php echo base_url(ITEM_IMAGES.(($result['image']!="")?$result['id'].'/'.$result['image']:'../default/default.jpg')); ?>" alt="User profile picture">
                                                </div>
                                            </div>
                                          
                                         </div>
                                              </div>

                                      </div>
                                      
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_2">
                                        <?php // echo form_open("", 'id="form_sales_price" class="form-horizontal"')?>      
                                          <div class="col-md-9">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Sales Type</th>
                                                        <th>Currency</th>
                                                        <th>Price</th> 
                                                    </tr>
                                                    <?php
                                                    foreach ($sales_type_list as $key=>$sale_type){
                                                        $sale_price_arr = array();
                                                        if(isset($item_prices['sales'])){
                                                            foreach ($item_prices['sales'] as $sale_price){
                                                                if($sale_price['sales_type_id']==$key){
                                                                    $sale_price_arr = $sale_price;
                                                                    break;
                                                                }else{
                                                                    $sale_price_arr=0;
                                                                }
                                                            }
                                                        }
                                                        
                                                        echo '
                                                                <tr>
                                                                    <td>'.$sale_type.'</td>
                                                                    <td>'.form_dropdown('prices[sales]['.$key.'][currency_id]',$currency_list,set_value('prices["sales"]currency_id['.$key.']',(isset($sale_price_arr['currency_code'])?$sale_price_arr['currency_code']:0)),' class="form-control" data-live-search="true" id="prices["sales"]currency_id['.$key.']" '.$o_dis.''). form_hidden('prices[sales]['.$key.'][sales_type_id]',$key).' </td> 
                                                                    <td>'.form_input('prices[sales]['.$key.'][amount]', set_value('prices["sales"]amount['.$key.']', number_format((isset($sale_price_arr['price_amount'])?$sale_price_arr['price_amount']:0),2,'.','')), 'id="prices["sales"]amount['.$key.']" class="form-control" placeholder="Enter Short name"'.$dis.' '.$o_dis.' ').'</td>
                                                                  </tr>  
                                                            ';
                                                    }
                                                    ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div> 
                                          
                                          <div <?php echo $view;?> class="col-md-12">
                                            <a id="sp_submit_btn" class="btn btn-default">Update</a>
                                            <div id="sp_result"></div>
                                            <hr>
                                        </div>
                                          
                                        <?php // echo form_close(); ?>   
                                      </div>
                                      <!-- /.tab-pane --> 
                                      
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_3">
                                          <div  <?php echo $view;?> class="col-md-12">
                                              <h4>Purchasing price add</h4><hr>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Supplier<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php  echo form_dropdown('prices[purchasing][supplier_id]',$supplier_list,set_value('customer_type_id'),' class="form-control select2" data-live-search="true" style="width:100%;" id="prices[purchasing][supplier_id]" '.$o_dis.'');?> 
                                                         <span class="help-block"><?php echo form_error('prices[purchasing][supplier_id]');?></span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Price<span style="color: red"></span></label>
                                                  <div class="col-md-9">    
                                                       <?php echo form_input('prices[purchasing][purchasing_amount]', set_value('prices[purchasing][purchasing_amount]'), 'id="prices[purchasing][purchasing_amount]" class="form-control" placeholder="Enter prices"'.$dis.' '.$o_dis.' '); ?>
                                                      <span class="help-block"><?php echo form_error('prices[purchasing][purchasing_amount]');?></span>
                                                  </div> 
                                                </div>
                                                  <div class="form-group">
                                                    <label class="col-md-3 control-label">Currency<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php  echo form_dropdown('prices[purchasing][purchasing_currency]',$currency_list,set_value('prices[purchasing][purchasing_currency]'),' class="form-control select2"  style="width:100%;" data-live-search="true" id="prices[purchasing][purchasing_currency]" '.$o_dis.'');?> 
                                                         <span class="help-block"><?php echo form_error('prices[purchasing][purchasing_currency]');?></span>
                                                    </div> 
                                                </div> 
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Supplier Unit<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('prices[purchasing][supplier_unit]', set_value('prices[purchasing][supplier_unit]'), 'id="prices[purchasing][supplier_unit]" class="form-control" placeholder="Enter supplier_unit "'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('prices[purchasing][supplier_unit]');?></span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Unit conversation<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('prices[purchasing][unit_conversation]', set_value('prices[purchasing][unit_conversation]'), 'id="prices[purchasing][unit_conversation]" class="form-control" placeholder="Enter unit_conversation "'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('prices[purchasing][unit_conversation]');?></span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Note<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('prices[purchasing][description]', set_value('prices[purchasing][description]'), 'id="prices[purchasing][description]" class="form-control" placeholder="Enter description "'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('prices[purchasing][description]');?></span>
                                                    </div> 
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                  <a id="pp_submit_btn" class="btn btn-default">Add New</a>
                                                  <hr>
                                                  <!--<div id="pp_result"></div>-->
                                              </div> 
                                        </div>
                                          <div class="col-md-12">
                                                <div id="pp_result" class="col-md-12">

                                              </div> 
                                          </div>
                                    </div>
                                      <!-- /.tab-pane --> 
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_31">
                                          <div class="col-md-12">
                                             <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Date</th> 
                                                        <th>Type</th> 
                                                        <th>Person</th> 
                                                        <th>Currency</th> 
                                                        <th style="text-align: right;">Cost Amount</th> 
                                                        <th style="text-align: right;">Cost(<?php echo $default_currency['code'];?>)</th> 
                                                        <th>Action</th> 
                                                    </tr>
                                                    <?php
                                                    $tot_cost = 0;
                                                        if(isset($item_prices['purchasing']) && !empty($item_prices['purchasing'])){
                                                            $price_in_def = 0;
                                                            foreach ($item_prices['purchasing'] as $purch_info){
                                                                $price_in_def = $purch_info['cost_amount'] * ($default_currency['value'] / $purch_info['currency_value']);
                                                                echo   '<tr>
                                                                            <td>'. date(SYS_DATE_FORMAT,$purch_info['invoice_date']).'</td>
                                                                            <td>Purchased</td>
                                                                            <td>'.$purch_info['supplier_name'].'</td>
                                                                            <td>'.$purch_info['currency_code'].'</td>
                                                                            <td align="right">'. number_format($purch_info['cost_amount'],2).'</td>
                                                                            <td align="right">'.$default_currency['symbol_left'].' '. number_format($price_in_def,2).'</td>
                                                                            <td align="right"></td>
                                                                        </tr>'; 
                                                                $tot_cost +=$price_in_def;
                                                            }
                                                        }
                                                        
                                                        if(isset($lapidary_cost) && !empty($lapidary_cost)){
                                                            $price_in_def = 0;
                                                            foreach ($lapidary_cost as $lap_cost){
                                                                $price_in_def = $lap_cost['amount_cost'] * ($default_currency['value'] / $lap_cost['currency_value']);
                                                                echo   '<tr>
                                                                        <td>'. date(SYS_DATE_FORMAT,$lap_cost['receive_date']).'</td> 
                                                                        <td>'.(($lap_cost['gem_issue_type_name']!='')?$lap_cost['gem_issue_type_name']:$lap_cost['lapidary_type']).'</td>
                                                                        <td>'.(($lap_cost['dropdown_value']!='')?$lap_cost['dropdown_value']:$lap_cost['lapidary_name']).'</td>
                                                                        <td>'.$lap_cost['currency_code'].'</td>
                                                                        <td align="right">'. number_format($lap_cost['amount_cost'],2).'</td>
                                                                        <td align="right">'.$default_currency['symbol_left'].' '. number_format($price_in_def,2).'</td>
                                                                        <td>'.(($lap_cost['gem_receival_id']==0 && ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'remv_item_mng_cost')))?'<a id="lcost_'.$lap_cost['id'].'" title="Delete" class="btn btn-danger btn-xs cost_remove"><span class="fa fa-remove"></span></a>':'').'</td>
                                                                    </tr>'; 
                                                                $tot_cost +=$price_in_def;
                                                            }
                                                            }
                                                    
                                                    ?> 
                                                    <tr>
                                                        <td colspan="5" align="right"><b>Total Cost</b></td>
                                                        <td align="right"><b><?php echo $default_currency['symbol_left'].' '.number_format($tot_cost,2);?></b></td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                              <div id="res_cost"></div>
                                        </div>
                                          <!--Expemses quick entry-->
                                          <?php if(($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'remv_item_mng_cost'))) { ?>
                                          <div class="col-lg-12"> 
                                                                <hr>
                                            <div class="panel box box-primary">
                                                <div class="box-header with-border">
                                                  <h4 class="box-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                      Click Here to Add quick cost entry
                                                    </a>
                                                  </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse ">
                                                  <div class="box-body">
                                                      <div class="row"> 
                                                                <div class="">
                                                                    <div id='add_item_form' class="col-md-12"> 
                                                                        <div class="form-group col-md-3">
                                                                            <label for="paymen_trem_id">Payment Term</label>
                                                                            <?php  echo form_dropdown('paymen_trem_id',$payment_term_list,set_value('paymen_trem_id'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="paymen_trem_id"');?>
                                                                        </div>
                                                                        <table id="example1" class="table bg-gray-light table-bordered table-striped">
                                                                            <thead>
                                                                               <tr>
                                                                                   <td>
                                                                                        <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="entry_date">Date</label>
                                                                                            <?php  echo form_input('entry_date',set_value('entry_date', date(SYS_DATE_FORMAT)),'readonly class="form-control datepicker add_item_inpt" data-live-search="true" id="entry_date"');?>
                                                                                        </div>
                                                                                        </div>
                                                                                   </td>
                                                                                   <td>
                                                                                        <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="gem_issue_type_id">Lapidary Type</label>
                                                                                            <?php  echo form_dropdown('gem_issue_type_id',$gem_issue_type_list,set_value('gem_issue_type_id'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="gem_issue_type_id"');?>
                                                                                        </div>
                                                                                        </div>
                                                                                   </td> 
                                                                                   <td>
                                                                                        <div class="col-md-12">
                                                                                            <div hidden id="gem_cutter_div"  class="form-group">
                                                                                                <label for="gem_cutter_id">Gem Cutter</label>
                                                                                                <?php  echo form_dropdown('gem_cutter_id',$cutter_list,set_value('gem_cutter_id'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="gem_cutter_id"');?>
                                                                                            </div>
                                                                                            <div hidden id="polishing_div"  class="form-group">
                                                                                                <label for="gem_polishing_id">Polishing</label>
                                                                                                <?php  echo form_dropdown('gem_polishing_id',$polishing_list,set_value('gem_polishing_id'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="gem_polishing_id"');?>
                                                                                            </div>
                                                                                            <div hidden id="heater_div"  class="form-group">
                                                                                                <label for="gem_heater_id">Heater</label>
                                                                                                <?php  echo form_dropdown('gem_heater_id',$heater_list,set_value('gem_heater_id'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="gem_heater_id"');?>
                                                                                            </div>
                                                                                            <div hidden id="lab_div"  class="form-group">
                                                                                                <label for="gem_lab_id">Laboratory</label>
                                                                                                <?php  echo form_dropdown('gem_lab_id',$lab_list,set_value('gem_lab_id'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="gem_lab_id"');?>
                                                                                            </div>
                                                                                        </div>
                                                                                   </td> 

                                                                                   <td>
                                                                                        <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="memo">Memo</label>
                                                                                            <?php  echo form_input('memo',set_value('memo'),' class="form-control  add_item_inpt"  id="memo" placeholder="Have any note"');?>
                                                                                        </div>
                                                                                        </div>
                                                                                   </td>
                                                                                   <td>
                                                                                        <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="currency_code">Currency</label>
                                                                                            <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$default_currency['code']),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="currency_code"');?>
                                                                                        </div>
                                                                                        </div>
                                                                                   </td> 
                                                                                   <td>
                                                                                        <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="amount">Amount</label>
                                                                                            <input type="number" min="0"  step=".001" name="amount" class="form-control add_item_inpt" id="amount" value="0" placeholder="Enter Amount ">
                                                                                        </div>
                                                                                        </div>
                                                                                   </td> 
                                                                                   <td>
                                                                                        <div class="col-md-12">
                                                                                        <div class="form-group"><br>
                                                                                            <span id="add_item_btn" class="btn-default btn add_item_inpt">Add</span>
                                                                                        </div>
                                                                                        </div>
                                                                                   </td>
                                                                               </tr>
                                                                           </thead>
                                                                        </table>
                                                                    </div>

                                                                    <div class="box-body fl_scrollable"> 
                                                                        <table id="invoice_list_tbl" class="table table-bordered table-striped">
                                                                            <thead>
                                                                               <tr>
                                                                                   <th width="5%">#</th>
                                                                                   <th width="10%"  style="text-align: center;">Date</th> 
                                                                                   <th width="20%" style="text-align: left;">Lapidary Type</th>  
                                                                                   <th width="15%" style="text-align: left;">Lapidarist</th> 
                                                                                   <th width="15%" style="text-align: left;">Memo</th> 
                                                                                   <th width="15%" style="text-align: center;">Currency</th> 
                                                                                   <th width="15%" style="text-align: right;">Amount</th> 
                                                                                   <th width="5%" style="text-align: center;">Action</th>
                                                                               </tr>
                                                                           </thead>
                                                                           <tbody>

                                                                           </tbody>
                                                                           <tfoot>
                                                                                <tr>
                                    <!--                                                <th colspan="5"></th>
                                                                                    <th  style="text-align: right;">Sub Total</th>
                                                                                    <th  style="text-align: right;"><input hidden value="0" name="invoice_total" id="invoice_total"><span id="inv_total">0</span></th>
                                                                                    <th  style="text-align: right;"></th>
                                                                                </tr>-->

                                                                                <tr hidden>
                                                                                    <th colspan="3"></th>
                                                                                    <th  style="text-align: right;">Total</th>
                                                                                    <th  style="text-align: right;"><input hidden value="0" name="invoice_total" id="invoice_total"><span id="inv_total">0</span></th>
                                                                                </tr> 
                                                                           </tfoot>
                                                                            </table>
                                                                    </div>
                                                                    <div id="search_result_1"></div>
                                                                </div>    
                                                            </div>
                                                  </div>
                                                </div>
                                              </div>
                                                
                                          </div>
                                          <?php } ?>
                                      </div>
                                      <!-- /.tab-pane --> 
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_4">
                                           <div class="col-md-12">
                                               <br>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">All Images</label>
                                                    <div class="col-md-9">                                            
                                                           
                                                        <div class="fl_file_uploader2">
                                                            <input type="file" name="item_images" class="fl_files" data-fileuploader-files='<?php echo $result['images'];?>'> 
                                                        </div> 
                                                        <span class="help-block"><?php echo form_error('item_images');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                           <div class="col-md-12">
                                               <br>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Certificates</label>
                                                    <div class="col-md-9">                                            
                                                           
                                                        <div class="fl_file_uploader2">
                                                            <input type="file" name="certificates_files" class="fl_files" data-fileuploader-files='<?php echo $result['certificates_files'];?>'> 
                                                        </div> 
                                                        <span class="help-block"><?php echo form_error('certificates_files');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                           <div class="col-md-12">
                                               <br>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Videos</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="row no-pad-top">
                                                            <div class="fl_file_uploader2">
                                                                <input type="file" name="item_videos" class="fl_files" data-fileuploader-files=''> 
                                                            </div> 
                                                            <span class="help-block"><?php echo form_error('item_videos');?></span>
                                                        </div>
                                                        <div class="row">    
                                                            <?php
                                                            if(isset($result['videos'])){
                                                                $vdos = json_decode($result['videos']);
                                                                if(!empty($vdos)){
                                                                    foreach ($vdos as $key=>$vdo){
                                                                        echo '<div class="col-md-4  '.$key.'_vdo">
                                                                                <video width="100%" controls>
                                                                                    <source src="'.base_url(ITEM_IMAGES.$result['id'].'/videos/'.$vdo).'" id="video_here">
                                                                                      Your browser does not support HTML5 video.
                                                                                </video>
                                                                                <a id="'.$key.'_vdo" class="btn-sm btn-danger center fa fa-trash remove_img_inv"></a> '.$vdo.'
                                                                                <input hidden value="'.$vdo.'" name="exist_vdos['.$key.']" >
                                                                            </div>';
                                                                    }
                                                                }
                                                            }
                                                            ?> 

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                      </div>
                                      <!-- /.tab-pane --> 
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_5">
                                          <div class="col-md-12">
                                            
                                        </div> 
                                      </div>
                                      <!-- /.tab-pane --> 
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_6">
                                          <div class="col-md-12">
                                             <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Location</th>
                                                        <th>Quantity on Hand</th> 
                                                        <th>On Order</th> 
                                                        <th>Available</th> 
                                                    </tr>
                                                    <?php
                                                        foreach ($stock_status as $stock_loc){
//                                                            echo '<pre>';   print_r($stock_loc);
                                                            echo '<tr>
                                                                        <td>'.$stock_loc['location_name'].'</td>
                                                                        <td>'.$stock_loc['units_available'].' '.$stock_loc['uom_name'].(($stock_loc['uom_id_2']!=0)?' | '.$stock_loc['units_available_2'].' '.$stock_loc['uom_name_2']:'').'</td>
                                                                        <td>'.$stock_loc['units_on_order'].' '.$stock_loc['uom_name'].'</td>
                                                                        <td>'.($stock_loc['units_available']-$stock_loc['units_on_consignee'] - $stock_loc['units_on_order']).' '.$stock_loc['uom_name'].' | '.($stock_loc['units_available_2']-$stock_loc['units_on_consignee_2'] - $stock_loc['units_on_order_2']).' '.$stock_loc['uom_name_2'].'</td>
                                                                      
                                                                      </tr>  ';
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                        </div> 
                                      </div>
                                      <!-- /.tab-pane --> 
                                  </div>
                                  <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
                            </div>
                            
                                             
                                            
                                        
                        </div>
                    </div>
                          <!-- /.box-body -->

                    <div class="box-footer">
                          <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $result['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit', constant($action) ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url($this->router->fetch_class()),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php // echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url($this->router->fetch_class()),'OK','class="btn btn-primary"');
                                    } ?>
                      <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                    </div>
                  </form>
                </div>
                <!-- /.box -->
          </div> 
    </section> 
 
 
<!--     //image Lightbox-->
     <div tabindex="-1" class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            <div class="modal-content"> 
                  <div align="" class="modal-body">
                      <div><center><img class="model_img"   src=""></center> </div>
                  </div>
                  <div class="modal-footer">
                          <button class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
             </div>
            </div>
          </div>
 
<script>
    
$(document).ready(function(){ 
    
    //    tab handler
    var actv_tab_id = "<?php echo ((isset($_GET['tbs']))?$_GET['tbs']:'');?>";
    if(actv_tab_id!=''){
//        alert(actv_tab_id);
        $('[href="#'+actv_tab_id+'"]').tab('show'); 
    }
    
    
    get_category();
    $("form").submit(function(){ 
        if(!confirm("Click Ok to Confirm form Submition.")){
               return false;
        }
    });
    $(".top_links a").click(function(){ 
        if(!confirm("Click Ok to Confirm leave from here. This form may have unsaved data.")){
               return false;
        }
    });

    $('#icon_view').addClass($('#icon').val());
    $("#icon").keyup(function(){ 
//		fl_alert('info',);
                $('#icon_view').removeClass();
                $('#icon_view').addClass($('#icon').val());
    });
    
    
    load_purchasing_price()
     $("#sp_submit_btn").click(function(){
         if(confirm("Click Ok to confirm Sales price update.")){
		update_sale_price();
         }else{
             return false;
         }   
    });
     $("#pp_submit_btn").click(function(){ 
         if(confirm("Click Ok to confirm Purchasing price update.")){
		update_purchasing_price();
         }else{
             return false;
         } 
    });
    
    
    $('.remove_img_inv').click(function(){
            fl_alert('info',this.id);
        var id = this.id;
        $('.'+id).remove();
    });
    
    $('#item_category_id').change(function(){
        get_category();
    });
    
    $('#gem_issue_type_id').change(function(){ 
        var gi_type = $('#gem_issue_type_id').val();
        if(gi_type!=""){ $('#lapidrist_div').show() }
        $('#gem_cutter_div').hide();
        $('#heater_div').hide();
        $('#polishing_div').hide();
        $('#lab_div').hide();
        switch(gi_type){
            case '1': $('#gem_cutter_div').show(); break; //facetting
            case '2': $('#lab_div').show(); break; //Verbal Check
            case '3': $('#heater_div').show(); break; //Heat Process
            case '4': $('#gem_cutter_div').show(); break; //Cut Process
            case '5': $('#polishing_div').show(); break; //Polishing Process
            case '6': $('#gem_cutter_div').show(); break; //Recut
            case '7': $('#lab_div').show(); break; //Cert lab
        }
        
        $('.select2').select2();
        
    });
    
    $("#add_item_btn").click(function(){
        var rowCount = $('.itm_rows').length; 
        
        if(lapidarist_id==""){
            fl_alert('info',"Please Select Quick Entry Account");
            return false;
        }
        if(parseFloat($('#amount').val())<=0){
            fl_alert('info',"Invalid amount");
            return false;
        } 
        
        var lapidarist_id = '';
        var lapidarist_name = '';
        switch($('#gem_issue_type_id').val()){
            case '1': lapidarist_id = $('#gem_cutter_id').val(); lapidarist_name = $('#gem_cutter_id option:selected').text(); break; //facetting
            case '2': lapidarist_id = $('#gem_lab_id').val(); lapidarist_name = $('#gem_lab_id option:selected').text(); break; //Verbal Check
            case '3': lapidarist_id = $('#gem_heater_id').val(); lapidarist_name = $('#gem_heater_id option:selected').text(); break; //Heat Process
            case '4': lapidarist_id = $('#gem_cutter_id').val(); lapidarist_name = $('#gem_cutter_id option:selected').text(); break; //Cut Process
            case '5': lapidarist_id = $('#gem_polishing_id').val(); lapidarist_name = $('#gem_polishing_id option:selected').text(); break; //Polishing Process
            case '6': lapidarist_id = $('#gem_cutter_id').val(); lapidarist_name = $('#gem_cutter_id option:selected').text(); break; //Recut
            case '7': lapidarist_id = $('#gem_lab_id').val(); lapidarist_name = $('#gem_lab_id option:selected').text(); break; //Cert lab
                
        }
        
        var newRow = $('<tr class="itm_rows" style="padding:10px" id="tr_'+rowCount+'">'+
                            '<td>'+(rowCount)+'</td>'+
                            '<td><input hidden name="cost_entry['+rowCount+'_'+lapidarist_id+'][entry_date]" value="'+$('#entry_date').val()+'">'+$('#entry_date').val()+'</td>'+
                            '<td><input hidden name="cost_entry['+rowCount+'_'+lapidarist_id+'][gem_issue_type_id]" value="'+$('#gem_issue_type_id').val()+'">'+$('#gem_issue_type_id option:selected').text()+'</td>'+
                            '<td><input hidden name="cost_entry['+rowCount+'_'+lapidarist_id+'][lapiadrist_id]" value="'+lapidarist_id+'">'+lapidarist_name+'</td>'+
                            '<td><input hidden name="cost_entry['+rowCount+'_'+lapidarist_id+'][memo]" value="'+$('#memo').val()+'">'+$('#memo').val()+'</td>'+
                            '<td align="center"><input  hidden name="cost_entry['+rowCount+'_'+lapidarist_id+'][currency_code]" value="'+$('#currency_code').val()+'">'+$('#currency_code').val()+'</td>'+
                            '<td align="right"><input class="item_tots" hidden name="cost_entry['+rowCount+'_'+lapidarist_id+'][amount]" value="'+$('#amount').val()+'">'+parseFloat($('#amount').val()).toFixed(2)+'</td>'+
                            '<td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                        '</tr>'); 
        jQuery('table#invoice_list_tbl ').append(newRow);
        var inv_total = parseFloat($('#invoice_total').val()) + parseFloat($('#amount').val());
        $('#amount').val(0);
        $('#invoice_total').val(inv_total.toFixed(2));
        $('#inv_total').text(inv_total.toFixed(2));
        
          
        //delete row
        $('.del_btn_inv_row').click(function(){
//            if(!confirm("click ok Confirm remove this Entry.")){
//                return false;
//            }
            var tot_amt = 0;
            $(this).closest('tr').remove(); 
            $('input[class^="item_tots"]').each(function() {
//                                        console.log(this);
                tot_amt = tot_amt + parseFloat($(this).val());
            });
            $('#invoice_total').val(tot_amt.toFixed(2));
            $('#inv_total').text(tot_amt.toFixed(2)); 
        }); 

        
        
    });
    
    // remove the quick cost entry 
    $('.cost_remove').click(function(){
        var lcost_id =  (this.id).split('_')[1];
        if(!confirm("Click Ok to remove the cost entry!")){
            return false;
        }
        quick_cost_removal(lcost_id);
    });     
    
    function quick_cost_removal(lcost_id){  
            $.ajax({
			url: "<?php echo site_url('Items/fl_ajax');?>",
			type: 'post',
			data : {function_name:'quick_cost_removal', lcost_id:lcost_id},
			success: function(result){ 
                            if(result=='1'){
//                                alert($('input[name=id]').val());  
                                window.location.href = "<?php echo base_url($this->router->fetch_class().'/edit/'.$result['id'].'?tbs=tab_31');?>";
                            }
//                            var res1 = JSON.parse(result);
                            
                        }
		}); 
    }
    
    
    function update_sale_price(){
//        fl_alert('info',)
        $.ajax({
			url: "<?php echo site_url('Items/update_sales_price');?>",
			type: 'post',
			data : jQuery('#form_mng').serializeArray(),
			success: function(result){ 
                             $("#sp_result").html(result);
                        }
		});
    }
    function update_purchasing_price(){ 
        $.ajax({
			url: "<?php echo site_url('Items/update_purchasing_price');?>",
			type: 'post',
			data : jQuery('#form_mng').serializeArray(),
			success: function(result){
                             $("#pp_result").html(result);
                        }
		});
    }  
    function load_purchasing_price(){ 
        $.ajax({
			url: "<?php echo site_url('Items/load_purchasing_price');?>",
			type: 'post',
			data : jQuery('#form_mng').serializeArray(),
			success: function(result){
                             $("#pp_result").html(result);
                        }
		});
    }
    
    function get_category(){ 
            var cat_id = $('#item_category_id').val();
            $.ajax({
			url: "<?php echo site_url('Items/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_category', cat_id:cat_id},
			success: function(result){
                            var res1 = JSON.parse(result);
                            if(res1.is_gem==1){
                                $('.gem_field').show();
                                $('.select2').attr('style','width:100%');
                                
                            }else{
                                $('.gem_field').hide();
                            }
                        }
		}); 
    }
    
    
            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                            $('#def_img_holder').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".fl_file").change(function(){
                readURL(this);
            });
            
            $('.thumbnail').click(function(){ 
                      var title = $(this).parent('a').attr("src");
                      $(".model_img").attr("src",this.src); 
                      $('#myModal').modal({show:true});
                      
              }); 
});

 
</script>