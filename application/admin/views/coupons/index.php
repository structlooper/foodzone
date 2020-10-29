<?php include(ADMIN_INCLUDE_PATH . '/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/sidebar.php'); ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= $this->lang->line('coupons') ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?= $this->lang->line('dashboard') ?></a></li>
                                <li><a href="<?= COUPONS_PATH ?>"><?= $this->lang->line('coupon_list') ?></a></li>
                                <!--	<li class="active">Data Table</li>-->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">

                <?php if (isset($success_message) && $success_message != '') {  ?>

                    <div class="alert alert-info alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><?= $this->lang->line('success') ?>!</strong> <?php echo isset($success_message) ? $success_message : $this->session->flashdata('invalid'); ?>
                    </div>

                <?php  } ?>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card alert">

                            <div class="pull-right">
                                <a class="btn btn-success btn-flat m-b-10 m-l-5" style="margin-right:15px!important" href="<?= COUPONS_PATH ?>/add"><?= $this->lang->line('add_coupon') ?></a>
                                <input class="btn btn-danger btn-flat m-b-10 m-l-5" type="submit" onclick="multiple_delete('<?= COUPONS_PATH ?>/multiple_delete')" id="postme" value="Delete" disabled="disabled">


                            </div>


                            <div class="bootstrap-data-table-panel">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>
                                        <tr>
                                            <th><input type='checkbox' name='select_all' id='select_all' value='' /></th>

                                            <th><?= $this->lang->line('id') ?></th>
                                            <th><?= $this->lang->line('image') ?></th>
                                            <th><?= $this->lang->line('coupon_code') ?></th>
                                            <th><?= $this->lang->line('start_date') ?></th>
                                            <th><?= $this->lang->line('end_date') ?></th>
                                            <th><?= $this->lang->line('discount') ?></th>
                                            <th><?= $this->lang->line('description') ?></th>
                                            <th width="100px"><?= $this->lang->line('action') ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($results)) {

                                            $html = '';

                                            foreach ($results as $single) { ?>
                                                <tr>
                                                    <td><input type='checkbox' name='checked_id' id='checkbox1' class='checkbox' value='<?= $single['id'] ?>' /></td>
                                                    <td><?= $single['id'] ?></td>
                                                    <td><img src="<?=UPLOAD_URL.'coupons/'.$single['image']?>" width="80px" /></td>
                                                    <td><?= urldecode($single['coupon_code']) ?></td>
                                                    <td><?= date('d-m-Y', strtotime($single['start_date'])) ?></td>
                                                    <td><?= date('d-m-Y', strtotime($single['end_date'])) ?></td>
                                                    <td><?= $single['discount'] ?></td>
                                                    <td><?= urldecode($single['description']) ?></td>
                                                    <td>&nbsp;&nbsp;<a class="ti-pencil-alt" data-toggle="tooltip" style="color: #00c0ef;" title="<?= $this->lang->line('edit') ?>!" href="<?= COUPONS_PATH ?>/edit/<?= $single['id'] ?>"></a>&nbsp;&nbsp;
                                                        <a href="javascript:void(0)" class="ti-trash" style="color:red" data-toggle="tooltip" title="<?= $this->lang->line('delete') ?>!" onclick="delete_status('<?= COUPONS_PATH ?>/delete', '<?= $single['id'] ?>')"></a></td>
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