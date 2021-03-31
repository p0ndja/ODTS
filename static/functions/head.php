    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Google Font -->
    <link href="//fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet"/>
    <link href="//fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Webcustom -->
    <link rel="apple-touch-icon" sizes="57x57" href="../static/elements/logo/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../static/elements/logo/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../static/elements/logo/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../static/elements/logo/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../static/elements/logo/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../static/elements/logo/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../static/elements/logo/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../static/elements/logo/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../static/elements/logo/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../static/elements/logo/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../static/elements/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../static/elements/logo/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../static/elements/logo/favicon-16x16.png">
    <link rel="manifest" href="../static/elements/logo/manifest.json">
    <meta name="msapplication-TileColor" content="#1d7b25">
    <meta name="msapplication-TileImage" content="../static/elements/logo/ms-icon-144x144.png">
    <meta name="theme-color" content="#1d7b25">

    <?php $head_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; $current_url =  $head_url . "$_SERVER[REQUEST_URI]"; ?>
<meta property="og:image" content="<?php echo $head_url; ?>/static/elements/logo/logo.jpg" />
    <meta property="og:image:width" content="194" />
    <meta property="og:image:height" content="194" />
    <meta property="og:title" content="ระบบติดตามเอกสาร" />
    <title>ระบบติดตามเอกสาร - งานเภสัชกรรม โรงพยาบาลศรีนครินทร์</title>
    <meta property="og:description" content="งานเภสัชกรรม โรงพยาบาลศรีนครินทร์" />
    <meta name="twitter:card" content="summary"></meta>
    <link rel="image_src" href="<?php echo $head_url; ?>/static/elements/banner_th.jpg" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $current_url; ?>" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../vendor/bootstrap/bootstrap.min.css">
    <link href="../vendor/mdbootstrap/mdb.min.css" rel="stylesheet">
    
    <!-- Custom Style -->
    <link href="../static/style.css" rel="stylesheet">
    <link href="../static/dark-mode.css" rel="stylesheet">
    <link href="../static/simple-sidebar.css" rel="stylesheet">
    <?php if (isDarkmode()) { ?><link href="../static/dataTable-dark-mode.css" rel="stylesheet"><?php } ?>
    
    <!-- Bootstrap -->
    <script src="../vendor/1.16.0-popper.min.js"></script>
    <script src="../vendor/jquery-3.5.1.min.js"></script>
    <script src="../vendor/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="../vendor/mdbootstrap/mdb.min.js"></script>

    <!-- Bootstrap-DateTimePicker-Table -->
    <link rel="stylesheet" href="../vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
    <script src="../vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>

    <!-- Bootstrap-Table -->
    <link href="../vendor/dataTable/jquery.dataTables.min.css" rel="stylesheet">
    <script src="../vendor/dataTable/jquery.dataTables.min.js"></script>

    <!-- Editor.MD -->
    <link rel="stylesheet" href="../vendor/editor.md/css/editormd.css" />
    <script src="../vendor/editor.md/editormd.min.js"></script>
    <script src="../vendor/editor.md/languages/en.js"></script>

    <!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
    
    <!-- SweetAlert -->
    <script src="../vendor/sweetalert.min.js"></script>
    
    <!-- Croppie -->
    <link rel="stylesheet" href="../vendor/croppie/croppie.css" />
    <script src="../vendor/croppie/croppie.js"></script>

    <!-- Dropzone -->
    <link rel="stylesheet" href="../vendor/dropzone/min/basic.min.css" />
    <link rel="stylesheet" href="../vendor/dropzone/min/dropzone.min.css" />
    <script src="../vendor/dropzone/dropzone.js"></script>
    
    <!-- Fontawesome -->
    <link href="../vendor/fontawesome/css/all.min.css" rel="stylesheet" />