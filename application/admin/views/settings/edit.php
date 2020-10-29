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
                            <h1><?=$this->lang->line('master_settings')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?=DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="javascript:void(0)"><?=$this->lang->line('edit_details')?></a></li>
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

                                    <form class="form-horizontal" action="<?= SETTINGS_PATH ?>/edit/<?=$results->id?>" method="post" accept-charset="utf-8" id="editOwner" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4><?=$this->lang->line('normal_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('app_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="website_name" placeholder="<?=$this->lang->line('enter_app_name')?>" value="<?=urldecode($results->website_name)?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('email_id')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="email" class="form-control required" type="text" name="email" placeholder="<?=$this->lang->line('enter_email_id')?>" value="<?=urldecode($results->email)?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('charges_from_owners')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="charge_from_owner" class="form-control required" type="number" name="charge_from_owner" placeholder="<?=$this->lang->line('enter_charges')?>" min="0" max="99" value="<?=$results->charge_from_owner?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('phone_number')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="phone" class="form-control required" type="text" name="phone" placeholder="<?=$this->lang->line('enter_phone_number')?>" value="<?=$results->phone?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('app_logo')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="website_logo" class="form-control required" type="file" name="website_logo" placeholder="<?=$this->lang->line('upload_app_logo')?>">
                                                    </div>
                                                </div>
                                            </div>
                                           

                                            <div class="col-md-12">
                                                <h4><?=$this->lang->line('smtp_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('smtp_host')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="smtp_host" placeholder="<?=$this->lang->line('enter_smtp_host')?>" value="<?=$results->smtp_host?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('smtp_port')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="smtp_port" placeholder="<?=$this->lang->line('enter_smtp_port')?>" value="<?=$results->smtp_port?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('smtp_user_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="smtp_username" placeholder="<?=$this->lang->line('enter_smtp_user_name')?>" value="<?=urldecode($results->smtp_username)?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('smtp_password')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="password" name="smtp_password" placeholder="<?=$this->lang->line('enter_smtp_password')?>" value="<?=$results->smtp_password?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('smtp_from_email')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="smpt_from_email" placeholder="<?=$this->lang->line('enter_smtp_from_email')?>" value="<?=urldecode($results->smpt_from_email)?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('smtp_from_name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="smtp_from_name" placeholder="<?=$this->lang->line('enter_smtp_from_name')?>" value="<?=urldecode($results->smtp_from_name)?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <h4><?=$this->lang->line('stripe_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('private_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="stripe_private_key" placeholder="<?=$this->lang->line('enter_private_key')?>" value="<?=$results->stripe_private_key?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('publishable_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="stripe_publish_key" placeholder="<?=$this->lang->line('enter_publishable_key')?>" value="<?=$results->stripe_publish_key?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <h4><?=$this->lang->line('paypal_braintree_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('environment')?>:</label>
                                                    <div class="col-sm-8">
                                                        <select  class="form-control required"  name="braintree_environment" >
                                                            <option <?=$results->braintree_environment=="sandbox"?"selected":""?> value="sandbox"><?=$this->lang->line('sand_box')?></option>
                                                            <option <?=$results->braintree_environment=="live"?"selected":""?> value="live"><?=$this->lang->line('live')?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('merchant_id')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input  class="form-control required" type="text" name="braintree_merchant_id" placeholder="<?=$this->lang->line('enter_merchant_id')?>" value="<?=$results->braintree_merchant_id?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('public_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="braintree_public_key" placeholder="<?=$this->lang->line('enter_public_key')?>" value="<?=$results->braintree_public_key?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('private_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="braintree_private_key" placeholder="<?=$this->lang->line('enter_private_key')?>" value="<?=$results->braintree_private_key?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <h4><?=$this->lang->line('other_settings')?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('map_api_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input  class="form-control required" type="text" name="map_api_key" placeholder="<?=$this->lang->line('enter_ma_api_key')?>" value="<?=$results->map_api_key?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('fcm_key')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control required" type="text" name="fcm_key" placeholder="<?=$this->lang->line('enter_fcm_key')?>" value="<?=$results->fcm_key?>">
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