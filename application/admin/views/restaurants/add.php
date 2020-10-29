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
                            <h1><?=$this->lang->line('restaurants')?></h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="<?= RESTAURANTS_PATH ?>"><?=$this->lang->line('restaurant_list')?></a></li>
                                <li><a class="active" href="javascript:void(0)"><?=$this->lang->line('add_restaurant')?></a></li>

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

                                    <form class="form-horizontal" action="<?= RESTAURANTS_PATH ?>/add" method="post" accept-charset="utf-8" id="addOwner" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('name')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="name" class="form-control required" type="text" name="name" placeholder="<?=$this->lang->line('enter_name')?>" value="<?= set_value('name') ?>">
                                                        <?= form_error('name'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('owner')?>:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control required" name="owner_id" id="owner_id">

                                                            <option value=""><?=$this->lang->line('select_owner')?></option>
                                                            <?php
                                                            foreach ($owners as $row) { ?>
                                                                <option <?=set_value('owner_id')==$row['id']?"selected":""?> value="<?= $row['id']; ?>"><?= urldecode($row['first_name']).' '.urldecode($row['last_name']); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <?= form_error('owner_id'); ?>
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
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('phone_number')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="phone_number" class="form-control required" type="text" name="phone_number" placeholder="<?=$this->lang->line('enter_phone_number')?>" value="<?= set_value('phone_number') ?>">
                                                        <?= form_error('phone_number'); ?>
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
                                                                <option value="<?= $row['id']; ?>"><?= urldecode($row['name']); ?></option>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('opening_time')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="opening_time" class="form-control required" type="time" name="opening_time" placeholder="<?=$this->lang->line('enter_opening_time')?>"  value="<?= set_value('opening_time') ?>">
                                                        <?= form_error('opening_time'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('closing_time')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="closing_time" class="form-control required" type="time" name="closing_time" placeholder="<?=$this->lang->line('enter_closing_time')?>" value="<?= set_value('closing_time') ?>">
                                                        <?= form_error('closing_time'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('discount_type')?>:</label>
                                                    <div class="col-sm-8">
                                                        <label class="customRadio"><?=$this->lang->line('flat_amount')?>
                                                            <input type="radio" name="discount_type" checked  value="0">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label class="customRadio"><?=$this->lang->line('percentage')?>
                                                            <input type="radio" name="discount_type" value="1">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><?=$this->lang->line('discount')?>:</label>
                                                    <div class="col-sm-8">
                                                        <input id="discount" class="form-control" type="number" name="discount" placeholder="Enter discount" value="0.00">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?=$this->lang->line('average_price')?>:</label>
                                                    <div class="col-sm-10">
                                                        <input id="average_price" class="form-control" type="number" name="average_price" placeholder="<?=$this->lang->line('enter_average_price')?>" value="0.00">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?=$this->lang->line('upload_image')?>:</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-line">
                                            
                                                            <div class="happening_bannerUpload_field happening_bannerGallery_field">
                                                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 hgu_main div_for_20px_margin">
                                                                    <img class="ngwp-upload-img" id="happening_gallery_src1" src="<?=ASSETSPATH?>images/white_back.png" />
                                                                    <input type="file" class=" happening_banner_input" rel="1" id="profile_image1" name="profile_image[]"  />
                                                                    <img class="fileinput_trigger gellery_fileinput_trigger add_remove_hclass1" rel="1" src="<?=ASSETSPATH?>images/camera_banner_imageSmall.png" />
                                                                    
                                                                    <div class="gupload_photo_label gupload_photo_label1"><?=$this->lang->line('upload_image')?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-9">
                                                        <button type="submit" class="btn btn-lg btn-primary"><?=$this->lang->line('add')?></button>
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
include(ADMIN_INCLUDE_PATH . '/footer.php');  ?>
<script type="text/javascript">

    $(document).on('click', '.remove_hgu_photo', function(){
        $(this).parent().parent().remove();
    });
    
    $(document).on('change', "[id^='happening_gallery_change']", function(event, ChngID){
        change_rel_attr= $(this).attr('rel');
        readHGImgURL(event, change_rel_attr);
        var image_input_change= $(this).val().split('\\').pop();
        $(this).parent().find(".hidden_image_input").val(image_input_change);
        
    });
    
    $(document).on('click', '.gellery_fileinput_trigger', function(){
        var rel_attr= $(this).attr('rel');
        $('#profile_image'+rel_attr).trigger('click'); 
    });
    var counter_hapImg= $('.hgu_main').length;
    $(document).on('change', "[id^='profile_image']", function(event, ChngID){
        counter_hapImg++;
        var image_input= $(this).val().split('\\').pop();
        var max_galerry_img= $('.max_gallery_image ').length;
       
        this_rel_attr= $(this).attr('rel');
        $(this).parent().addClass('hgu_main_overlay');
        $(this).parent().addClass('max_gallery_image');
        var image_content= '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 hgu_main div_for_20px_margin"><img class="ngwp-upload-img" src="<?=ASSETSPATH?>images/white_back.png" id="happening_gallery_src'+counter_hapImg+'" /><input type="file" class=" happening_banner_input" rel="'+counter_hapImg+'" id="profile_image'+counter_hapImg+'" name="profile_image[]"  /><img class="fileinput_trigger gellery_fileinput_trigger add_remove_hclass'+counter_hapImg+'" rel="'+counter_hapImg+'" src="<?=ASSETSPATH?>images/camera_banner_imageSmall.png" /><div class="gupload_photo_label gupload_photo_label'+counter_hapImg+'"><?=$this->lang->line('upload_image')?></div></div>';
       // if(counter_hapImg<=4) {
        $('.happening_bannerGallery_field').append(image_content);
        //}
        readHGImgURL(event, this_rel_attr);
        $('.gupload_photo_label'+this_rel_attr).addClass('gupload_photo_labelChange');

        $('.gellery_fileinput_trigger').addClass('change_hgu_photo');
        $('.add_remove_hclass'+this_rel_attr).remove();
        $('.gupload_photo_label'+this_rel_attr).html('<label class="remove_hgu_photo"><i class="fa fa-trash"></i></label>');
        $(this).removeAttr('id');
        $(this).attr('id', 'happening_gallery_change'+this_rel_attr);
        
       
    });
    function readHGImgURL(event, ChngID) 
    {   
        var outputFt = document.getElementById('happening_gallery_src'+ChngID);
        outputFt.src = URL.createObjectURL(event.target.files[0]);          
    }
    $(document).on('change', '#country_id', function() {
        var country_id = $(this).val();
        $('#state_id').val("");
        $('#city_id').val("");
        $.ajax({
            type: "POST",
            url: "<?= RESTAURANTS_PATH ?>/getState",
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
            url: "<?= RESTAURANTS_PATH ?>/getCity",
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