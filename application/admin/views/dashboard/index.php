<?php include(ADMIN_INCLUDE_PATH . '/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/sidebar.php'); ?>


<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=$this->lang->line('dashboard')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li class="active"><?=$this->lang->line('dashboard')?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div><!-- /# row -->
            <div class="main-content">

                <div class="row custom-stat-widget">
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="stat-widget-one">
                                <div class="stat-icon dib"><i class="fa fa-check color-primary"></i>
                                    <div class="stat-digit"><?php echo count($totalorderreceived); ?></div>
                                </div>
                                <a href="<?= ORDER_PATH ?>">
                                    <div class="stat-content dib">
                                        <div class="stat-text"><?=$this->lang->line('order_received')?></div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="card">
                            <div class="stat-widget-one">
                                <div class="stat-icon dib"><i class="fa fa-handshake-o color-success"></i>
                                    <div class="stat-digit"><?php echo count($orderdeliveredlist); ?></div>
                                </div>
                                <a href="<?= ORDER_PATH ?>">
                                    <div class="stat-content dib">
                                        <div class="stat-text"><?=$this->lang->line('order_delivered')?></div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="stat-widget-one">
                                <div class="stat-icon dib"><i class="fa fa-user-o color-pink"></i>
                                    <div class="stat-digit"><?php echo count($customerslist) ?></div>
                                </div>
                                <a href="<?= CUSTOMER_PATH ?>">
                                    <div class="stat-content dib">
                                        <div class="stat-text"><?=$this->lang->line('total_customers')?></div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="stat-widget-one">
                                <div class="stat-icon dib"><i class="fa fa-group color-success"></i>
                                    <div class="stat-digit"><?= count($totalowners) ?></div>
                                </div>
                                <a href="<?= OWNER_PATH ?>">
                                    <div class="stat-content dib">
                                        <div class="stat-text"><?=$this->lang->line('total_owners')?></div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="stat-widget-one">
                                <div class="stat-icon dib"><i class="fa fa-cutlery color-danger"></i>
                                    <div class="stat-digit"><?= count($totalResaturants) ?></div>
                                </div>
                                <a href="<?= RESTAURANTS_PATH ?>">
                                    <div class="stat-content dib">
                                        <div class="stat-text"><?=$this->lang->line('total_restaurants')?></div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card">
                            <div class="stat-widget-one">
                                <div class="stat-icon dib"><i class="fa fa-usd color-info"></i>
                                    <div class="stat-digit"><?php echo $totalearnings[0]['earnings']; ?></div>
                                </div>
                                <a href="<?= ORDER_PATH ?>">
                                    <div class="stat-content dib">
                                        <div class="stat-text"><?=$this->lang->line('total_earnings')?></div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row clearfix">
                    
                    <div class="col-lg-12">
                        <div class="widget-container stats-container">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="BarProfit" width="442" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    
                    <div class="col-lg-12">
                        <div class="widget-container stats-container">
                            <div class="card-header">
                                

                            </div>
                            <div class="card">
                                <div class="card-body">
                                <h3 class="color-dark"><?=$this->lang->line('drivers')?> </h3>
                                <div class="driver_map" id="driver_map" style="height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h3 class="color-dark"><?=$this->lang->line('online_order_list')?> </h3>

                            </div>
                            <div class="card-body">
                                <table class="table table-responsive table-hover ">
                                    <thead>
                                        <tr>
                                            <th><?=$this->lang->line('order_id')?></th>
                                            <th><?=$this->lang->line('customer_name')?></th>
                                            <th><?=$this->lang->line('restaurant_name')?></th>
                                            <th><?=$this->lang->line('price')?></th>
                                            <th><?=$this->lang->line('order_status')?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($latest_order_list)) {

                                            $html = '';

                                            foreach ($latest_order_list as $single) {
                                                $html .= '<td><a href="' . ORDER_PATH . '/view/' . $single['id'] . '" style="color:#0a9822">#' . $single['id'] . '</a></td>';
                                                $html .= '<td>' . urldecode($single['fullname']) . '</td>';
                                                $html .= '<td>' . urldecode($single['name']) . '</td>';

                                                $html .= '<td>' . '$' . str_replace('$', '', $single['total_price']) . '</td>';


                                                $html .= '<td>' . $controller->getOrderStatus($single['order_status']) . '</td>';

                                                $html .= "</tr>";
                                            }
                                            echo $html;
                                        }
                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /# column -->
                </div><!-- /# row -->


            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->
<?php include(ADMIN_INCLUDE_PATH . '/footer.php'); ?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=<?=$this->settings->map_api_key?>"></script>
<?php

