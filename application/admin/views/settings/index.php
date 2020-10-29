<?php include(ADMIN_INCLUDE_PATH . '/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/sidebar.php'); ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=$this->lang->line('master_settings')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="<?=SETTINGS_PATH ?>"><?=$this->lang->line('master_settings')?></a></li>
                                
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
                                            <th><?=$this->lang->line('app_name')?></th>
                                            <th><?=$this->lang->line('app_logo')?></th>
                                            <th><?=$this->lang->line('email_id')?></th>
                                            <th><?=$this->lang->line('phone_number')?></th>
                                            <th><?=$this->lang->line('modified_date')?></th>
                                            <th width="100px"><?=$this->lang->line('action')?></th>    
                                        </tr>
                                    </thead>
                                <tbody>
                                        <?php

                                        if (!empty($results)) {

                                             
                                            foreach ($results as $single) { ?>
                                            <tr>
                                            <td><?=urldecode($single['website_name'])?></td>
                                            <td><img src="<?=UPLOAD_URL.$single['website_logo']?>" width="80px" /></td>
                                            <td><?=urldecode($single['email'])?></td>
                                            <td><?=$single['phone']?></td>
                                            <td><?=date('d-m-Y',strtotime($single['updated']))?></td>
                                            <td>&nbsp;&nbsp;<a class="fa fa-pencil" data-toggle="tooltip" style="color: #00c0ef;" title="<?=$this->lang->line('edit')?>!" href="<?=SETTINGS_PATH?>/edit/<?=$single['id']?>"></a></td>
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