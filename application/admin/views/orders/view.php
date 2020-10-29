<?php include(ADMIN_INCLUDE_PATH . '/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/sidebar.php'); ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?=$this->lang->line('orders')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?=$this->lang->line('dashboard')?></a></li>
                                <li><a href="<?= ORDER_PATH ?>"><?=$this->lang->line('order_list')?></a></li>
                                <li class="active"><?=$this->lang->line('order_details')?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
            
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=$this->lang->line('order_id')?> # <?php echo $order_info->id; ?> </h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                
                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?=$this->lang->line('order_date')?>:</td>
                                                <td class="text-right"><?=date('d/m/Y H:i a', strtotime($order_info->created)); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('order_status')?>:</td>
                                                <td class="text-right"><?=$controller->getOrderStatus($order_info->order_status); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('payment_status')?>:</td>
                                                <td class="text-right"><?=$controller->getPaymentStatus($order_info->payment_status); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('payment_type')?>:</td>
                                                <td class="text-right"><?=$controller->getPaymentType($order_info->payment_type); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('tip')?>:</td>
                                                <td class="text-right"><?=CURRENCY?><?=$order_info->tip_price; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('discount')?>:</td>
                                                <td class="text-right"><?=CURRENCY?><?=$order_info->discount_price; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('wallet_amount')?>:</td>
                                                <td class="text-right"><?=CURRENCY?><?=$order_info->wallet_price; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('paid_amount')?>:</td>
                                                <td class="text-right"><?=CURRENCY?><?=$order_info->total_price; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('admin_charge')?>:</td>
                                                <td class="text-right"><?=CURRENCY?><?=$order_info->admin_charge; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('grand_total')?>:</td>
                                                <td class="text-right"><?=CURRENCY?><?=$order_info->grand_total; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=$this->lang->line('restaurant_information')?></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                        
                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?=$this->lang->line('name')?>:</td>
                                                <td class="text-right"><a href="<?php echo $order_info->restaurant_id; ?>" style="color:#ff2e44"><?=urldecode($order_info->name); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('phone_number')?>:</td>
                                                <td class="text-right"><?=$order_info->r_phone; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('email_id')?>:</td>
                                                <td class="text-right"><a href=<?php echo 'mailto:'.urldecode($order_info->r_email); ?>><?=urldecode($order_info->r_email); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('address')?>:</td>
                                                <td class="text-right"><?=urldecode($order_info->address); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('opening_time')?>:</td>
                                                <td class="text-right"><?=date('h:i a', strtotime($order_info->opening_time)); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('closing_time')?>:</td>
                                                <td class="text-right"><?=date('h:i a', strtotime($order_info->closing_time)); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('average_price')?>:</td>
                                                <td class="text-right">$<?=$order_info->average_price; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                    
                                    
                                </div>                                    
                            </div>
                                
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=$this->lang->line('customer_information')?></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                        
                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            <tr>
                                                <td><?=$this->lang->line('name')?>:</td>
                                                <td class="text-right"><a href="<?php echo $order_info->user_id; ?>" style="color:#ff2e44"><?=urldecode($order_info->customer_name); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('phone_number')?>:</td>
                                                <td class="text-right"><?=$order_info->customer_phone; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('email_id')?>:</td>
                                                <td class="text-right"><a href=<?php echo 'mailto:'.urldecode($order_info->customer_email); ?>><?=urldecode($order_info->customer_email); ?></a></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                    
                                    
                                </div>                                    
                            </div>
                                
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=$this->lang->line('delivery_information')?></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                        
                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tbody>
                                            
                                            <tr>
                                                <td><?=$this->lang->line('name')?>:</td>
                                                <td class="text-right"><?=urldecode($order_info->user_name); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$this->lang->line('address')?>:</td>
                                                <td class="text-right"><?=urldecode($order_info->address_line_1) .' '.urldecode($order_info->address_line_2).', '.urldecode($order_info->city); ?></td>
                                            </tr>
                                           
                                            <tr>
                                                <td>Phone:</td>
                                                <td class="text-right"><?php echo $order_info->phone; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                    
                                    
                                </div>                                    
                            </div>
                                
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    
                    
                  
                    <div class="clearfix"></div>
                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h4><?=$this->lang->line('order_information')?></h4></h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                        
                                    <table class="table table-borderless table-sm table-responsive custom-table">
                                        <tr>
                                            <th><?=$this->lang->line('image')?></th>
                                            <th><?=$this->lang->line('item')?></th>
                                            <th><?=$this->lang->line('quantity')?></th>
                                            <th><?=$this->lang->line('item_price')?></th>
                                            <th><?=$this->lang->line('total_price')?></th>
                                            <th><?=$this->lang->line('extra_note')?></th>
                                        </tr>
                                        <?php
                                            foreach($get_order_details as $rows){ ?>
                                            <tr>
                                            <td width="100px"><img src="<?=UPLOAD_URL.'subcategory/'.$rows['image']?>" width="80px" /></td>
                                            <td><?=urldecode($rows['title'])?></td>
                                            <td><?=$rows['product_quantity']?></td>
                                            <td><?=CURRENCY?><?=$rows['product_price']?></td>
                                            <td><?=CURRENCY?><?=$rows['product_price'] * $rows['product_quantity']?></td>
                                            <td><?=urldecode($rows['extra_note'])?></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                        
                                    
                                </div>
                                    
                                
                                
                            </div>
                                
                        </div>
                    </div>
                    
                </div><!-- /# row -->
                                
               
                    
                    
                    
                </div>
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->

<?php include(ADMIN_INCLUDE_PATH . '/footer.php');
include(ADMIN_INCLUDE_PATH . '/close.php'); ?>