<?php include(ADMIN_INCLUDE_PATH . '/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/sidebar.php'); ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=$this->lang->line('restaurants')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="<?= RESTAURANTS_PATH ?>"><?=$this->lang->line('restaurant_list')?></a></li>
                                <li class="active"><?=$this->lang->line('restaurant_details')?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=$restaurant_info->name; ?> </h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                
                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            
                                            <tr>
                                                <td><?=$this->lang->line('opening_time')?>:</td>
                                                <td class="text-right"><?=date('H:i a', strtotime($restaurant_info->opening_time)); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('closing_time')?>:</td>
                                                <td class="text-right"><?=date('H:i a', strtotime($restaurant_info->closing_time)); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('availability')?></td>
                                                <td class="text-right"><?=$restaurant_info->is_available==1?"<lable class='label label-success'>Available</label>": "<lable class='label label-danger'>Unavailable</label>"; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('discount')?>:</td>
                                                <td class="text-right"><?=$restaurant_info->discount; ?><?=($restaurant_info->discount_type==1? "%" : "$"); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('average_price')?>:</td>
                                                <td class="text-right"><?=CURRENCY?><?=$restaurant_info->average_price; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=$this->lang->line('contact_and_address_inforamtion')?></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                        
                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?=$this->lang->line('phone_number')?>:</td>
                                                <td class="text-right"><?=$restaurant_info->phone;?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('email_id')?>:</td>
                                                <td class="text-right"><?=urldecode($restaurant_info->email); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('address')?>:</td>
                                                <td class="text-right"><?php echo urldecode($restaurant_info->address) .', '.urldecode($restaurant_info->city_name).', '.urldecode($restaurant_info->state_name).', '.urldecode($restaurant_info->country_name).'-'.$restaurant_info->pincode?></td>
                                            </tr>
                                           
                                            
                                           
                                        </tbody>
                                    </table>
                    
                                    
                                </div>                                    
                            </div>
                                
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    
                    
                    
                    <div class="clearfix"></div>
                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=$this->lang->line('food_information')?></h4></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                <?php foreach($categories as $cats) { ?>
                                    <div class="card-header">
                                    <h2 style="color:#0a9822"><center><?=urldecode($cats['title'])?></center></h2>
                                </div>
                                <table id="bootstrap-data-table<?=$cats['id']?>" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><?=$this->lang->line('image')?></th>
                                        <th width="200px"><?=$this->lang->line('name')?></th>
                                        <th width="400px"><?=$this->lang->line('description')?></th>
                                        <th><?=$this->lang->line('price')?></th>
                                        <th><?=$this->lang->line('discount')?></th>
                                        <th><?=$this->lang->line('type')?></th>
                                        <th><?=$this->lang->line('status')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                     $where = array('status!='=>9, "category_id"=>$cats['id'], "restaurant_id"=>$restaurant_info->id);
                                     $columns = "*";
                                     $join = array();
                                     $group_by = '';
                                     $subcategory=  $this->Sitefunction->get_all_rows(TBL_SUBCATEGORIES, $columns, $where, $join, array(), '', '', array(), $group_by, array(), array());
                                     foreach($subcategory as $rows){ ?>
                                        <tr>
                                            <td width="100px"><img src="<?=UPLOAD_URL.'subcategory/'.$rows['image']?>" width="80px" /></td>
                                            <td><?=urldecode($rows['title'])?></td>
                                            <td><?=urldecode($rows['description'])?></td>
                                            <td><?=CURRENCY?><?=$rows['price']?></td>
                                            <td><?=$rows['discount']?><?=($rows['discount_type']==1? "%" : "$"); ?></td>
                                            <td><?=($rows['type']==1? "Veg" : "Non-veg"); ?></td>
                                            <td><div><label class="switch"><input type="checkbox" class="status_change ct_switch"  data-id="<?=$rows['id']?>" value="<?=$rows['status']?>" <?=$rows['status']==1?"checked": ""?>><span class="slider round"></span></label></div></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                    

                             <?php   } ?>
                                    
                                    
                                        
                                    
                                </div>
                                    
                                
                                
                            </div>
                                
                        </div>
                    </div>

                                        
                </div><!-- /# row -->
                                
               
                    
                    
                    
                </div>
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->

<?php include(ADMIN_INCLUDE_PATH . '/footer.php'); ?>

<script type="text/javascript">
    $('[id^=bootstrap-data-table]').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
    });

    $(document).on('change', '.status_change ', function() {
	if($(this).is(":checked")) {
		var visibility= '1';
		
	}else {
		var visibility= '0';
	}
	var id= $(this).attr('data-id');
	$.ajax({
		type:"POST",
		url:"<?=RESTAURANTS_PATH?>/change_visibility",
		data:{'id': id, 'visibility':visibility},
		success: function(data) {
		}
	});
});
</script>

<?php include(ADMIN_INCLUDE_PATH . '/close.php'); ?>