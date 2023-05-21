<html>
    <head>
        <title><?php echo esc($title); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url('bootstrap/bootstrap.min.css'); ?>">
        <script src="<?php echo base_url('bootstrap/bootstrap.bundle.min.js'); ?>"></script>
    </head>
    <body>
        <?php if (empty($blank)): ?>
            <div class="d-flex flex-column" style="min-height: 100vh">
                <nav class="navbar navbar-expand-lg bg-light mb-3">
                    <div class="container">
                        <a class="navbar-brand" href="<?php echo url_to('home'); ?>">JMPL-AUTH</a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-content">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbar-content">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo url_to('home'); ?>">Home</a>
                                </li>
                                <?php if (session()->has('auth')): ?>
                                    <li class="nav-item">
                                        <a class="nav-link link-danger" href="<?php echo url_to('user.logout'); ?>" onclick="return confirm('Apakah anda yakin?')">Logout</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="flex-grow-1 container">
        <?php endif; ?>
