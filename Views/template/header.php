<?php
    if (!class_exists('DenunciaModel')) {
        require_once "Models/DenunciaModel.php";
    }
    
    $modelHeader = new DenunciaModel();
    $notificacionesPendientes = $modelHeader->countPendientes();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Denuncias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <i class="bi bi-bank"></i>
            <span>Municipalidad de Chiclayo</span>
        </div>
        <nav class="sidebar-nav">
            <a href="<?php echo BASE_URL; ?>denuncias">
                <i class="bi bi-grid-fill"></i>
                <span>Denuncias</span>
            </a>
            <a href="<?php echo BASE_URL; ?>denuncias/acerca">
                <i class="bi bi-info-circle-fill"></i>
                <span>Acerca de</span>
            </a>
        </nav>
    </aside>

    <div class="main-content">

        <nav class="topbar">
            <button class="btn btn-light d-md-none" id="toggle-sidebar-btn">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="flex-grow-1"></div>

            <div class="topbar-right">
                
                <div class="topbar-item notification-bell">
                    <i class="bi bi-bell-fill"></i>
                    <?php if ($notificacionesPendientes > 0): ?>
                        <span class="notification-badge">
                            <?= $notificacionesPendientes > 9 ? '9+' : $notificacionesPendientes ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="topbar-item topbar-user">
                    <i class="bi bi-person-circle"></i>
                    <span class="d-none d-sm-inline ms-1">Carlos Cancino</span>
                </div>

            </div>
        </nav>

        <main class="content-area">