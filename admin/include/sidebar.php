<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <!--<li class="label">Main</li>-->

                <li class="active"><a href="<?= DASHBOARD_PATH ?>"><i class="ti-home"></i> <?=$this->lang->line('dashboard')?> </a></li>

                <li><a class="sidebar-sub-toggle"><i class="fa fa-group"></i> <?=$this->lang->line('users')?> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="<?= CUSTOMER_PATH ?>"><?=$this->lang->line('customers')?></a></li>
                        <li><a href="<?= DRIVERS_PATH ?>"><?=$this->lang->line('drivers')?></a></li>
                        <li><a href="<?= OWNER_PATH ?>"><?=$this->lang->line('restaurant_owners')?></a></li>

                    </ul>
                </li>

                <li><a class="sidebar-sub-toggle"><i class="fa fa-clipboard"></i> <?=$this->lang->line('menu')?> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>

                        <li><a href="<?= CATEGORY_PATH ?>"><?=$this->lang->line('categories')?></a></li>
                        <li><a href="<?= SUBCATEGORY_PATH ?>"><?=$this->lang->line('subcategories')?></a></li>

                    </ul>
                </li>
                <li><a class="sidebar-sub-toggle"><i class="fa fa-map-marker"></i> <?=$this->lang->line('locations')?> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="<?= COUNTRY_PATH ?>"><?=$this->lang->line('countries')?></a></li>
                        <li><a href="<?= STATE_PATH ?>"><?=$this->lang->line('states')?></a></li>
                        <li><a href="<?= CITY_PATH ?>"><?=$this->lang->line('cities')?></a></li>

                    </ul>
                </li>
                <li><a href="<?= NOTIFICATION_PATH ?>"><i class="fa fa-envelope"></i> <?=$this->lang->line('push_notifications')?> </a></li>
                <li><a href="<?= COUPONS_PATH ?>"><i class="fa fa-tags"></i> <?=$this->lang->line('coupons')?> </a></li>
                <li><a href="<?= ORDER_PATH ?>"><i class="fa fa-truck"></i> <?=$this->lang->line('orders')?> </a></li>
                <li><a href="<?= RESTAURANTS_PATH ?>"><i class="fa fa-cutlery"></i><?=$this->lang->line('restaurants')?></a></li>
                <li><a href="<?= SETTINGS_PATH ?>"><i class="ti-settings"></i><?=$this->lang->line('master_settings')?></a></li>

            </ul>
        </div>
    </div>
</div><!-- /# sidebar -->
<div class="header">
    <div class="pull-left">
        <div class="logo"><span><?= strtoupper(urldecode($this->settings->website_name)) ?></span></a></div>
        <div class="hamburger sidebar-toggle">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </div>

    <div class="pull-right p-r-15">

        <ul>
            <li class="header-icon dib">
                <img class="avatar-img" src="<?= ASSETSPATH . 'images/' . ($this->session->userdata('lang') ? $this->session->userdata('lang') : "english") ?>.png" alt="" />

                <span class="user-avatar"><?=$this->session->userdata('lang_short') ? strtoupper($this->session->userdata('lang_short')) : "EN" ?>
                    <i class="ti-angle-down f-s-10"></i>
                </span>
                <div class="drop-down dropdown-profile">
                    <div class="dropdown-content-body">
                        <ul>
                            <li><a href="<?= PROFILE_PATH ?>/change_language/english/en"><img class="avatar-img" src="<?= ASSETSPATH . 'images/' ?>english.png" alt="" /><span>&nbsp;&nbsp;&nbsp;English(EN)</span></a></li>
                            <li><a href="<?= PROFILE_PATH ?>/change_language/french/fr"><img class="avatar-img" src="<?= ASSETSPATH . 'images/' ?>french.png" alt="" /><span>&nbsp;&nbsp;&nbsp;French(FR)</span></a></li>
                            <li><a href="<?= PROFILE_PATH ?>/change_language/spanish/es"><img class="avatar-img" src="<?= ASSETSPATH . 'images/' ?>spanish.png" alt="" /><span>&nbsp;&nbsp;&nbsp;Spanish(ES)</span></a></li>
                            <li><a href="<?= PROFILE_PATH ?>/change_language/arabic/ar"><img class="avatar-img" src="<?= ASSETSPATH . 'images/' ?>arabic.png" alt="" /><span>&nbsp;&nbsp;&nbsp;Arabic(AR)</span></a></li>
                            
                        </ul>
                    </div>
                </div>
            </li>
        


            <li class="header-icon dib">

                <img class="avatar-img" src="<?= UPLOAD_URL . 'profile/' . $session_detail->image ?>" alt="" />


                <span class="user-avatar"><?= urldecode($session_detail->first_name) . ' ' . urldecode($session_detail->last_name); ?>
                    <i class="ti-angle-down f-s-10"></i>
                </span>
                <div class="drop-down dropdown-profile">
                    <div class="dropdown-content-body">
                        <ul>
                            <li><a href="<?= PROFILE_PATH ?>"><i class="ti-user"></i> <span><?=$this->lang->line('profile')?></span></a></li>
                            <li><a href="<?= PROFILE_PATH ?>/change_password"><i class="ti-user"></i> <span><?=$this->lang->line('change_password')?></span></a></li>
                            <li>
                                <a href="<?= LOGOUT_PATH; ?>">
                                    <i class="ti-power-off"></i> <span><?=$this->lang->line('logout')?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>