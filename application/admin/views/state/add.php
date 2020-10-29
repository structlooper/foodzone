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
                            <h1><?=$this->lang->line('states')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<? DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="<? STATE_PATH ?>"><?=$this->lang->line('state_list')?></a></li>
                                <li><a href="javascrit:void(0)" class="active"><?=$this->lang->line('edit_state')?></a></li>

                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->

            <div class="main-content">
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

                                    <form class="form-horizontal" action="<?= STATE_PATH ?>/add" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="addState">

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?=$this->lang->line('country')?>:</label>
                                            <div class="col-sm-9">
                                                <select class="form-control required" name="country_id" id="country_id">

                                                    <option value=""><?=$this->lang->line('select_country')?></option>
                                                    <?php
                                                    foreach ($country as $row) { ?>
                                                    <option  <?= $row['id'] == set_value('country_id') ? 'selected' : '' ?> value="<?= $row['id']; ?>"><?= urldecode($row['name']); ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?= form_error('country_id'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?=$this->lang->line('name')?>:</label>
                                            <div class="col-sm-9">
                                                <input id="name" class="form-control required" type="text" name="name" placeholder="<?=$this->lang->line('enter_name')?>" value="<?= set_value('name') ?>">
                                                <?= form_error('name'); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-lg btn-primary"><?=$this->lang->line('add')?></button>
                                                <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-lg btn-danger"><?=$this->lang->line('cancel')?></button>
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
include(ADMIN_INCLUDE_PATH . '/footer.php'); ?>
<?php
include(ADMIN_INCLUDE_PATH . '/close.php');
?>