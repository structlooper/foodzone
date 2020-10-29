<?php include(ADMIN_INCLUDE_PATH . '/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/sidebar.php'); ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=$this->lang->line('customers')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="<?=CUSTOMER_PATH ?>"><?=$this->lang->line('customer_list')?></a></li>
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

                            <div class="pull-right">
                                
                                <input class="btn btn-danger btn-flat m-b-10 m-l-5" type="submit" onclick="multiple_delete('<?=CUSTOMER_PATH?>/multiple_delete')" id="postme" value="<?=$this->lang->line('delete')?>" disabled="disabled">


                            </div>


                            <div class="bootstrap-data-table-panel">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                
                                    <thead>
                                        <tr>
                                            <th><input type='checkbox' name='select_all' id='select_all' value=''/></th>

                                            <th><?=$this->lang->line('id')?></th>
                                            <th><?=$this->lang->line('full_name')?></th>
                                            <th><?=$this->lang->line('email_id')?></th>
                                            <th><?=$this->lang->line('phone_number')?></th>
                                            <th><?=$this->lang->line('registration_date')?></th>
                                            <th><?=$this->lang->line('registration_type')?></th>
                                            <th><?=$this->lang->line('action')?></th>
                                            
                                        </tr>
                                    </thead>
                                <tbody>
                                        <?php

                                        if (!empty($results)) {

                                            $html = '';
                                            
                                            foreach ($results as $single) { ?>
                                            <tr>
                                            <td><input type='checkbox' name='checked_id' class='checkbox' value='<?=$single['id']?>'/></td>
                                            <td><?=$single['id']?></td>
                                            <td><?=urldecode($single['fullname'])?></td>
                                            <td><?=urldecode($single['email'])?></td>
                                            <td><?=$single['phone']?></td>
                                            <td><?=date('d-m-Y',strtotime($single['created']))?></td>
                                            <td><?=$single['is_social_login']=="1"?$this->lang->line('facebook'):$single['is_social_login']=="2"?$this->lang->line('twitter'):$single['is_social_login']=="3"?$this->lang->line('google'):$this->lang->line('normal')?></td>
                                            <td>&nbsp;&nbsp;<a href="javascript:void(0)" class="ti-trash" style="color:red" data-toggle="tooltip" title="<?=$this->lang->line('delete')?>!" onclick="delete_status('<?=CUSTOMER_PATH?>/delete', '<?=$single['id']?>')"></a>&nbsp;&nbsp</td>
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

<?php include(ADMIN_INCLUDE_PATH . '/footer.php');
include(ADMIN_INCLUDE_PATH . '/close.php'); ?>