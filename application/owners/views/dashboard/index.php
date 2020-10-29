<?php include(ADMIN_INCLUDE_PATH.'/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH.'/sidebar.php'); ?>


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
                                    <li><a href="javascript:void(0)"><?=$this->lang->line('dashboard')?></a></li>
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div><!-- /# row -->
                <div class="main-content">
			
                    <div class="row custom-stat-widget">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-one">
									<div class="stat-icon dib"><i class="fa fa-check color-primary"></i>
									<div class="stat-digit"><?php echo count($totalorderreceived);?></div>
									</div>
									<a href="<?=ORDER_PATH?>">
									<div class="stat-content dib">
										<div class="stat-text"><?=$this->lang->line('order_received')?></div>
										
									</div>
									</a>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-one">
									<div class="stat-icon dib"><i class="fa fa-calendar-o color-info"></i>
									<div class="stat-digit"><?php echo count($totaltodayorderview);?></div>
									</div>
									<a href="<?=ORDER_PATH?>">
									<div class="stat-content dib">
										<div class="stat-text"><?=$this->lang->line('todays_orders')?></div>
										
									</div>
									</a>
                                </div>
                            </div>
                        </div>                       
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-one">
									<div class="stat-icon dib"><i class="fa fa-handshake-o color-success"></i>
									<div class="stat-digit"><?php echo count($orderdeliveredlist);?></div>
									</div>
									<a href="<?=ORDER_PATH?>">
									<div class="stat-content dib">
										<div class="stat-text"><?=$this->lang->line('order_delivered')?></div>
										
									</div>
									</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="stat-widget-one">
									<div class="stat-icon dib"><i class="fa fa-usd color-danger"></i>
										<div class="stat-digit"><?=$totalEarnings[0]['earnings']?></div>
									</div>
									<a href="<?=ORDER_PATH?>">
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
					<div class="row">
					
						<div class="col-lg-12">
                            <div class="card alert">
                                <div class="card-header">
                                    <h3 class="color-dark"><?=$this->lang->line('online_order_list')?></h3>
									
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
                                               
                                            if(!empty($latest_order_list)){

                                            $html='';
                                            
                                             foreach($latest_order_list as $single)

                                            {
                                                $html .='<td><a href="'.ORDER_PATH.'/view/'.$single['id'].'" style="color:#0a9822">#'.$single['id'].'</a></td>';
                                                $html .='<td>'.urldecode($single['fullname']).'</td>';
                                                $html .='<td>'.urldecode($single['name']).'</td>';
                                            
                                                $html .='<td>'.'$'.str_replace('$','',$single['total_price']).'</td>';
                                        
                                            
                                                $html .='<td>'.$controller->getOrderStatus($single['order_status']).'</td>';
                                            
                                                    $html .="</tr>";

                                             

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
    <?php include(ADMIN_INCLUDE_PATH.'/footer.php'); ?>
    <?php

for($m=1; $m<=12; $m++){
    $m= $m<=9?('0'.$m):$m;
    $date=  $m."-".date('Y');
    $montly_profit= $this->Sitefunction->get_all_rows(TBL_EARNINGS. ' as e ', "SUM(e.owners_amount) AS earnings", array('e.status'=>1, "r.owner_id"=>$this->user_id, "DATE_FORMAT(e.created, '%m-%Y')="=>"$date"), array(TBL_RESTAURANTS.' as r'=>"e.restaurent_id=r.id"));
    $profit=!empty($montly_profit) ? $montly_profit[0]['earnings'] : 0;
    
    $profit_record[]= $profit;
    
}

?>

<script src="<?=ASSETSPATH?>/js/Chart.min.js"></script>
<script type="text/javascript">
    new Chart(document.getElementById("BarProfit"), {
    type: 'line',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct', 'Nov', 'Dec'],
      datasets: [
        {
          label: "<?=$this->lang->line('total_profit')?>",
          borderColor: "#455A64",
          backgroundColor: "#CFD8DC",
          fill: true,
          borderWidth: 1,
          borderWidth: 2,
          data: ['<?=$profit_record[0]?>','<?=$profit_record[1]?>','<?=$profit_record[2]?>','<?=$profit_record[3]?>','<?=$profit_record[4]?>','<?=$profit_record[5]?>','<?=$profit_record[6]?>','<?=$profit_record[7]?>','<?=$profit_record[8]?>','<?=$profit_record[9]?>', '<?=$profit_record[10]?>', '<?=$profit_record[11]?>']
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
    <?php include(ADMIN_INCLUDE_PATH.'/close.php'); ?>










