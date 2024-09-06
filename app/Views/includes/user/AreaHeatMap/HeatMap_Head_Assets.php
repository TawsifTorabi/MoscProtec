  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
  rel="stylesheet"
/>

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

<!-- Core CSS -->
<link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="../assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

<link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

<!-- Page CSS -->

<!-- Helpers -->
<script src="../assets/vendor/js/helpers.js"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="../assets/js/config.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<!-- Include Leaflet Heatmap Plugin -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
<style>
    #map {
        height: 90vh;
        width: 100%;
    }
    .search-container {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            background-color: white;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            width: 300px;
        }
        #location-input {
            width: 100%;
            padding: 5px;
            border-bottom: 2px solid #696cff;
            border-top: none;
            border-left: none;
            border-right: none;
        }
        #suggestions {
            max-height: 150px;
            overflow-y: auto;
            margin-top: 5px;
            border: 1px solid #ddd;
            display: none;
        }
        #suggestions ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        #suggestions ul li {
            padding: 5px;
            cursor: pointer;
        }
        #suggestions ul li:hover {
            background-color: #eee;
        }
</style>

</head>
<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

