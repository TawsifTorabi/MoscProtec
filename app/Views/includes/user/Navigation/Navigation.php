<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-logo demo"></span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">
                <img src="<?= site_url('assets/img/black_logo.png'); ?>" style="width: 4em;" alt="">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <?php 
        $current_url = current_url(); // Get the current URL
    ?>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?= ($current_url == site_url('user/dashboard')) ? 'active' : ''; ?>">
            <a href="<?= site_url('user/dashboard') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Appointment -->
        <?php
            $appointment_active = in_array($current_url, [
                site_url('user/medical/appointment/create'), 
                site_url('user/medical/prescription/history'), 
                site_url('user/medical/appointment/history')
            ]) ? 'active open' : '';
        ?>
        <li class="menu-item <?= $appointment_active; ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Doctor Appointment</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($current_url == site_url('user/medical/appointment/create')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/medical/appointment/create') ?>" class="menu-link">
                        <div data-i18n="Without menu">Create Appointment</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/medical/prescription/history')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/medical/prescription/history') ?>" class="menu-link">
                        <div data-i18n="Without navbar">Prescription History</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/medical/appointment/history')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/medical/appointment/history') ?>" class="menu-link">
                        <div data-i18n="Container">Appointment History</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Disease Mapping -->
        <?php
            $disease_mapping_active = in_array($current_url, [
                site_url('user/heatmap'), 
                site_url('user/heatmap/report'), 
                site_url('user/heatmap/myreports')
            ]) ? 'active open' : '';
        ?>
        <li class="menu-item <?= $disease_mapping_active; ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Disease Mapping</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($current_url == site_url('user/heatmap')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/heatmap') ?>" class="menu-link">
                        <div data-i18n="Without menu">Local Heatmap</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/heatmap/report')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/heatmap/report') ?>" class="menu-link">
                        <div data-i18n="Without navbar">Report Infection</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/heatmap/myreports')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/heatmap/myreports') ?>" class="menu-link">
                        <div data-i18n="Container">Your Reports</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Blood Donation -->
        <?php
            $blood_donation_active = in_array($current_url, [
                site_url('user/bloodbank/request'), 
                site_url('user/bloodbank/register'), 
                site_url('user/bloodbank/requests'), 
                site_url('user/bloodbank/doners'), 
                site_url('user/bloodbank/settings')
            ]) ? 'active open' : '';
        ?>
        <li class="menu-item <?= $blood_donation_active; ?>">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div data-i18n="Extended UI">Blood Donation</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($current_url == site_url('user/bloodbank/request')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/bloodbank/request') ?>" class="menu-link">
                        <div data-i18n="Perfect Scrollbar">Request Donation</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/bloodbank/register')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/bloodbank/register') ?>" class="menu-link">
                        <div data-i18n="Text Divider">List as Doner</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/bloodbank/requests')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/bloodbank/requests') ?>" class="menu-link">
                        <div data-i18n="Text Divider">Nearby Requests</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/bloodbank/doners')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/bloodbank/doners') ?>" class="menu-link">
                        <div data-i18n="Text Divider">Nearby Doners</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/bloodbank/settings')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/bloodbank/settings') ?>" class="menu-link">
                        <div data-i18n="Text Divider">Bloodbank Settings</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Mosquito Identification -->
        <?php
            $mosquito_id_active = in_array($current_url, [
                site_url('user/ai/classifier'), 
                site_url('user/ai/history'), 
                site_url('user/ai/queue')
            ]) ? 'active open' : '';
        ?>
        <li class="menu-item <?= $mosquito_id_active; ?>">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div data-i18n="Extended UI">Mosquito Identification</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($current_url == site_url('user/ai/classifier')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/ai/classifier') ?>" class="menu-link">
                        <div data-i18n="Perfect Scrollbar">Image Classification</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/ai/history')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/ai/history') ?>" class="menu-link">
                        <div data-i18n="Text Divider">Classification History</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/ai/queue')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/ai/queue') ?>" class="menu-link">
                        <div data-i18n="Text Divider">Queue</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Your Account -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Your Account</span>
        </li>
        <?php
            $account_settings_active = in_array($current_url, [
                site_url('user/settings'), 
                site_url('user/settings/edit'), 
                site_url('user/logout')
            ]) ? 'active open' : '';
        ?>
        <li class="menu-item <?= $account_settings_active; ?>">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($current_url == site_url('user/settings')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/settings') ?>" class="menu-link">
                        <div data-i18n="Account">Account Details</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/settings/edit')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/settings/edit') ?>" class="menu-link">
                        <div data-i18n="Notifications">Edit Account</div>
                    </a>
                </li>
                <li class="menu-item <?= ($current_url == site_url('user/logout')) ? 'active' : ''; ?>">
                    <a href="<?= site_url('user/logout') ?>" class="menu-link">
                        <div data-i18n="Connections">Logout</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
