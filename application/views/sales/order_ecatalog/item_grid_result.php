
<link rel="stylesheet" href="<?php echo base_url('templates/plugins/infinite_scroll/infinite-scroll-docs.css?5');?>">  


<div class="main">
  <div class="container container--wide">
 

    <div class="image-grid are-images-unloaded" data-js="image-grid">
      <div class="image-grid__col-sizer"></div>
      <div class="image-grid__gutter-sizer"></div>
        <div class="item   image-grid__item" style="position: absolute; left: 0%; top: 0px;">
                <div class="thumbnail">
                    <img class="group list-group-image img-bordered-sm" style="width:400px;" src="http://localhost/nveloop_gems/./storage/images/items/1/discount-chatham-created-aqua-blue-spinel-stone-round-shape-grade-gem-4-00-mm-in-size-0-35-carats-24.jpg" alt="">
                    <div class="caption">
                        <h4 class="group inner list-group-item-heading" style="text-align:center;"> N10001 |  BLUE SAPPHIRE</h4>
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <p class="" style="text-align:center;">Price LKR 250000</p>
                            </div>
                            <div class="col-xs-12 col-md-12 ">
                                <a id="1_btn_view" class="itm_btn_view btn btn-default center-block "><span class="fa fa-eye"></span> View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
      <?php
                                    if(!empty($item_res)){
                                        foreach ($item_res as $item){
//                                            echo '<pre>';print_r($item); die;
                                            echo '
                                                    <div class="item   image-grid__item">
                                                        <div class="thumbnail">
                                                            <img class="group list-group-image img-bordered-sm" style="width:400px;" src="'.base_url(ITEM_IMAGES.(($item['image']!='')?$item['id'].'/'.$item['image']:'../default/default.jpg')).'" alt="" />
                                                            <div class="caption" >
                                                                <h4 class="group inner list-group-item-heading" style="text-align:center;"> '.$item['item_code'].' |  '.$item['item_name'].'</h4>
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-md-12">
                                                                        <p class=""  style="text-align:center;">Price '.((!empty($item['price_info']))?$item['price_info']['currency_code'].' '.$item['price_info']['price_amount']:'-').'</p>
                                                                    </div>
                                                                    <div class="col-xs-12 col-md-12 ">
                                                                        <a id="'.$item['id'].'_btn_view" class="itm_btn_view btn btn-default center-block "  ><span class="fa fa-eye"></span> View</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                        }
                                    }
                                ?> 

    </div>

    <div class="scroller-status">
      <div class="loader-ellips infinite-scroll-request">
        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>
      </div>
      <p class="scroller-status__message infinite-scroll-last">End of content</p>
      <p class="scroller-status__message infinite-scroll-error">No more pages to load</p>
    </div>

      <p class="pagination">
          <a class="pagination__next" href="<?php echo base_url($this->router->fetch_class().'/image_loader/'.($cur_page1+1).'/'.$category_id1);?>">Next page</a>
      </p>

    <footer class="full-page-demo-footer"></footer>

  </div> 
</div> 

<?php $this->load->view('sales/order_ecatalog/e-catelog-modals/item_pop'); ?>

  <script src="<?php echo base_url('templates/plugins/infinite_scroll/infinite-scroll-docs.min.js?3');?>"></script>

