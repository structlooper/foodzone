<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=$this->lang->line('forget_password')?></title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">

    <!-- Styles -->
    <link href="<?php echo ASSETSPATH; ?>css\lib\font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo ASSETSPATH; ?>css\lib\themify-icons.css" rel="stylesheet">
    <link href="<?php echo ASSETSPATH; ?>css\lib\bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ASSETSPATH; ?>css\lib\unix.css" rel="stylesheet">
    <link href="<?php echo ASSETSPATH; ?>css\style.css" rel="stylesheet">
    <style>
        .login-form .error {
            color: #FA001A;
        }
    </style>
</head>

<body class="bg-primary">

    <div class="unix-login">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="javascript:void(0)"><span><?= urldecode($this->settings->website_name) ?></span></a>


                        </div>
                        <div class="login-form">
                            <h4><?=$this->lang->line('forget_password')?></h4>


                           
                            <?php if (isset($error_message) && $error_message != '') {  ?>

                                <div class="alert alert-danger alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><?=$this->lang->line('error')?>!</strong> <?php echo isset($error_message) ? $error_message : $this->session->flashdata('invalid'); ?>
                                </div>

                            <?php } ?>
                            <?php if (isset($success_message) && $success_message != '') {  ?>

                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong><?=$this->lang->line('success')?>!</strong> <?php echo isset($success_message) ? $success_message : $this->session->flashdata('invalid'); ?>
                                </div>

                            <?php } ?>

                            <form accept-charset="utf-8" method="post" action="<?= FORGET_PASSWORD; ?>">

                                <div class="form-group">
                                    <label><?=$this->lang->line('email_id')?></label>
                                    <input type="email" class="form-control required" name="email" placeholder="<?=$this->lang->line('enter_email_id')?>" value="<?= set_value('email') ?>">
                                    <?= form_error('email'); ?>
                                </div>
                                
                                <div class="checkbox">
                                    <label class="pull-right">
                                        <a href="<?=LOGIN_PATH?>"><?=$this->lang->line('back_to_login')?></a>

                                    </label>

                                </div>

                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30"><?=$this->lang->line('send')?></button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>