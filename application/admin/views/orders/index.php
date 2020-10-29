<?php include(ADMIN_INCLUDE_PATH . '/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/sidebar.php'); ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=$this->lang->line('orders')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a class="active" href="javascript:void(0)"><?=$this->lang->line('order_list')?></a></li>
                                
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
                                            <th>#</th>

                                            <th><?=$this->lang->line('order_id')?></th>
                                            <th><?=$this->lang->line('customer_name')?></th>
                                            <th><?=$this->lang->line('order_status')?></th>
                                            <th><?=$this->lang->line('grand_total')?></th>
                                            <th><?=$this->lang->line('tip')?></th>
                                            <th><?=$this->lang->line('order_date')?></th>
                                            <th><?=$this->lang->line('assign_driver')?></th>
                                            <th><?=$this->lang->line('driver_status')?></th>
                                            <th><?=$this->lang->line('action')?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($results)) {

                                            $html = '';

                                            foreach ($results as $single) { ?>
                                                <tr>
                                                    <td><input type='checkbox' name='checked_id' id='checkbox1' class='checkbox' value='<?= $single['id'] ?>' <?=$single['order_status']==1?"":"disabled"?> /></td>
                                                    <td><?=$single['id'] ?></td>
                                                    <td><?= urldecode($single['user_name']) ?></td>
                                                    
                                                    <td><?= $controller->getOrderStatus($single['order_status']) ?></td>
                                                    <td>$<?= $single['total_price'] ?></td>
                                                    <td><?= $single['tip_price'] ?></td>
                                                    <td><?= date('d-m-Y h:i a', strtotime($single['created'])) ?></td>
                                                    <?php
                                                    $driver_name= "-";
                                                    $driver_status= "-";
                                                    if($single['order_status']==1) { ?>
                                                        <td><label class="label label-warning"><?=$this->lang->line('waiting_for_restaurant_approval')?></label></td>
                                                    <?php } else if($single['order_status']==3) {   ?>
                                                        <td><label class="label label-danger"><?=$this->lang->line('declined_by_restaurant')?></label></td>
                                                    <?php }else if($single['order_status']==5) {  $getAssignedDriver= $this->Sitefunction->get_single_by_query("SELECT d.id, d.fullname, od.driver_status FROM ".TBL_ORDER_DRIVERS." as od INNER JOIN ".TBL_USERS." as d ON d.id=od.driver_id WHERE od.status=1 AND order_id=".$single['id']." ORDER BY od.id DESC");
                                                    if(!empty($getAssignedDriver)) {
                                                        $driver_status= $controller->getDriverOrderStatus($getAssignedDriver->driver_status);
                                                        ?>
                                                        <td><label class="label label-success"><?=urldecode($getAssignedDriver->fullname) ?></label></td>
                                                        <?php  }else { ?>
                                                        <td>-</td>
                                                    <?php  }
                                                        } else {
                                                        $getAssignedDriver= $this->Sitefunction->get_single_by_query("SELECT d.id, d.fullname, od.driver_status FROM ".TBL_ORDER_DRIVERS." as od INNER JOIN ".TBL_USERS." as d ON d.id=od.driver_id WHERE od.status=1 AND order_id=".$single['id']." ORDER BY od.id DESC");
                                                        if(!empty($getAssignedDriver)) {
                                                            $driver_status= $controller->getDriverOrderStatus($getAssignedDriver->driver_status);
                                                        if($getAssignedDriver->driver_status!=2) { ?>
                                                            <td><?=urldecode($getAssignedDriver->fullname) ?></td>
                                                        <?php  }else {
                                                            $get_nearby_drivers= $this->Sitefunction->get_all_rows_by_query("SELECT d.id, d.fullname, d.status,d.is_available, d.user_type, ( 3959 * acos( cos( radians(".$single['latitude'].") ) * cos( radians( latitude ) ) 
                                                            * cos( radians( longitude ) - radians(".$single['longitude'].") ) + sin( radians(".$single['latitude'].") ) * sin(radians(latitude)) ) ) AS distance FROM ".TBL_USERS." as d  GROUP BY d.id HAVING d.status=1 and d.is_available=1 and d.user_type=2 ORDER BY distance ASC"); ?>
                                                            <td>
                                                                <select data-id="<?= $single['id'] ?>" name="driver_id" class="change_state">
                                                                    <option value=""><?=$this->lang->line('select_driver')?></option>
                                                                    <?php foreach($get_nearby_drivers as $drivers) { ?>
                                                                    <option value="<?=$drivers['id'] ?>"><?=urldecode($drivers['fullname'])?></option>
                                                                <?php  } ?>
                                                                </select>
                                                            </td>

                                                    <?php } 
                                                        
                                                    }else {

                                                        $get_nearby_drivers= $this->Sitefunction->get_all_rows_by_query("SELECT d.id, d.fullname, d.status, d.is_available,d.user_type, ( 3959 * acos( cos( radians(".$single['latitude'].") ) * cos( radians( latitude ) ) 
    * cos( radians( longitude ) - radians(".$single['longitude'].") ) + sin( radians(".$single['latitude'].") ) * sin(radians(latitude)) ) ) AS distance FROM ".TBL_USERS." as d  GROUP BY d.id HAVING d.status=1 and d.is_available=1 and d.user_type=2 ORDER BY distance ASC");  ?>
                                                        <td>
                                                            <select data-id="<?= $single['id'] ?>" name="driver_id" class="change_state">
                                                                <option value=""><?=$this->lang->line('select_driver')?></option>
                                                                <?php foreach($get_nearby_drivers as $drivers) { ?>
                                                                <option value="<?=$drivers['id'] ?>"><?=urldecode($drivers['fullname']) ?></option>
                                                            <?php  } ?>
                                                            </select>
                                                        </td>
                                                    <?php }
                                                    } ?>
                                                    <td><?= $driver_status ?></td>
                                                    
                                                    <td>&nbsp;&nbsp;<a class="ti-eye" data-toggle="tooltip" style="color: #00c0ef;" title="<?=$this->lang->line('view')?>!" href="<?= ORDER_PATH ?>/view/<?= $single['id'] ?>"></a>&nbsp;&nbsp;<a href="javascript:void(0)" class="ti-trash" style="color:red" data-toggle="tooltip" title="<?=$this->lang->line('delete')?>!" onclick="delete_status('<?= ORDER_PATH ?>/delete', '<?= $single['id'] ?>')"></a>&nbsp;&nbsp;</td>
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
    $(document).on('change', '.change_state', function() {
        var order_id= $(this).attr('data-id');
        var driver_id= $(this).val();
        $.ajax({
                type:"POST",
                url:"<?=ORDER_PATH?>/assign_driver",
                data:{'order_id':order_id, 'driver_id': driver_id},
                success: function(data) {
                    window.location.reload();
                }
            }); 
        
    });
</script>
<?php include(ADMIN_INCLUDE_PATH . '/close.php'); ?>