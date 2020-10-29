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
                            <h1><?= $this->lang->line('cities') ?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<? DASHBOARD_PATH ?>"><?= $this->lang->line('dashboard') ?></a></li>
                                <li><a href="<? CITY_PATH ?>"><?= $this->lang->line('city_list') ?></a></li>
                                <li><a class="active" href="javascript:void(0)"><?= $this->lang->line('add_city') ?></a></li>

                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->

            <div class="main-content">
                <?php if (isset($success_message) && $success_message != '') {  ?>

                    <div class="alert alert-info alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><?= $this->lang->line('success') ?>!</strong> <?php echo isset($success_message) ? $success_message : $this->session->flashdata('invalid'); ?>
                    </div>

                <?php  } ?>

                <?php if (isset($error_message) && $error_message != '') {  ?>

                    <div class="alert alert-info alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><?= $this->lang->line('error') ?>!</strong> <?php echo isset($error_message) ? $error_message : $this->session->flashdata('invalid'); ?>
                    </div>

                <?php } ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">

                            <div class="card-body">
                                <div class="menu-upload-form">

                                    <form class="form-horizontal" action="<?= CITY_PATH ?>/add" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="addState">

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?= $this->lang->line('state') ?>:</label>
                                            <div class="col-sm-9">
                                                <select class="form-control required" name="state_id" id="state_id">

                                                    <option value=""><?= $this->lang->line('select_state') ?></option>
                                                    <?php
                                                    foreach ($state as $row) { ?>
                                                        <option <?= $row['id'] == set_value('state_id') ? 'selected' : '' ?> value="<?= $row['id']; ?>"><?= urldecode($row['name']); ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?= form_error('state_id'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?= $this->lang->line('name') ?>:</label>
                                            <div class="col-sm-9">
                                                <input id="name" class="form-control required" type="text" name="name" placeholder="<?= $this->lang->line('enter_name') ?>" value="<?= set_value('name') ?>">
                                                <?= form_error('name'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-lg btn-primary"><?= $this->lang->line('add') ?></button>
                                                <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-lg btn-danger"><?= $this->lang->line('cancel') ?></a>
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