<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start Your OKR With OKRE System">
  <meta name="author" content="Creative Tim">
  <title><?= $title; ?></title>
  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('assets/'); ?>img/logo_web.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">


  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/fixedColumns.dataTables.min.css">

  <!-- Page plugins -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/argon.css?v=1.2.0" type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/style.css">
  <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css" />

  <script src="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.umd.js"></script>


  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.js"></script>
  <!-- <script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script> -->

  <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>

  <!-- <link rel="stylesheet" href="<?= base_url('assets/cssscroll/mobiscroll.javascript.min.css'); ?>" rel="stylesheet" /> -->

  <script src="https://www.gstatic.com/firebasejs/8.6.5/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.6.5/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.6.5/firebase-firestore.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.6.5/firebase-messaging.js"></script>

  <style>

#mysignature {
        position: absolute;
        border: 1px dashed #000;
        width: 100px;
        height: 50px;
    }
    
    
    #pdf-container {
        overflow-x: auto; /* Tambahkan scrollbar horizontal jika diperlukan */
        overflow-y: auto; /* Tambahkan scrollbar vertikal jika diperlukan */
        margin: 0 auto; /* Tengah secara horizontal jika diperlukan */
        width: 100%; /* Pastikan kontainer mengambil lebar penuh */
        box-sizing: border-box; /* Sertakan padding dan border dalam total width dan height */
       
    }
    .pdf-page {
        border-style: ridge;
        position: relative;
        border-top: 4px solid #5e72e4;
        border-left: 4px solid #5e72e4;
        border-bottom: 4px solid #5e72e4;
        border-right: 4px solid #5e72e4;
        margin-bottom: 2px;
        margin-right: 2px;
        box-sizing: border-box;
        max-width: 100%; /* Pastikan halaman tidak melebar dari kontainer */
    }

    @media screen and (max-width: 800px) {
        .pdf-page {
          width: 420px; /* The width is 100%, when the viewport is 800px or smaller */
        }
        #pdf-container {
          width: 420px;
        }
      }

    #the-canvas {
      direction: ltr;
    }

    /* .signature.no-touch {
    touch-action: none;
} */
        
        .signature {
          position: absolute; /* Pastikan posisi absolut atau relatif */
          z-index: 10000; /* Pastikan z-index tinggi */
          cursor: move;
          border: 1px dashed #ffffff;
          max-width: 100%;
        }
        
        .insignature {
          height:100px; /* Menetapkan posisi relatif untuk elemen induk */
        }

        .signature.dragging,
        .signature.resizing {
            border: 2px dashed #ffffff;
        }
        .padding-edit{
          padding: 3.9em
        }

        .signature-border {
            border: 2px dashed #ffffff;
        }

        .signature-modal {
          display: none; /* Modal tidak terlihat pada awalnya */
          position: fixed;
          z-index: 1000;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
        
          background-color: rgba(0,0,0,0.5); /* Background hitam transparan */
          opacity: 0; /* Set opacity to 0 for smooth fade in/out */
          transition: opacity 0.3s ease; /* Transisi untuk opacity */
      }

      .signature-modal-content {
        background-color: #ffffff;
        margin: 38% auto;
        padding: 20px;
        border: 1px solid #ffffff;
        width: 80%;
        max-width: 500px;
        position: relative;
        transform: translateY(-30px); /* Awal posisi sedikit di atas */
        transition: transform 0.3s ease; /* Transisi untuk pergerakan vertikal */
      }

      @media screen and (max-width: 800px) {
        .signature-modal-content {
          margin: 55% auto;
        }
      }

      .modal-button {
          background-color: #4CAF50;
          color: white;
          padding: 10px 20px;
          margin: 10px;
          border: none;
          cursor: pointer;
      }

      .modal-button:hover {
          background-color: #45a049;
      }

      .signature-close {
        color: #fff;
        float: right;
        font-size: 28px;
        font-weight: bold;

      }

      .signature-close:hover,
      .signature-close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
      }

      .signature-modal.show {
          display: block;
          opacity: 1;
      }

      .signature-modal-content.show {
          transform: translateY(0);
      }

      .berderet {
          display: flex;
          align-items: center; /* Vertically center items */
          gap: 10px; /* Space between items */
      }
    </style>


  
  <style>
   .cke_chrome{
      /* border-radius: 10px; */
      border: 0.1px solid #e9ecef !important; 
      border-width: thin !important;        
    }

    .cke_top{
        border-radius: 10px 10px 0px 0px;
    }

    .cke_bottom{
        border-radius: 0px 0px 10px 10px;
    }

    .btnstyle {
      margin-left:15px;
      border: none;
      background: none;
    }

    .hidden-content {
        display: none;
    }
    .visible-content {
        display: block;
    }
    .button-container {
        display: grid;
        place-items: center;
    }

    .doughnutChartContainer {
      margin: auto;
      padding: 0;
    }

    .style-toggle {
            display: flex;
            /* justify-content: space-between; */
            margin-bottom: 20px;
            margin-left: 2px
        }

        .style-toggle label {
            cursor: pointer;
            padding: 10px 20px;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .style-toggle input[type="radio"] {
            display: none;
        }

        .style-toggle input[type="radio"]:checked + label {
            background-color: #172b4d;
            color: #fff;
            border-color: #172b4d;
        }
        .badge-counter {
    position: absolute;
    top: 8px;
    right: 8px;
    padding: 5px 10px;
    border-radius: 50%;
    background-color: red;
    color: white;
    font-size: 12px;
}
  </style>
</head>



<body>

  <div id="overlay">
    <div class="cv-spinner">
      <span class="spinner"></span>
    </div>
  </div>

