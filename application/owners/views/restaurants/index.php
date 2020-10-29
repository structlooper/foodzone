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
                                <li><a href="<?=RESTAURANTS_PATH ?>"><?=$this->lang->line('restaurant_list')?></a></li>
                                <!--	<li class="active">Data Table</li>-->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
                

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card alert">

                           


                            <div class="bootstrap-data-table-panel">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                
                                    <thead>
                                        <tr>
                                            
                                            <th><?=$this->lang->line('id')?></th>
                                            <th><?=$this->lang->line('owner')?></th>
                                            <th><?=$this->lang->line('title')?></th>
                                            <th><?=$this->lang->line('email_id')?></th>
                                            <th><?=$this->lang->line('phone_number')?></th>
                                            <th><?=$this->lang->line('address')?></th>
                                            <th><?=$this->lang->line('registration_date')?></th>
                                            <th><?=$this->lang->line('availability')?></th>
                                            <th width="100px"><?=$this->lang->line('action')?></th>
                                            
                                        </tr>
                                    </thead>
                                <tbody>
                                        <?php

                                        if (!empty($results)) {

                                            $html = '';
                                            
                                            foreach ($results as $single) { ?>
                                            <tr>
                                           
                                            <td><?=$single['id']?></td>
                                            <td><?=urldecode($single['first_name']).' '.urldecode($single['last_name'])?></td>
                                            <td><?=urldecode($single['name'])?></td>
                                            <td><?=urldecode($single['email'])?></td>
                                            <td><?=$single['phone']?></td>
                                            <td><?=urldecode($single['address']).'<br>'.urldecode($single['city_name']).', '.urldecode($single['state_name']).'<br>'.urldecode($single['country_name']).'-'.$single['pincode']?> </td>
                                            <td><?=date('d-m-Y', strtotime($single['created']))?></td>
                                            <td><div><label class="switch"><input type="checkbox" class="status_change ct_switch"  data-id="<?=$single['id']?>" value="<?=$single['is_available']?>" <?=$single['is_available']==1?"checked": ""?>><span class="slider round"></span></label></div></td>
                                            <td>&nbsp;&nbsp;<a class="fa fa-eye" data-toggle="tooltip" style="color: #00c0ef;" title="View Details!" href="<?=RESTAURANTS_PATH?>/view/<?=$single['id']?>"></a>&nbsp;&nbsp;
                                            <a href="<?=RESTAURANTS_PATH?>/invoice/<?=$single['id']?>" class="fa fa-file" style="color:green" data-toggle="tooltip" title="View Invoice"></a></td>
                                            </tr>
                                            <?php
                                             
                                            }
                                           
                                        }
                                        ?>




                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /# card -->
                    </div><!-- /# column -->
                </div><!-- /# row -->
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->

<?php include(ADMIN_INCLUDE_PATH . '/footer.php'); ?>
<script type="text/javascript">
   
    $(document).on('change', '.status_change ', function() {
	if($(this).is(":checked")) {
		var visibility= '1';
		
	}else {
		var visibility= '0';
	}
	var id= $(this).attr('data-id');
	$.ajax({
		type:"POST",
		url:"<?=RESTAURANTS_PATH?>/change_availablity",
		data:{'id': id, 'visibility':visibility},
		success: function(data) {
		}
	});
});
</script>
<?php include(ADMIN_INCLUDE_PATH . '/close.php'); ?>