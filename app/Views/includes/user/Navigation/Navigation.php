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

        // Define all menu items in an array
        $menu_items = [
            [
                'title' => 'Dashboard',
                'icon' => 'bx-home-circle',
                'link' => site_url('user/dashboard'),
                'sub_menu' => []
            ],
            [
                'title' => 'Messenger',
                'icon' => 'bxs-chat',
                'link' => site_url('user/messenger'),
                'sub_menu' => []
            ],
            [
                'title' => 'Doctor Appointment',
                'icon' => 'bx-plus-medical',
                'link' => 'javascript:void(0);',
                'sub_menu' => [
                    ['title' => 'Create Appointment', 'link' => site_url('user/medical/appointment/create')],
                    ['title' => 'Prescription History', 'link' => site_url('user/medical/prescription/history')],
                    ['title' => 'Appointment History', 'link' => site_url('user/medical/appointment/history')],
                ]
            ],
            [
                'title' => 'Disease Mapping',
                'icon' => 'bxs-virus',
                'link' => 'javascript:void(0);',
                'sub_menu' => [
                    ['title' => 'Local Heatmap', 'link' => site_url('user/heatmap')],
                    ['title' => 'Report Infection', 'link' => site_url('user/heatmap/report')],
                    ['title' => 'Your Reports', 'link' => site_url('user/heatmap/myreports')],
                ]
            ],
            [
                'title' => 'Blood Donation',
                'icon' => 'bx-donate-blood',
                'link' => 'javascript:void(0);',
                'sub_menu' => [
                    ['title' => 'Request Donation', 'link' => site_url('user/bloodbank/request')],
                    ['title' => 'List as Donor', 'link' => site_url('user/bloodbank/register')],
                    ['title' => 'Nearby Requests', 'link' => site_url('user/bloodbank/requests')],
                    ['title' => 'Nearby Donors', 'link' => site_url('user/bloodbank/doners')],
                    ['title' => 'Bloodbank Settings', 'link' => site_url('user/bloodbank/settings')],
                ]
            ],
            [
                'title' => 'Mosquito Identification',
                'icon' => 'bx-bug',
                'link' => 'javascript:void(0);',
                'sub_menu' => [
                    ['title' => 'Image Classification', 'link' => site_url('user/ai/classifier')],
                    ['title' => 'Classification History', 'link' => site_url('user/ai/history')],
                    ['title' => 'Queue', 'link' => site_url('user/ai/queue')],
                ]
            ],
            [
                'title' => 'Account Settings',
                'icon' => 'bxs-user-circle',
                'link' => 'javascript:void(0);',
                'sub_menu' => [
                    ['title' => 'Account Details', 'link' => site_url('user/settings')],
                    ['title' => 'Edit Account', 'link' => site_url('user/settings/edit')],
                    ['title' => 'Logout', 'link' => site_url('user/logout')],
                ]
            ]
        ];

        // Function to render menu items
        function render_menu($items, $current_url) {
            foreach ($items as $item) {
                $is_active = in_array($current_url, array_column($item['sub_menu'], 'link')) ? 'active open' : '';
                echo '<li class="menu-item ' . (empty($item['sub_menu']) && $current_url == $item['link'] ? 'active' : $is_active) . '">';
                echo '<a href="' . $item['link'] . '" class="menu-link ' . (empty($item['sub_menu']) ? '' : 'menu-toggle') . '">';
                echo '<i class="menu-icon tf-icons bx ' . $item['icon'] . '"></i>';
                echo '<div data-i18n="' . $item['title'] . '">' . $item['title'] . '</div>';
                echo '</a>';
                if (!empty($item['sub_menu'])) {
                    echo '<ul class="menu-sub">';
                    foreach ($item['sub_menu'] as $sub_item) {
                        $sub_active = $current_url == $sub_item['link'] ? 'active' : '';
                        echo '<li class="menu-item ' . $sub_active . '">';
                        echo '<a href="' . $sub_item['link'] . '" class="menu-link">';
                        echo '<div data-i18n="' . $sub_item['title'] . '">' . $sub_item['title'] . '</div>';
                        echo '</a></li>';
                    }
                    echo '</ul>';
                }
                echo '</li>';
            }
        }
    ?>

    <ul class="menu-inner py-1">
        <?php render_menu($menu_items, $current_url); ?>
    </ul>
</aside>
