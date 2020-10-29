<?php include(ADMIN_INCLUDE_PATH . '/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/sidebar.php'); ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=$this->lang->line('invoice_details')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="<?= RESTAURANTS_PATH ?>"><?=$this->lang->line('restaurant_list')?></a></li>
                                <li class="active"><?=$this->lang->line('invoice_details')?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
            <?php if (isset($error_message) && $error_message != '') { ?>

                <div class="alert alert-danger alert-settings">
                    <ul class="error-message">
                        <li> <?= isset($error_message) ? $error_message : $this->session->flashdata('invalid'); ?> </li>
                    </ul>
                </div>

            <?php } ?>
            <?php if (isset($success_message) && $success_message != '') {  ?>

                <div class="alert alert-info alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><?=$this->lang->line('success')?>!</strong> <?php echo isset($success_message) ? $success_message : $this->session->flashdata('invalid'); ?>
                </div>

            <?php  } ?>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card alert">

                            

                            <div class="bootstrap-data-table-panel">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                
                                    <thead>
                                        <tr>
                                            <th><input type='checkbox' name='select_all' id='select_all' value=''/></th>

                                            <th><?=$this->lang->line('order_id')?></th>
                                            <th><?=$this->lang->line('admin_charge')?></th>
                                            <th><?=$this->lang->line('owners_amount')?></th>
                                            <th><?=$this->lang->line('total_amount')?></th>
                                            <th><?=$this->lang->line('payment_status')?></th>
                                            <th><?=$this->lang->line('payment_date')?></th>
                                            
                                            
                                        </tr>
                                    </thead>
                                <tbody>
                                        <?php

                                        if (!empty($invoice_info)) {

                                            $payable_Amount = 0;
                                            
                                            foreach ($invoice_info as $single) {
                                                $payable_Amount = $single['payment_status'] == 0 ? ($payable_Amount +   $single['owners_amount']) : $payable_Amount;  
                                            ?>
                                            <tr>
                                            <td><input type='checkbox' name='checked_id' id='checkbox1' class='checkbox' value='<?=$single['id']?>'/></td>
                                            <td>#<?=$single['id']?></td>
                                            <td>$<?=$single['admin_charge_amount']?></td>
                                            <td>$<?=$single['owners_amount']?></td>
                                            <td>$<?=$single['grand_total']?></td>
                                            <td><?php if($single['payment_status']==0) { echo "<label class='label label-warning' >Pending</label>"; } else if($single['payment_status']==1) { echo "<label class='label label-success'>Paid</label>"; }else { echo "-"; }?></td>
                                            <td><?=$single['payment_date']?date('d-m-Y',strtotime($single['payment_date'])): ""?></td>
                                            </tr>
                                            <?php
                                             
                                            }
                                           
                                        }
                                        ?>




                                    </tbody>
                                </table>
                                <hr>
                                <table width="50%" >
                                    <tr >
                                        <th><b style="color: #000000"> <?=$this->lang->line('total_payable_amount')?> : $<?=$payable_Amount?></b></th>
                                        <td><?php if($payable_Amount==0) { ?>
                                            <button class="btn btn-danger"><?=$this->lang->line('paid')?></button>
                                     <?php   }else { ?>
                                        <a href="<?=RESTAURANTS_PATH?>/pay/<?=$restaurant_id?>/<?=$payable_Amount?>" class="btn btn-success">Pay <?=CURRENCY?><?=$payable_Amount?></a>
                                    <?php    } ?></td>
                                    </tr>
                                    
                                </table>
                                
                                <hr />
                            </div>
                        
                            
                        </div>
                    </div>
                </div><!-- /# row -->
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->

<?php include(ADMIN_INCLUDE_PATH . '/footer.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/close.php'); ?>