for($m=1; $m<=12; $m++){
    $m= $m<=9?('0'.$m):$m;
    $date=  $m."-".date('Y');
    $montly_profit= $this->Sitefunction->get_all_rows(TBL_EARNINGS, "SUM(total_amount) AS earnings", array('status'=>1,  "DATE_FORMAT(created, '%m-%Y')="=>"$date"));
    $profit=!empty($montly_profit) ? $montly_profit[0]['earnings'] : 0;
    $profit_record[]= $profit;

    $montlyAdmin_profit= $this->Sitefunction->get_all_rows(TBL_EARNINGS, "SUM(admin_charge_amount) AS earnings", array('status'=>1,  "DATE_FORMAT(created, '%m-%Y')="=>"$date"));
    $profitAdmin=!empty($montlyAdmin_profit) ? $montlyAdmin_profit[0]['earnings'] : 0;
    $profitAdmin_record[]= $profitAdmin;


    $montlyOwner_profit= $this->Sitefunction->get_all_rows(TBL_EARNINGS, "SUM(owners_amount) AS earnings", array('status'=>1,  "DATE_FORMAT(created, '%m-%Y')="=>"$date"));
    $profitOwner=!empty($montlyOwner_profit) ? $montlyOwner_profit[0]['earnings'] : 0;
    $profitOwner_record[]= $profitOwner;
    
}
//print_r($available_drivers);
//die;
?>

<script src="<?=ASSETSPATH?>/js/Chart.min.js"></script>
<script type="text/javascript">
    var LocationData = [ <?php foreach($available_drivers as $mapData) { ?>
        [ '<?=$mapData['latitude']?>', '<?=$mapData['longitude']?>',  '<?=urldecode($mapData['address'])?>', '<?=$mapData['is_available']?>', '<?=urldecode($mapData['fullname'])?>'],

    <?php } ?>];
	
	function initialize()
	{
		var map = new google.maps.Map(document.getElementById('driver_map'), {
		  zoom: 13 		});
		var bounds = new google.maps.LatLngBounds();
		
		
		var infowindow = new google.maps.InfoWindow();
		for (var i in LocationData)
		{

			var p = LocationData[i];
			var image = (p[3]==0)?'<?=ASSETSPATH?>/images/pin_red.png': '<?=ASSETSPATH?>/images/pin_green.png';
            
			var latlng = new google.maps.LatLng(p[0], p[1]);
			bounds.extend(latlng);

			var marker = new google.maps.Marker({
				position: latlng,
				map: map,
				icon: image
			});
			
			
			google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
					return function() {
                        var availability = LocationData[i][3]==0?'<font size="2" color="red"><?=$this->lang->line('unavailable')?></font>': '<font size="2" color="green"><?=$this->lang->line('available')?></font>';
						var xyz= '<div><h4>'+LocationData[i][4]+'('+availability+')</h4><p>'+LocationData[i][2]+'</p></div>';
						infowindow.setContent(xyz);
						infowindow.open(map, marker);
					}
				})(marker, i));

          

		}

			map.fitBounds(bounds);
	}
	initialize();
    new Chart(document.getElementById("BarProfit"), {
    type: 'line',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct', 'Nov', 'Dec'],
      datasets: [
        {
          label: "<?=$this->lang->line('admins_profit')?>",
          borderColor: "#0a9822",
          fill: false,
          borderWidth: 2,
          data: ['<?=$profitAdmin_record[0]?>','<?=$profitAdmin_record[1]?>','<?=$profitAdmin_record[2]?>','<?=$profitAdmin_record[3]?>','<?=$profitAdmin_record[4]?>','<?=$profitAdmin_record[5]?>','<?=$profitAdmin_record[6]?>','<?=$profitAdmin_record[7]?>','<?=$profitAdmin_record[8]?>','<?=$profitAdmin_record[9]?>', '<?=$profitAdmin_record[10]?>', '<?=$profitAdmin_record[11]?>']
        },
        {
          label: "<?=$this->lang->line('total_profit')?>",
          borderColor: "#455A64",
          fill: false,
          borderWidth: 2,
          data: ['<?=$profit_record[0]?>','<?=$profit_record[1]?>','<?=$profit_record[2]?>','<?=$profit_record[3]?>','<?=$profit_record[4]?>','<?=$profit_record[5]?>','<?=$profit_record[6]?>','<?=$profit_record[7]?>','<?=$profit_record[8]?>','<?=$profit_record[9]?>', '<?=$profit_record[10]?>', '<?=$profit_record[11]?>']
        },
        {
          label: "<?=$this->lang->line('owners_profit')?>",
          borderColor: "#e74c3c",
          fill: false,
          borderWidth: 2,
          data: ['<?=$profitOwner_record[0]?>','<?=$profitOwner_record[1]?>','<?=$profitOwner_record[2]?>','<?=$profitOwner_record[3]?>','<?=$profitOwner_record[4]?>','<?=$profitOwner_record[5]?>','<?=$profitOwner_record[6]?>','<?=$profitOwner_record[7]?>','<?=$profitOwner_record[8]?>','<?=$profitOwner_record[9]?>', '<?=$profitOwner_record[10]?>', '<?=$profitOwner_record[11]?>']
        },
       
      ]
    },
    options: {
      title: {
        display: true,
        text: "<?=$this->lang->line('total_monthly_profit')?> <?=date('Y')?>"
      }
    }
});
</script>
<?php include(ADMIN_INCLUDE_PATH . '/close.php'); ?>