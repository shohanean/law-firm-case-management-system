
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('dashboard_assets') }}/images/favicon-32x32.png" type="image/png" />
  <!--plugins-->
  <link href="{{ asset('dashboard_assets') }}/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
  <link href="{{ asset('dashboard_assets') }}/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="{{ asset('dashboard_assets') }}/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="{{ asset('dashboard_assets') }}/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="{{ asset('dashboard_assets') }}/css/bootstrap.min.css" rel="stylesheet" />
  <link href="{{ asset('dashboard_assets') }}/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="{{ asset('dashboard_assets') }}/css/style.css" rel="stylesheet" />
  <link href="{{ asset('dashboard_assets') }}/css/icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


  <!-- loader-->
	<link href="{{ asset('dashboard_assets') }}/css/pace.min.css" rel="stylesheet" />

  <!--Theme Styles-->
  <link href="{{ asset('dashboard_assets') }}/css/dark-theme.css" rel="stylesheet" />
  <link href="{{ asset('dashboard_assets') }}/css/light-theme.css" rel="stylesheet" />
  <link href="{{ asset('dashboard_assets') }}/css/semi-dark.css" rel="stylesheet" />
  <link href="{{ asset('dashboard_assets') }}/css/header-colors.css" rel="stylesheet" />

  <title>Onedash - Bootstrap 5 Admin Template</title>
  <script>
    // Apply saved theme before page renders to prevent flash
    (function () {
      function getCookie(name) {
        var match = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
        return match ? decodeURIComponent(match[1]) : null;
      }
      var theme = getCookie('cms_theme');
      var headerColor = getCookie('cms_header_color');
      if (theme) document.documentElement.className = theme;
      if (headerColor) document.documentElement.classList.add('color-header', headerColor);
    })();
  </script>
</head>

