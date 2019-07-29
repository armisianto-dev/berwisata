<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="id">
<head>
  <title>iPangan API Dokumentasi</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="initial-scale=1, shrink-to-fit=no, width=device-width" name="viewport">
  <link href="<?= base_url('resource/images/favicon.gif') ?>" rel="shortcut icon" />
  <!-- CSS -->
  <!-- Add Material font (Roboto) and Material icon as needed -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i|Roboto+Mono:300,400,700|Roboto+Slab:300,400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Add Material CSS, replace Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="<?= base_url('resource/themes/material-4.1.1/css/material.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('resource/themes/style.css') ?>">
</head>
<body>
  <nav class="navbar navbar-fluid navbar-expand-sm fixed-top"
  style="background-color: white; opacity: 0.9; border-bottom: 1px solid rgba(0,0,0,.12)"
  >
  <div class="container">
    <a class="navbar-brand" href="#">
      <img class="navbar-nav ml-auto mr-20" src="<?= base_url('resource/images/logo_ipangan.png') ?>" alt="iPangan" width="100">
      <span style="margin-left: 17px;margin-top: 14px;">iPangan API Dokumentasi</span>
    </a>
  </div>
</nav>
<div class="container" style="margin-top:30px; margin-bottom: 30px">
  <div class="row">
    <div class="col-sm-4 col-md-3 sidebar-fixed" style="max-width: 23%">
      <ul class="nav nav-pills flex-column">
        <?php foreach($rs_menu as $i=>$menu) { ?>
          <li class="nav-item">
            <a class="nav-link" style="color: #ff5252; font-weight: 400" href="#<?= $menu['nav_url'] ?>">
              <i class="m-r-5 <?= $menu['nav_icon'] ?> fa-fw" data-icon="<?= $menu['data_icon'] ?>"></i> <?= $menu['nav_title'] ?>
            </a>
            <?php foreach($menu['rs_child'] as $child) { ?>
              <a class="nav-link nav-link-child pl-4 py-2 text-black-secondary" href="<?= site_url($child['nav_url']) ?>"><?= $child['nav_title'] ?></a>
            <?php } ?>
          </li>
        <?php } ?>
      </ul>
      <hr class="d-sm-none">
    </div>
    <div class="col-sm-8 col-md-9 content-fixed">
      <div class="row">
        <div id="dynamic-content" class="col-12">

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<!-- Then Material JavaScript on top of Bootstrap JavaScript -->
<script src="<?= base_url('resource/themes/material-4.1.1/js/material.min.js') ?>"></script>
</body>
</html>
