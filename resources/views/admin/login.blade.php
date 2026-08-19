<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrador — Moda & Boutique</title>
    <!-- Google Fonts & Bootstrap Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Modern Fashion Stylesheet -->
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-6 col-lg-4">

                <!-- Glass Login Card -->
                <div class="form-card animate-fade-in p-4 p-sm-5 text-center">

                    <!-- Brand Icon Box -->
                    <div class="d-inline-flex align-items-center justify-content-center brand-icon-box mb-3" style="width: 58px; height: 58px; font-size: 1.8rem;">
                        <i class="bi bi-shield-lock"></i>
                    </div>

                    <h2 class="font-heading fs-3 fw-bold text-dark mb-1">Acceso Boutique</h2>
                    <p class="text-secondary small mb-4">Ingresa tus credenciales para gestionar el catálogo y prendas.</p>

                    <!-- Error Alert -->
                    @if($errors->any())
                        <div class="alert-modern-danger text-start mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-octagon-fill"></i>
                                <span>{{ $errors->first() }}</span>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="text-start">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label class="form-label-modern">
                                <i class="bi bi-envelope text-secondary"></i> Correo Electrónico
                            </label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control-modern"
                                   placeholder="admin@boutique.com"
                                   required
                                   autofocus>
                        </div>

                        <!-- Password Input with Toggle Visibility -->
                        <div class="mb-4">
                            <label class="form-label-modern">
                                <i class="bi bi-key text-secondary"></i> Contraseña
                            </label>
                            <div class="position-relative">
                                <input type="password"
                                       name="password"
                                       id="passwordInput"
                                       class="form-control-modern pe-5"
                                       placeholder="••••••••"
                                       required>
                                <button type="button"
                                        id="togglePasswordBtn"
                                        class="btn position-absolute top-50 end-0 translate-middle-y text-muted border-0 me-2"
                                        style="background: transparent;"
                                        title="Mostrar u ocultar contraseña">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-gradient-primary w-100 py-3 mb-3">
                            <i class="bi bi-box-arrow-in-right fs-5"></i>
                            <span>Ingresar al Sistema</span>
                        </button>

                        <div class="text-center pt-2">
                            <a href="{{ route('productos.index') }}" class="text-secondary small text-decoration-none hover-white">
                                <i class="bi bi-arrow-left"></i> Volver a la tienda
                            </a>
                        </div>
                    </form>

                    <!-- Security Pill -->
                    <div class="mt-4 pt-3 border-top border-light-subtle text-center">
                        <span class="small text-muted d-inline-flex align-items-center gap-1">
                            <i class="bi bi-shield-fill-check text-success"></i> Acceso Cifrado y Protegido SSL
                        </span>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Password Visibility Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('passwordInput');
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            if (togglePasswordBtn && passwordInput && togglePasswordIcon) {
                togglePasswordBtn.addEventListener('click', () => {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    togglePasswordIcon.classList.toggle('bi-eye', !isPassword);
                    togglePasswordIcon.classList.toggle('bi-eye-slash', isPassword);
                });
            }
        });
    </script>
</body>
</html>