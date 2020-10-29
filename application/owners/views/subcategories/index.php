<?php include(ADMIN_INCLUDE_PATH . '/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/sidebar.php'); ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=$this->lang->line('subcategories')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="<?= SUBCATEGORY_PATH ?>"><?=$this->lang->line('subcategory_list')?></a></li>
                                <!--	<li class="active">Data Table</li>-->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
            <?php if (isset($success_message) && $success_message != '') {  ?>

                <div class="alert alert-info alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><?=$this->lang->line('success')?>!</strong> <?php echo isset($success_message) ? $success_message : $this->session->flashdata('invalid'); ?>
                </div>

                <?php  } ?>

                <?php if (isset($error_message) && $error_message != '') {  ?>

                <div class="alert alert-info alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><?=$this->lang->line('error')?>!</strong> <?php echo isset($error_message) ? $error_message : $this->session->flashdata('invalid'); ?>
                </div>

                <?php } ?>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card alert">

                            

                            <div class="bootstrap-data-table-panel">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                
                                    <thead>
                                        <tr>
                                           
                                            <th><?=$this->lang->line('image')?></th>
                                            <th><?=$this->lang->line('category')?></th>
                                            <th><?=$this->lang->line('restaurant')?></th>
                                            <th><?=$this->lang->line('subcategory')?></th>
                                            <th><?=$this->lang->line('type')?></th>
                                            <th><?=$this->lang->line('discount')?></th>
                                            <th width="200px"><?=$this->lang->line('description')?></th>
                                            <th><?=$this->lang->line('status')?></th>
                                            
                                        </tr>
                                    </thead>
                                <tbody>
                                        <?php

                                        if (!empty($results)) {

                                            $html = '';
                                            
                                            foreach ($results as $single) { ?>
                                            <tr>
                                            
                                            <td><img src="<?=UPLOAD_URL.'subcategory/'.$single['image']?>" width="80px" /></td>
                                            <td><?=urldecode($single['cat_title'])?></td>
                                            <td><?=urldecode($single['restaurant_name'])?></td>
                                            <td><?=urldecode($single['title'])?></td>
                                            <td><?=$single['type']==1?$this->lang->line('veg'):$this->lang->line('non_veg')?></td>
                                            <td><?=$single['discount']?><?=$single['discount_type']==0?"$":"%"?></td>
                                            <td><?=urldecode($single['description'])?></td>
                                            <td><div><label class="switch"><input type="checkbox" class="status_change ct_switch"  data-id="<?=$single['id']?>" value="<?=$single['status']?>" <?=$single['status']==1?"checked": ""?>><span class="slider round"></span></label></div></td>
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
		url:"<?=SUBCATEGORY_PATH?>/change_visibility",
		data:{'id': id, 'visibility':visibility},
		success: function(data) {
		}
	});
});
</script>
<?php include(ADMIN_INCLUDE_PATH . '/close.php'); ?>