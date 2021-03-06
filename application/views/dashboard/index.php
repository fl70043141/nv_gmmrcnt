<div id="result1"><?php // echo '<pre>'; print_r($map_data); die;?></div>
  <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div id="top_sale_box" class="small-box bg-green">
            <div class="inner">
              <h3 id="top_sale_box_amount"><?php // echo $total_1['count'];?></h3>

              <p id="top_sale_box_label"><?php // echo $total_1['label'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-basket"></i>
            </div>
            <a href="<?php echo base_url('Sales_invoices');?>" class="small-box-footer">New Sales Invoice<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div id="top_purch_box" class="small-box bg-aqua">
            <div class="inner">
              <h3 id="top_purch_box_amount"><?php // echo $total_2['count'];?></h3>

              <p id="top_purch_box_label"><?php // echo $total_2['label'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?php echo base_url(( (NO_GEM=='1')?'Purchasing_items':'Purchasing_gemstones'));?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div id="top_quick_entry_box" class="small-box <?php echo $total_5['color'];?>">
              <div id="" class="inner">
              <h4 id="top_expense_box_amount"><?php echo $total_5['count'];?></h4>

              <p style="font-size:20px;" id="top_expense_box_alabel"><?php echo $total_5['label'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="<?php echo base_url('reports/ledgers/Pnl_items');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div id="" class="small-box bg-yellow">
            <div class="inner">
              <h4 id="top_stock_box_amount"><?php echo ($total_3['count']);?></h4>

              <p style="font-size:20px;" id="top_stock_box_label"><?php echo $total_3['label'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-list"></i>
            </div>
              <a href="<?php echo base_url('reports/Stock_costing');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-2 margin-bottom"><a href="<?php echo base_url("Items");?>" class="btn btn-block btn-social btn-default">  <i class="fa fa-diamond"></i> Master Inventory</a></div>
        <div class="col-md-2 margin-bottom"><a href="<?php echo base_url("reports/Sales_summary");?>" class="btn btn-block btn-social btn-default">  <i class="fa fa-user"></i> Customer Balance</a></div>
        <div class="col-md-2 margin-bottom"><a href="<?php echo base_url("reports/".((NO_GEM==1)?'Item_costing':'Gemstone_costing'));?>" class="btn btn-block btn-social btn-default">  <i class="fa fa-money"></i> Item Costing Report</a></div>
        <div class="col-md-2 margin-bottom"><a href="<?php echo base_url("reports/Ledger_reports/expenses");?>" class="btn btn-block btn-social btn-default">  <i class="fa fa-dollar"></i> Expenses Report</a></div>
        <div class="col-md-2 margin-bottom"><a href="<?php echo base_url("reports/ledgers/Pnl_General");?>" class="btn btn-block btn-social btn-default">  <i class="fa fa-bar-chart"></i> P&L Report</a></div>
        <div class="col-md-2 margin-bottom"><a href="<?php echo base_url("Order_ecatalog");?>" class="btn btn-block btn-social btn-default">  <i class="fa fa-image"></i> E-Catalog</a></div>

      </div>
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->

          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Bar Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.nav-tabs-custom -->


        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Activity Summary</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
            </div>
            <!-- /.box-body -->
          </div>
        </section>
        <section class="col-lg-6 connectedSortable">

          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Sales</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="area-chart" style="height: 338px;" class="full-width-chart"></div>
            </div>
            <!-- /.box-body-->
          </div>
        </section>
        <section class="col-lg-6 connectedSortable">

          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Location Stock Summary</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="row">
                <div class="col-md-8 col-sm-8">
                  <div class="pad">
                    <!-- Map will be created here -->
                    <div id="world-map-markers" style="height: 300px;"></div>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-md-4 col-sm-4">

                  <div class="pad box-pane-right bg-green" style="min-height: 300px">
                    <br
                ><?php
                    $i=1;
                     foreach ($map_data as $map){
                         echo '
                                <div class="description-block margin-bottom">
                                  <h4>'.$map['tot_available'].'</h4>
                                  <span class="description-text">'.$map['location_code'].'</span>
                                  '.(($i==3)?'':'<hr>').'
                                </div>';
                         if($i==3){
                             break;
                         }
                         $i++;
                     }
                    ?>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
        </section>
          <!-- /.box -->
          </div>
          <!-- /.box -->


        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

<script src="<?php echo base_url('templates/plugins/flot/jquery.flot.min.js');?>"></script>
<!-- ./wrapper -->
<script>

$(function () {


  // Donut Chart
  var donut = new Morris.Donut({
    element  : 'sales-chart',
    resize   : true,
    colors   : ['#3c8dbc', '#f56954', '#00a65a'],
    data     : [
      { label: 'SALES', value: <?php echo $donut['sales']?>},
      { label: 'PURCHASE', value: <?php echo $donut['purch']?> },
      { label: 'EXPENSES', value: <?php echo $donut['expenses']?> }
    ],
    hideHover: 'auto'
  });

    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: [
        <?php

            foreach ($barchart as $bc_info){
                echo "{y: '".$bc_info['month']."', a: ".$bc_info['res'].", b: ".$bc_info['inv']."},";
            }
        ?>
      ],
      barColors: ['#3c8dbc', '#f56954'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Purchase Invoices', 'Sales Invoices'],
      hideHover: 'auto'
    });



    /*
     * FULL WIDTH STATIC AREA CHART
     * -----------------
     */
    var areaData = [
                        <?php
                            if(!empty($sales_chart)){
                                foreach ($sales_chart as $key=>$chartdata){
                                    echo ' ['.$key.', '.$chartdata['total'].'],';
                                }
                            }
                        ?>
                    ];
    $.plot("#area-chart", [areaData], {
      grid: {
        borderWidth: 0
      },
      series: {
        shadowSize: 0, // Drawing is faster without shadows
        color: "#00c0ef"
      },
      lines: {
        fill: false //Converts the line chart to area chart
      },
      yaxis: {
        show: false
      },
      xaxis: {
        show: false
      }
    });

    /* END AREA CHART */


    get_sales_info();
    get_purch_info();
//    get_quick_entry_info();

/* jVector Maps
   * ------------
   * Create a world map with markers
   */
  $('#world-map-markers').vectorMap({
    map: 'world_mill_en',
    normalizeFunction: 'polynomial',
    hoverOpacity: 0.7,
    hoverColor: false,
    backgroundColor: 'transparent',
    regionStyle: {
      initial: {
        fill: 'rgba(210, 214, 222, 1)',
        "fill-opacity": 1,
        stroke: 'none',
        "stroke-width": 0,
        "stroke-opacity": 1
      },
      hover: {
        "fill-opacity": 0.7,
        cursor: 'pointer'
      },
      selected: {
        fill: 'yellow'
      },
      selectedHover: {}
    },
    markerStyle: {
      initial: {
        fill: '#00a65a',
        stroke: '#111'
      }
    },
    markers: [
        <?php
            foreach ($map_data as $map){
                echo "{latLng: [".$map['long'].",  ".$map['latt']."], name: '".$map['location_name']." (".$map['tot_available'].")'},";
            }
        ?>
    ]
  });

});


    function get_sales_info(){
        $('#top_sale_box').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...');

        $.ajax({
                    url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>",
                    type: 'post',
                    data : {function_name:'get_sales_info'},
                    success: function(result){
//                             $("#result1").html(result);
                        var res2 = JSON.parse(result);
                        var sale_amount = addCommas(Math.abs(parseFloat(res2['total']).toFixed(0)));

                        var html_sale = '<div class="inner">'+
                                        '<h4>'+((typeof(res2['symbol_left'])=='undefined')?'':res2['symbol_left'])+' '+sale_amount+' '+((typeof(res2['symbol_right'])=='undefined')?'':res2['symbol_right'])+'</h4>'+
                                        '<p style="font-size:20px;">SALES</p>'+
                                    '</div>'+
                                    '<div class="icon">'+
                                '<i class="fa fa-shopping-basket"></i>'+
                             '</div>'+
                             '<a href="<?php echo base_url('Sales_invoices');?>" class="small-box-footer">More info<i class="fa fa-arrow-circle-right"></i></a>';

                        $('#top_sale_box').html(html_sale);
                    }
            });
    }

    function get_purch_info(){
        $('#top_purch_box').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...');

        $.ajax({
                    url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>",
                    type: 'post',
                    data : {function_name:'get_purch_info'},
                    success: function(result){
//                             $("#result1").html(result); return false;
                        var res2 = JSON.parse(result);
                        var purch_amount = addCommas(Math.abs(parseFloat(res2['total']).toFixed(0)));

                        var html_purch = '<div class="inner">'+
                                        '<h4>'+((typeof(res2['symbol_left'])=='undefined')?'':res2['symbol_left'])+' '+purch_amount+' '+((typeof(res2['symbol_right'])=='undefined')?'':res2['symbol_right'])+'</h4>'+
                                        '<p style="font-size:20px;">PURCHASING</p>'+
                                    '</div>'+
                                    '<div class="icon">'+
                                '<i class="fa fa-suitcase"></i>'+
                             '</div>'+
                             '<a href="<?php echo base_url(( (NO_GEM=='1')?'Purchasing_items':'Purchasing_gemstones'));?>" class="small-box-footer">More info<i class="fa fa-arrow-circle-right"></i></a>';

                        $('#top_purch_box').html(html_purch);
                    }
            });
    }

    function get_quick_entry_info(){
        $('#top_quick_entry_box').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...');

        $.ajax({
                    url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>",
                    type: 'post',
                    data : {function_name:'get_expenses_info'},
                    success: function(result){
//                        alert()
//                             $("#result1").html(result); return false;
                        var res2 = JSON.parse(result);
                        var exp_amount = addCommas(Math.abs(parseFloat(res2['total']).toFixed(0)));
                        var html_exp = '<div class="inner">'+
                                        '<h4>'+((typeof(res2['symbol_left'])=='undefined')?'':res2['symbol_left'])+' '+exp_amount+' '+((typeof(res2['symbol_right'])=='undefined')?'':res2['symbol_right'])+'</h4>'+
                                        '<p style="font-size:20px;">EXPENSES</p>'+
                                    '</div>'+
                                    '<div class="icon">'+
                                '<i class="fa fa-money"></i>'+
                             '</div>'+
                             '<a href="<?php echo base_url('reports/Ledger_reports/expenses');?>" class="small-box-footer">More info<i class="fa fa-arrow-circle-right"></i></a>';

                        $('#top_quick_entry_box').html(html_exp);
                    }
            });
    }
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
</script>
