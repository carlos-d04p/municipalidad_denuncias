<?php
$errores = $_SESSION["errores"] ?? [];
$datos = $_SESSION["datos"] ?? [];
unset($_SESSION["errores"]);
unset($_SESSION["datos"]);

$fecha_actual = $datos['fecha_registro'] ?? date('Y-m-d\TH:i');
?>

<div class="row justify-content-center">
<div class="col-lg-10">
    <div class="d-flex align-items-center mb-3">
        <a href="<?= BASE_URL ?>denuncias" class="btn btn-light me-3 p-2 rounded-circle lh-1"><i class="bi bi-arrow-left fs-5"></i></a>
        <h2 class="fw-bold mb-0">Nueva denuncia</h2>
    </div>

    <div class="card p-4 p-md-5 shadow-sm">
        
        <form method="post" action="<?= BASE_URL ?>denuncias/guardar" class="row g-3 needs-validation" id="denuncia-form" novalidate>

            <div class="col-md-6">
                <label for="titulo" class="form-label fw-semibold">Título</label>
                <input type="text" name="titulo" id="titulo"
                       class="form-control <?php echo isset($errores['titulo']) ? 'is-invalid' : ''; ?>"
                       value="<?= htmlspecialchars($datos['titulo'] ?? '') ?>"
                       placeholder="Ej: Poste de luz caído" required minlength="5" maxlength="100">
                <div class="invalid-feedback" id="error-titulo">
                    <?= $errores['titulo'] ?? 'Debe tener entre 5 y 100 caracteres.' ?>
                </div>
            </div>

            <div class="col-md-6">
                <label for="ciudadano" class="form-label fw-semibold">Ciudadano</label>
                <input type="text" name="ciudadano" id="ciudadano"
                       class="form-control <?php echo isset($errores['ciudadano']) ? 'is-invalid' : ''; ?>"
                       value="<?= htmlspecialchars($datos['ciudadano'] ?? '') ?>"
                       placeholder="Ej: Carlos Cancino Vilchez" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+">
                <div class="invalid-feedback" id="error-ciudadano">
                    <?= $errores['ciudadano'] ?? 'Solo se permiten letras y espacios.' ?>
                </div>
            </div>

            <div class="col-md-6">
                <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                <input type="tel" name="telefono_ciudadano" id="telefono"
                       class="form-control <?php echo isset($errores['telefono_ciudadano']) ? 'is-invalid' : ''; ?>"
                       value="<?= htmlspecialchars($datos['telefono_ciudadano'] ?? '') ?>"
                       placeholder="Ej: 987654321" required pattern="[0-9]{9}">
                <div class="invalid-feedback" id="error-telefono">
                    <?= $errores['telefono_ciudadano'] ?? 'Debe tener 9 dígitos numéricos.' ?>
                </div>
            </div>

            <div class="col-md-6">
                <label for="ubicacion" class="form-label fw-semibold">Ubicación</label>
                <input type="text" name="ubicacion" id="ubicacion"
                       class="form-control <?php echo isset($errores['ubicacion']) ? 'is-invalid' : ''; ?>"
                       value="<?= htmlspecialchars($datos['ubicacion'] ?? '') ?>"
                       placeholder="Ej: Av. Balta 123, frente al parque" required minlength="5" maxlength="150">
                <div class="invalid-feedback" id="error-ubicacion">
                    <?= $errores['ubicacion'] ?? 'Debe tener entre 5 y 150 caracteres.' ?>
                </div>
            </div>

            <div class="col-12">
                <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control <?php echo isset($errores['descripcion']) ? 'is-invalid' : ''; ?>"
                          rows="4" placeholder="Ej: Describe brevemente el problema..."
                          required minlength="10" maxlength="255"><?= htmlspecialchars($datos['descripcion'] ?? '') ?></textarea>
                <div class="invalid-feedback" id="error-descripcion">
                    <?= $errores['descripcion'] ?? 'Debe tener entre 10 y 255 caracteres.' ?>
                </div>
            </div>

            <div class="col-md-6">
                <label for="estado" class="form-label fw-semibold">Estado</label>
                <select name="estado" id="estado" class="form-select <?php echo isset($errores['estado']) ? 'is-invalid' : ''; ?>" required>
                    <option value="pendiente" <?= ($datos['estado'] ?? 'pendiente') == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="en proceso" <?= ($datos['estado'] ?? '') == 'en proceso' ? 'selected' : '' ?>>En proceso</option>
                    <option value="resuelto" <?= ($datos['estado'] ?? '') == 'resuelto' ? 'selected' : '' ?>>Resuelto</option>
                </select>
                <div class="invalid-feedback" id="error-estado">
                    <?= $errores['estado'] ?? 'Debe seleccionar un estado.' ?>
                </div>
            </div>

            <div class="col-md-6">
                <label for="fecha" class="form-label fw-semibold">Fecha y Hora</label>
                <input type="datetime-local" name="fecha_registro" id="fecha"
                       class="form-control <?php echo isset($errores['fecha_registro']) ? 'is-invalid' : ''; ?>"
                       value="<?= htmlspecialchars($fecha_actual) ?>" required>
                <div class="invalid-feedback" id="error-fecha">
                    <?= $errores['fecha_registro'] ?? 'La fecha y hora son obligatorias.' ?>
                </div>
            </div>

            <div class="col-12 d-flex gap-2 mt-4">
                <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle me-2"></i>Guardar</button>
                <a href="<?= BASE_URL ?>denuncias" class="btn btn-secondary"><i class="bi bi-x-circle me-2"></i>Cancelar</a>
            </div>
        </form>
    </div>
</div>
</div>