<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar {{ $producto->nombre }} — Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
</head>
<body>

    <nav class="glass-nav py-3 mb-5">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('productos.index') }}" class="navbar-brand-logo">
                <div class="brand-icon-box">
                    <i class="bi bi-bag-heart"></i>
                </div>
                <div>
                    <h2 class="brand-title">MODA & BOUTIQUE</h2>
                    <p class="brand-subtitle">Panel Administrativo</p>
                </div>
            </a>

            <a href="{{ route('productos.index') }}" class="btn btn-glass btn-sm">
                <i class="bi bi-arrow-left"></i>
                <span>Volver a la Tienda</span>
            </a>
        </div>
    </nav>

    <main class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="form-card animate-fade-in">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-circle bg-light text-dark mb-3 border shadow-sm">
                            <i class="bi bi-pencil-square fs-3"></i>
                        </div>
                        <h2 class="font-heading fs-3 fw-bold text-dark mb-1">Editar Prenda</h2>
                        <p class="text-secondary small">Actualiza la información, precio o fotografía de la prenda.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert-modern-danger mb-4">
                            <div class="d-flex align-items-center gap-2 mb-1 fw-bold">
                                <i class="bi bi-exclamation-triangle-fill"></i> Errores de Validación:
                            </div>
                            <ul class="mb-0 ps-3 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($producto->imagen)
                        <div class="mb-4 p-3 rounded-3" style="background: #f8f8f7; border: 1px solid rgba(0,0,0,0.08);">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-secondary fw-semibold">Foto actual de la prenda:</span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Activa</span>
                            </div>
                            <img src="{{ asset('storage/' . $producto->imagen) }}"
                                 class="img-fluid rounded-3 w-100"
                                 style="max-height: 200px; object-fit: cover;"
                                 alt="{{ $producto->nombre }}">
                        </div>
                    @endif

                    <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data" id="editProductForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label-modern">
                                <i class="bi bi-tag text-secondary"></i> Nombre de la Prenda <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="nombre"
                                   value="{{ old('nombre', $producto->nombre) }}"
                                   class="form-control-modern"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-modern">
                                <i class="bi bi-card-text text-secondary"></i> Descripción y Detalles de la Tela
                            </label>
                            <textarea name="descripcion"
                                      class="form-control-modern"
                                      rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">
                                <i class="bi bi-currency-dollar text-secondary"></i> Precio (S/) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border text-dark fw-bold">S/</span>
                                <input type="number"
                                       step="0.01"
                                       min="0"
                                       name="precio"
                                       value="{{ old('precio', $producto->precio) }}"
                                       class="form-control-modern"
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">
                                <i class="bi bi-camera text-secondary"></i> Cambiar Fotografía (Opcional)
                            </label>

                            <div class="dropzone-upload" id="dropzoneBox" onclick="document.getElementById('imagenInput').click();">
                                <input type="file"
                                       name="imagen"
                                       id="imagenInput"
                                       accept="image/*"
                                       class="d-none">

                                <div id="dropzonePrompt">
                                    <div class="dropzone-icon">
                                        <i class="bi bi-cloud-arrow-up text-dark"></i>
                                    </div>
                                    <div class="text-dark fw-bold small mb-1">Haz clic para reemplazar la foto actual</div>
                                    <div class="text-muted" style="font-size: 0.78rem;">Deja vacío si deseas conservar la imagen actual</div>
                                </div>

                                <div class="image-preview-wrapper mt-3" id="previewContainer">
                                    <img src="#" alt="Nueva Imagen" id="imagePreview">
                                    <div class="text-center mt-2">
                                        <span class="badge bg-light border text-dark small" id="imageNameBadge">Nueva foto seleccionada</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-gradient-primary w-100 py-3 mb-3">
                            <i class="bi bi-check2-circle fs-5"></i>
                            <span>Guardar Cambios</span>
                        </button>

                        <a href="{{ route('productos.index') }}" class="d-block text-center text-secondary small text-decoration-none">
                            ← Cancelar y volver al catálogo
                        </a>
                    </form>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imagenInput = document.getElementById('imagenInput');
            const dropzoneBox = document.getElementById('dropzoneBox');
            const dropzonePrompt = document.getElementById('dropzonePrompt');
            const previewContainer = document.getElementById('previewContainer');
            const imagePreview = document.getElementById('imagePreview');
            const imageNameBadge = document.getElementById('imageNameBadge');

            if (!imagenInput) return;

            const mostrarPreview = (file) => {
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (event) => {
                    imagePreview.src = event.target.result;
                    previewContainer.style.display = 'block';
                    imageNameBadge.textContent = 'Nueva imagen: ' + file.name;
                    dropzonePrompt.classList.add('d-none');
                };
                reader.readAsDataURL(file);
            };

            imagenInput.addEventListener('change', () => mostrarPreview(imagenInput.files[0]));

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzoneBox.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dropzoneBox.classList.add('dragover');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzoneBox.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dropzoneBox.classList.remove('dragover');
                });
            });

            dropzoneBox.addEventListener('drop', (e) => {
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    imagenInput.files = files;
                    mostrarPreview(files[0]);
                }
            });
        });
    </script>
</body>
</html>