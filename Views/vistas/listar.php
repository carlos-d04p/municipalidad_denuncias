<?php
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="page-title-box">
        <h2 class="fw-bold mb-0">Gestión de Denuncias</h2>
        <p class="mb-0"><?= $totalRegistros ?> resultados encontrados</p>
    </div>
    
    <a href="<?= BASE_URL ?>denuncias/crear" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Nueva denuncia
    </a>
</div>

<div class="card shadow-sm p-3 mb-4">
    <form class="row g-2" method="get" action="<?= BASE_URL ?>denuncias">
        
        <div class="col-md">
            <input type="text" name="busqueda" class="form-control" 
                   placeholder="Buscar por título, ciudadano o ubicación..."
                   value="<?= htmlspecialchars($busqueda) ?>">
        </div>
        
        <div class="col-md-3">
            <select name="estado" class="form-select">
                <option value="">Seleccionar estado</option>
                <option value="pendiente" <?= $estado == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                <option value="en proceso" <?= $estado == 'en proceso' ? 'selected' : '' ?>>En proceso</option>
                <option value="resuelto" <?= $estado == 'resuelto' ? 'selected' : '' ?>>Resuelto</option>
            </select>
        </div>

        <div class="col-md-auto">
            <button class="btn btn-primary w-100"><i class="bi bi-search me-2"></i> Buscar</button>
        </div>

    </form>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-nowrap align-middle table-denuncias">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Ciudadano</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($denuncias): ?>
                    <?php foreach ($denuncias as $d): ?>
                    <tr>
                        <td>
                            <span class="fw-bold"><?= $d['id'] ?></span>
                        </td>
                        <td>
                            <span class="fw-semibold"><?= htmlspecialchars($d["titulo"]) ?></span>
                        </td>
                        <td><?= htmlspecialchars($d["ciudadano"]) ?></td>
                        <td><?= htmlspecialchars($d["ubicacion"]) ?></td>
                        <td>
                            <?php
                            $estado_row = strtolower($d["estado"]); // Usamos una variable nueva
                            $badge_class = [
                                "pendiente" => "bg-warning text-dark",
                                "en proceso" => "bg-info text-dark",
                                "resuelto" => "bg-success text-white"
                            ][$estado_row] ?? 'bg-secondary text-white';
                            ?>
                            <span class="badge <?= $badge_class ?>"><?= ucfirst($estado_row) ?></span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($d["fecha_registro"])) ?></td>
                        <td class="text-center">
                            <a href="<?= BASE_URL ?>denuncias/editar/<?= $d['id'] ?>" 
                               class="btn btn-sm btn-primary btn-action" 
                               title="Editar">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="<?= BASE_URL ?>denuncias/eliminar/<?= $d['id'] ?>" 
                               class="btn btn-sm btn-danger btn-action btn-delete" 
                               title="Eliminar">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-exclamation-triangle fs-4 d-block mb-2"></i>
                            No se encontraron datos para tu búsqueda.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php if($totalPaginas > 1): ?>
<nav class="mt-4">
    <ul class="pagination justify-content-center">
        <?php for($p=1; $p <= $totalPaginas; $p++): ?>
        <li class="page-item <?= ($p==$paginaActual) ? 'active' : '' ?>">
            
            <a class="page-link" href="<?= BASE_URL ?>denuncias?busqueda=<?= urlencode($busqueda) ?>&page=<?= $p ?>">
                <?= $p ?>
            </a>
            
        </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>