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
                            <h1><?=$this->lang->line('restaurant_owners')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="<?= OWNER_PATH ?>"><?=$this->lang->line('owner_list')?></a></li>
                                <li><a class="active" href="javascript:void(0)"><?=$this->lang->line('add_owner')?></a></li>

                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->

            <div class="main-content">
                <?php if (isset($error_message) && $error_message != '') { ?>

                    <div class="alert alert-danger alert-settings">
                        <ul class="error-message">
                            <li> <?= isset($error_message) ? $error_message : $this->session->flashdata('invalid'); ?> </li>
                        </ul>
                    </div>

                <?php } ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                           
                            <div class="card-body">
                                <div class="menu-upload-form">

                                    <form class="form-horizontal" action="<?= OWNER_PATH ?>/add" method="post" accept-charset="utf-8" id="addOwner">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('first_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="first_name" class="form-control required" type="text" name="first_name" placeholder="<?=$this->lang->line('enter_first_name')?>" value="<?= set_value('first_name') ?>">
                                                        <?= form_error('first_name'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('last_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="last_name" class="form-control required" type="text" name="last_name" placeholder="<?=$this->lang->line('enter_last_name')?>" value="<?= set_value('last_name') ?>">
                                                        <?= form_error('last_name'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('email_id')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="email_id" class="form-control required" type="text" name="email_id" placeholder="<?=$this->lang->line('enter_email_id')?>" value="<?= set_value('email_id') ?>">
                                                        <?= form_error('email_id'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('hone_number')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="phone_number" class="form-control required" type="text" name="phone_number" placeholder="<?=$this->lang->line('enter_phone_number')?>" value="<?= set_value('phone_number') ?>">
                                                        <?= form_error('phone_number'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('password')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="password" class="form-control required" type="password" name="password" placeholder="<?=$this->lang->line('enter_password')?>" value="<?= set_value('password') ?>">
                                                        <?= form_error('password'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('country')?>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control required" name="country_id" id="country_id">

                                                            <option value=""><?=$this->lang->line('select_country')?></option>
                                                            <?php
                                                            foreach ($country as $row) { ?>
                                                                <option <?=set_value('country_id')==$row['id']?"selected":""?> value="<?= $row['id']; ?>"><?= urldecode($row['name']); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <?= form_error('country_id'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('state')?>:</label>
                                                    <div class="col-sm-8" id="change_state">
                                                        <select class="form-control required" name="state_id" id="state_id">

                                                            <option value=""><?=$this->lang->line('select_state')?></option>
                                                           
                                                        </select>
                                                        <?= form_error('state_id'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('city')?>:</label>
                                                    <div class="col-sm-8" id="change_city">
                                                        <select class="form-control required" name="city_id" id="city_id">

                                                            <option value=""><?=$this->lang->line('select_city')?></option>
                                                            
                                                        </select>
                                                        <?= form_error('city_id'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('pincode')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="pincode" class="form-control required" type="text" name="pincode" placeholder="<?=$this->lang->line('enter_pincode')?>" value="<?= set_value('pincode') ?>">
                                                        <?= form_error('pincode'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?=$this->lang->line('address')?>:</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="address" class="form-control required" name="address" placeholder="<?=$this->lang->line('enter_address')?>"><?= set_value('address') ?></textarea>
                                                        <?= form_error('address'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-9">
                                                        <button type="submit" class="btn btn-lg btn-primary"><?=$this->lang->line('add')?></button>
                                                        <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-lg btn-danger"><?= $this->lang->line('cancel') ?></a>
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
include(ADMIN_INCLUDE_PATH . '/footer.php');  ?>
<script type="text/javascript">
    $(document).on('change', '#country_id', function() {
        var country_id = $(this).val();
        $('#state_id').val("");
        $('#city_id').val("");
        $.ajax({
            type: "POST",
            url: "<?= OWNER_PATH ?>/getState",
            data: {
                'country_id': country_id
            },
            success: function(data) {
                $('#state_id').html(data);
            }
        });
    })

    $(document).on('change', '#state_id', function() {
        var state_id = $(this).val();
        $('#city_id').val("");
        $.ajax({
            type: "POST",
            url: "<?= OWNER_PATH ?>/getCity",
            data: {
                'state_id': state_id
            },
            success: function(data) {
                $('#city_id').html(data);
            }
        });
    })
</script>
<?php
include(ADMIN_INCLUDE_PATH . '/close.php');
?>