<body>


  <!--start wrapper-->
  <div class="wrapper">
    <!--start top header-->
      <header class="top-header">
        <nav class="navbar navbar-expand gap-3">
          <div class="mobile-toggle-icon fs-3">
              <i class="bi bi-list"></i>
            </div>
            <form class="searchbar">
                <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
                <input class="form-control" type="text" placeholder="Type here to search">
                <div class="position-absolute top-50 translate-middle-y search-close-icon"><i class="bi bi-x-lg"></i></div>
            </form>
            <div class="top-navbar-right ms-auto">
              <ul class="navbar-nav align-items-center">
                <li class="nav-item search-toggle-icon">
                  <a class="nav-link" href="#">
                    <div class="">
                      <i class="bi bi-search"></i>
                    </div>
                  </a>
              </li>
              <li class="nav-item dropdown dropdown-user-setting">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                  <div class="user-setting d-flex align-items-center">
                    <img src="{{ asset('dashboard_assets') }}/images/avatars/avatar-1.png" class="user-img" alt="">
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                     <a class="dropdown-item" href="">
                       <div class="d-flex align-items-center">
                          <img src="{{ asset('dashboard_assets') }}/images/avatars/avatar-1.png" alt="" class="rounded-circle" width="54" height="54">
                          <div class="ms-3">
                            <h6 class="mb-0 dropdown-user-name">{{ auth()->user()->name }}</h6>
                            <small class="mb-0 dropdown-user-designation text-secondary">Created on {{ auth()->user()->created_at->format('F j, Y') }}</small>
                          </div>
                       </div>
                     </a>
                   </li>
                   <li><hr class="dropdown-divider"></li>
                   <li>
                      <a class="dropdown-item" href="">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-person-fill"></i></div>
                           <div class="ms-3"><span>Profile</span></div>
                         </div>
                       </a>
                    </li>
                    <li>
                      <a class="dropdown-item disabled" href="#">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-gear-fill"></i></div>
                           <div class="ms-3"><span>Settings</span></div>
                         </div>
                       </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-lock-fill"></i></div>
                           <div class="ms-3"><span>Logout</span></div>
                         </div>
                       </a>
                    </form>
                    </li>
                </ul>
              </li>
              </ul>
              </div>
        </nav>
      </header>
       <!--end top header-->

        <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true">
          <div class="sidebar-header">
            <div>
              <img src="{{ asset('dashboard_assets') }}/images/favicon-32x32.png" class="logo-icon" alt="logo icon">
            </div>
            <div>
              <h4 class="logo-text">CMS</h4>
            </div>
            <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
            </div>
          </div>
          <!--navigation-->
          <ul class="metismenu" id="menu">
            <li class="menu-label">Menus</li>
            <li>
              <a href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class="bi bi-house-fill"></i>
                </div>
                <div class="menu-title">Dashboard</div>
              </a>
            </li>
            <li>
              <a href="{{ route('case.index') }}">
                <div class="parent-icon"><i class="bi bi-folder-fill"></i>
                </div>
                <div class="menu-title">Case</div>
              </a>
            </li>
            <li class="menu-label">Settings</li>
            <li>
              <a href="{{ route('projecttype.index') }}">
                <div class="parent-icon"><i class="bi bi-briefcase-fill"></i>
                </div>
                <div class="menu-title">Project Type</div>
              </a>
            </li>
            <li>
              <a href="{{ route('status.index') }}">
                <div class="parent-icon"><i class="bi bi-check2-circle"></i>
                </div>
                <div class="menu-title">Status</div>
              </a>
            </li>
          </ul>
          <!--end navigation-->
       </aside>
       <!--end sidebar -->
        <!--start content-->
            <main class="page-content">
                @yield('content')
            </main>
        <!--end page main-->
          <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

       <!--Start Back To Top Button-->
		     <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
       <!--End Back To Top Button-->

       <!--start switcher-->
       <div class="switcher-body">
        <button class="btn btn-primary btn-switcher shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="bi bi-paint-bucket me-0"></i></button>
        <div class="offcanvas offcanvas-end shadow border-start-0 p-2" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling">
          <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Theme Customizer</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
          </div>
          <div class="offcanvas-body">
            <h6 class="mb-0">Theme Variation</h6>
            <hr>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="LightTheme" value="option1" checked>
              <label class="form-check-label" for="LightTheme">Light</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="DarkTheme" value="option2">
              <label class="form-check-label" for="DarkTheme">Dark</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="SemiDarkTheme" value="option3">
              <label class="form-check-label" for="SemiDarkTheme">Semi Dark</label>
            </div>
            <hr>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="MinimalTheme" value="option3">
              <label class="form-check-label" for="MinimalTheme">Minimal Theme</label>
            </div>
            <hr/>
            <h6 class="mb-0">Header Colors</h6>
            <hr/>
            <div class="header-colors-indigators">
              <div class="row row-cols-auto g-3">
                <div class="col">
                  <div class="indigator headercolor1" id="headercolor1"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor2" id="headercolor2"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor3" id="headercolor3"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor4" id="headercolor4"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor5" id="headercolor5"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor6" id="headercolor6"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor7" id="headercolor7"></div>
                </div>
                <div class="col">
                  <div class="indigator headercolor8" id="headercolor8"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
       </div>
       <!--end switcher-->

  </div>
  <!--end wrapper-->


  <!-- Bootstrap bundle JS -->
  <script src="{{ asset('dashboard_assets') }}/js/bootstrap.bundle.min.js"></script>
  <!--plugins-->
  <script src="{{ asset('dashboard_assets') }}/js/jquery.min.js"></script>
  <script src="{{ asset('dashboard_assets') }}/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="{{ asset('dashboard_assets') }}/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="{{ asset('dashboard_assets') }}/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="{{ asset('dashboard_assets') }}/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
  <script src="{{ asset('dashboard_assets') }}/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
  <script src="{{ asset('dashboard_assets') }}/js/pace.min.js"></script>
  <script src="{{ asset('dashboard_assets') }}/plugins/chartjs/js/Chart.min.js"></script>
  <script src="{{ asset('dashboard_assets') }}/plugins/chartjs/js/Chart.extension.js"></script>
  <script src="{{ asset('dashboard_assets') }}/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!--app-->
  <script src="{{ asset('dashboard_assets') }}/js/app.js"></script>
  <script src="{{ asset('dashboard_assets') }}/js/index.js"></script>
  <script>
    new PerfectScrollbar(".best-product")
 </script>
 @yield('scripts')

  <script>
    (function () {
      var COOKIE_DAYS = 365;

      function setCookie(name, value) {
        var expires = new Date(Date.now() + COOKIE_DAYS * 864e5).toUTCString();
        document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/';
      }

      function getCookie(name) {
        var match = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
        return match ? decodeURIComponent(match[1]) : null;
      }

      // Restore radio button to match saved theme
      var themeMap = {
        'light-theme':  'LightTheme',
        'dark-theme':   'DarkTheme',
        'semi-dark':    'SemiDarkTheme',
        'minimal-theme':'MinimalTheme'
      };
      var savedTheme = getCookie('cms_theme');
      if (savedTheme && themeMap[savedTheme]) {
        var radio = document.getElementById(themeMap[savedTheme]);
        if (radio) radio.checked = true;
      }

      // Save theme on radio click
      document.querySelectorAll('input[name="inlineRadioOptions"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
          var classMap = {
            'LightTheme':   'light-theme',
            'DarkTheme':    'dark-theme',
            'SemiDarkTheme':'semi-dark',
            'MinimalTheme': 'minimal-theme'
          };
          var cls = classMap[this.id];
          if (cls) setCookie('cms_theme', cls);
        });
      });

      // Save header color on click
      for (var i = 1; i <= 8; i++) {
        (function (n) {
          var el = document.getElementById('headercolor' + n);
          if (el) el.addEventListener('click', function () {
            setCookie('cms_header_color', 'headercolor' + n);
          });
        })(i);
      }
    })();
  </script>

</body>

</html>
