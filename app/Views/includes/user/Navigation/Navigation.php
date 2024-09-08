  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="#" class="app-brand-link">
        <span class="app-brand-logo demo"></span>
        <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-item active">
        <a href="user/dashboard" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>

      <!-- Appointment -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Doctor Appointment</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item">
            <a href="user/medical/appointment/create" class="menu-link">
              <div data-i18n="Without menu">Create Appointment</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/medical/prescription/history" class="menu-link">
              <div data-i18n="Without navbar">Prescription History</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/medical/appointment/history" class="menu-link">
              <div data-i18n="Container">Appointment History</div>
            </a>
          </li>
        </ul>
      </li>

      <!-- Cards -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Disease Mapping</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item">
            <a href="user/heatmap" class="menu-link">
              <div data-i18n="Without menu">Local Heatmap</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/heatmap/report" class="menu-link">
              <div data-i18n="Without navbar">Report Infection</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/heatmap/myreports" class="menu-link">
              <div data-i18n="Container">Your Reports</div>
            </a>
          </li>
        </ul>
      </li>

      

      <!-- Extended components -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-copy"></i>
          <div data-i18n="Extended UI">Blood Donation</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="user/bloodbank/request" class="menu-link">
              <div data-i18n="Perfect Scrollbar">Request Donation</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/bloodbank/register" class="menu-link">
              <div data-i18n="Text Divider">List as Doner</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/bloodbank/requests" class="menu-link">
              <div data-i18n="Text Divider">Nearby Requests</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/bloodbank/doners" class="menu-link">
              <div data-i18n="Text Divider">Nearby Doners</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/bloodbank/settings" class="menu-link">
              <div data-i18n="Text Divider">Settings</div>
            </a>
          </li>
        </ul>
      </li>


      <!-- Extended components -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-copy"></i>
          <div data-i18n="Extended UI">Mosquito Identification</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="user/ai/classifier" class="menu-link">
              <div data-i18n="Perfect Scrollbar">Image Classification</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/ai/history" class="menu-link">
              <div data-i18n="Text Divider">Classification History</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/ai/queue" class="menu-link">
              <div data-i18n="Text Divider">Queue</div>
            </a>
          </li>
          <li class="menu-item">
        </ul>
      </li>

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Your Account</span>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-dock-top"></i>
          <div data-i18n="Account Settings">Account Settings</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="user/settings/account" class="menu-link">
              <div data-i18n="Account">Account</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/settings/privacy" class="menu-link">
              <div data-i18n="Connections">Privacy</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/settings/notifications" class="menu-link">
              <div data-i18n="Notifications">Notifications</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="user/settings/connections" class="menu-link">
              <div data-i18n="Connections">Connections</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
          <div data-i18n="Authentications">Authentications</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="user/settings/security/password" class="menu-link" target="_blank">
              <div data-i18n="Basic">Forgot Password</div>
            </a>
          </li>
        </ul>
      </li>
      

      <li class="menu-item">
        <a href="user/messenger" class="menu-link">
          <i class='menu-icon tf-icons bx bx-chat bx-flip-horizontal' ></i>
          <div data-i18n="Boxicons">Messenger</div>
        </a>
      </li>

      <!-- Misc -->
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
      <li class="menu-item">
        <a
          href="support"
          target="_blank"
          class="menu-link">
          <i class="menu-icon tf-icons bx bx-support"></i>
          <div data-i18n="Support">Support</div>
        </a>
      </li>
      <li class="menu-item">
        <a
          href="faq"
          target="_blank"
          class="menu-link">
          <i class="menu-icon tf-icons bx bx-file"></i>
          <div data-i18n="Documentation">FAQ</div>
        </a>
      </li>
    </ul>
  </aside>
  <!-- / Menu -->