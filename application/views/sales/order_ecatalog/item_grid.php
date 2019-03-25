
 
<?php // echo '<pre>'; print_r($_GET); die;?>

<div class="row">
<div class="col-md-12">
    <!--<br>-->   
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
    
        
    </div>
    
<!-- <br><hr>-->
    <section  class="content">  
              <!-- general form elements -->
              <div class="box box-primary"> 
                <!-- /.box-header -->
                    <div class="box-body">
                            <!-- form start -->

                        <?php echo form_open("", 'id="form_search" class="form-horizontal"')?>  
                        <?php echo form_input('price_type_id', set_value('price_type_id', '16'),'id="price_type_id" hidden');?>  
                        <?php echo form_hidden('curr_page_no',$page_no,'id="form_search" class="form-horizontal"')?>  
                        <?php echo form_hidden('order_id')?>  
                        <div class="row"> 
                            <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Category Name:<span style="color: red">*</span></label>
                                        <div class="col-md-9">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                <?php  echo form_dropdown('item_category_id',$category_list,set_value('item_category_id',$category_id),' class="form-control select2" data-live-search="true" id="item_category_id"');?>
                                         
                                            </div>                                          
                                        </div>
                                    </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <label class="col-md-3 control-label">Item Code<span style="color: red"></span></label>
                                        <div class="col-md-9">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                <?php  echo form_input('item_code',set_value('item_code'),' class="form-control add_item_inpt" id="item_code"');?>
                                            </div>                                 
                                        </div>
                                    </div> 
                            </div> 
                        </div>
                            
                            <?php echo form_close(); ?> 
                    </div> 
              </div>
                                    
        <div class="box"> 
            <div class="box-body row">
                <div id="result_search_itm">
                </div>
            </div>
            
          </div>
       
    </section>              
   
     </div>
</div> 

<script>
$(document).ready(function(){
    
    get_item_results();
    $("#item_category_id").change(function(){ 
		event.preventDefault();
		get_item_results();
    });  
    $("#item_code").keyup(function(){ 
		event.preventDefault();
		get_item_results();
    });  
	
	  
    $('#list').click(function(event){event.preventDefault();$('#products .item').addClass('list-group-item');});
    $('#grid').click(function(event){event.preventDefault();$('#products .item').removeClass('list-group-item');$('#products .item').addClass('grid-group-item');});
});   
function get_item_results(){
            $("#result_search_itm").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    

            var post_data = jQuery('#form_search').serializeArray(); 
            post_data.push({name:"function_name",value:'search_items_for_cats'});
    //        console.log(post_data); 
            $.ajax({
                            url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
                            type: 'post',
                            data : post_data,
                            success: function(result){  
                                 $("#result_search_itm").html(result);
    //                             $(".dataTable").DataTable();
                        }
                    });
            }
</script>