<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Reservasi Ruang Seduh Coffee</title>
    <!-- Favicon -->
    <link rel="icon" href="<?php echo base_url('assets/img/logo.jpg'); ?>" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/nucleo/css/nucleo.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css'); ?>" type="text/css">
    <!-- Page plugins -->
    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/argon.css?v=1.2.0'); ?>" type="text/css">
</head>

<body>
    <!-- Sidenav -->
    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header  align-items-center">
                <!-- <a class="navbar-brand" href="javascript:void(0)"> -->
                <img src="<?php echo base_url('assets/img/logo.jpg') ?>" width="90">
                <!-- <p class="text-primary"><b>RESERVASI</b></p> -->
                <!-- </a> -->
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?= $this->Model->getPage('admin') ?>" href="<?= base_url('admin/') ?>">
                                <i class="ni ni-tv-2 <?= $this->Model->getPage('admin', 'icon') ?>"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->
                    <h6 class="navbar-heading p-0 text-muted">
                        <span class="docs-normal">Master Data</span>
                    </h6>
                    <!-- Navigation -->
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?= $this->Model->getPage('customer') ?>" href="<?= base_url('admin/customer') ?>">
                                <i class="fa fa-users <?= $this->Model->getPage('customer', 'icon') ?>"></i>
                                <span class="nav-link-text">Data Customer</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $this->Model->getPage('order') ?>" href="<?= base_url('admin/order') ?>">
                                <i class="ni ni-cart <?= $this->Model->getPage('order', 'icon') ?>"></i>
                                <span class="nav-link-text">Data Order</span>
                            </a>
                        </li>

                    </ul>
                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->
                    <h6 class="navbar-heading p-0 text-muted">
                        <span class="docs-normal">Pengaturan</span>
                    </h6>
                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?= $this->Model->getPage('meja') ?>" href="<?= base_url('admin/meja') ?>">
                                <i class="fa fa-table <?= $this->Model->getPage('meja', 'icon') ?>"></i>
                                <span class="nav-link-text">Meja</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout') ?>">
                                <i class="ni ni-button-power text-primary"></i>
                                <span class="nav-link-text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center  ml-md-auto ">
                        <li class="nav-item d-xl-none">
                            <!-- Sidenav toggler -->
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                        <span class="nav-item d-xl-none mb-0 text-sm text-white font-weight-bold"><b>Sistem Reservasi Ruang Seduh Coffee</b></span>
                    </ul>
                    <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <!-- <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="<?= base_url('assets/img/user.png') ?>">
                  </span> -->
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">Administrator</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right ">
                                <!-- <a href="<?= base_url('admin/akun') ?>" class="dropdown-item">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <span>Settings</span>
                                </a> -->
                                <a href="<?= base_url('logout') ?>" class="dropdown-item">
                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->