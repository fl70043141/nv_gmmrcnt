 
<!-- Modal -->
<div class="modal fade" id="item_view_modal" tabindex="-1" role="dialog" aria-labelledby="item_view_modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="item_view_modalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body"> 
           <div class="container-fliud">
                   <div class=" row">
                           <div class="preview col-md-6">

                                   <div class="preview-pic tab-content">
                                     <div class="tab-pane active" id="pic-1"><img src="http://placekitten.com/400/252" /></div>
                                     <div class="tab-pane" id="pic-2"><img src="http://placekitten.com/400/252" /></div>
                                     <div class="tab-pane" id="pic-3"><img src="http://placekitten.com/400/252" /></div>
                                     <div class="tab-pane" id="pic-4"><img src="http://placekitten.com/400/252" /></div>
                                     <div class="tab-pane" id="pic-5"><img src="https://i.ebayimg.com/images/i/172693176555-0-1/s-l1000.jpg" /></div>
                                   </div>
                                   <ul class="preview-thumbnail nav nav-tabs">
                                     <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
                                     <li><a data-target="#pic-2" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
                                     <li><a data-target="#pic-3" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
                                     <li><a data-target="#pic-4" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
                                     <li><a data-target="#pic-5" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
                                   </ul>

                           </div>
                           <div class="details col-md-6">
                                   <h3 class="product-title">men's shoes fashion</h3> 
                                   <p class="product-description">Suspendisse quos? Tempus cras iure temporibus? Eu laudantium cubilia sem sem! Repudiandae et! Massa senectus enim minim sociosqu delectus posuere.</p>
                                   <h4 class="price">Price: <span>$180</span></h4>


                                   <div class="action">
                                           <button class="add-to-cart btn btn-default" type="button">add to cart</button>
                                           <button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button>
                                   </div>
                           </div>
                   </div>
           </div> 
         </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<script>
    $(document).ready(function(){
        $('.itm_btn_view').click(function(){ 
            $('#item_view_modal').modal({backdrop: 'static', keyboard: false });   
        });
    }); 
</script>
 