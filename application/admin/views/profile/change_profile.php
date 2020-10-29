<?php defined('BASEPATH') or exit('No direct script access allowed');
include(ADMIN_INCLUDE_PATH . '/header.php');
include(ADMIN_INCLUDE_PATH . '/sidebar.php');
?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=$this->lang->line('update_profile')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?=DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="<?=PROFILE_PATH ?>"><?=$this->lang->line('update_profile')?></a></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->

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
                            
                            <div class="card-body">
                                <div class="menu-upload-form">

                                    <form class="form-horizontal" action="<?= PROFILE_PATH ?>" method="post" accept-charset="utf-8" id="editProfile" enctype="multipart/form-data">
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('first_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="first_name" class="form-control required" type="text" name="first_name" placeholder="<?=$this->lang->line('enter_first_name')?>" value="<?=urldecode($results->first_name)?>">
                                                        <?= form_error('first_name'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('last_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="last_name" class="form-control required" type="text" name="last_name" placeholder="<?=$this->lang->line('enter_last_name')?>" value="<?=urldecode($results->last_name)?>">
                                                        <?= form_error('last_name'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('email_id')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="email" class="form-control required" type="text" name="email" placeholder="<?=$this->lang->line('enter_email_id')?>" value="<?=urldecode($results->email)?>">
                                                        <?= form_error('email'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('phone_number')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="phone" class="form-control required" type="text" name="phone" placeholder="<?=$this->lang->line('enter_phone_number')?>" value="<?=$results->phone?>">
                                                        <?= form_error('phone'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('profile_image')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="image" class="form-control required" type="file" name="image" placeholder="<?=$this->lang->line('upload_profile_image')?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-9">
                                                        <button type="submit" class="btn btn-lg btn-primary"><?=$this->lang->line('update')?></button>
                                                        <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-lg btn-danger"><?=$this->lang->line('cancel')?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- /# card -->
                    </div><!-- /# column -->
                </div><!-- /# row -->
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->

<?php
include(ADMIN_INCLUDE_PATH . '/footer.php');  
include(ADMIN_INCLUDE_PATH . '/close.php');
?>