<?php 
$pageTitle = "Inscripción a Cursos Especializados | EduPortal";
include_once 'includes/header.php';
include_once 'includes/navbar.php';
?>

<!-- Hero Section -->
<section id="inicio" class="bg-primary text-white py-5">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge bg-light text-primary mb-2 fw-semibold">Convocatoria Abierta</span>
                <h1 class="display-5 fw-bold mb-3">Impulsa tu carrera con nuestros cursos especializados</h1>
                <p class="lead mb-4">Inscríbete hoy en nuestros programas diseñados por expertos del sector. Modalidad 100% flexible y certificada.</p>
                <a href="#inscripcion" class="btn btn-light btn-lg text-primary fw-bold me-2 mb-2">Inscribirme ahora</a>
                <a href="#cursos" class="btn btn-outline-light btn-lg mb-2">Ver catálogo</a>
            </div>
            <div class="col-lg-5 text-center">
                <img src="https://picsum.photos/500/350" alt="Estudiantes" class="img-fluid rounded-3 shadow">
            </div>
        </div>
    </div>
</section>

<!-- Catálogo de Cursos -->
<section id="cursos" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Cursos Disponibles</h2>
            <p class="text-muted">Selecciona el programa que mejor se adapte a tus metas profesionales</p>
        </div>

        <div class="row g-4">
            <!-- Curso 1 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="https://picsum.photos/400/200?random=1" class="card-img-top" alt="Curso 1">
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-info text-dark mb-2 w-auto align-self-start">Tecnología</span>
                        <h5 class="card-title fw-bold">Desarrollo Web Full Stack</h5>
                        <p class="card-text text-muted flex-grow-1">Aprende a construir aplicaciones modernas desde cero hasta el despliegue.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <span class="small text-muted"><i class="bi bi-clock me-1"></i>60 Horas</span>
                            <span class="fw-bold text-primary">$120.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Curso 2 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="https://picsum.photos/400/200?random=2" class="card-img-top" alt="Curso 2">
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-warning text-dark mb-2 w-auto align-self-start">Diseño</span>
                        <h5 class="card-title fw-bold">Diseño de Interfaces (UI/UX)</h5>
                        <p class="card-text text-muted flex-grow-1">Domina la creación de prototipos e interfaces centradas en el usuario.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <span class="small text-muted"><i class="bi bi-clock me-1"></i>40 Horas</span>
                            <span class="fw-bold text-primary">$90.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Curso 3 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="https://picsum.photos/400/200?random=3" class="card-img-top" alt="Curso 3">
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-success mb-2 w-auto align-self-start">Gestión</span>
                        <h5 class="card-title fw-bold">Gestión de Proyectos Ágiles</h5>
                        <p class="card-text text-muted flex-grow-1">Implementa metodologías Scrum y Kanban para liderar equipos eficientes.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <span class="small text-muted"><i class="bi bi-clock me-1"></i>30 Horas</span>
                            <span class="fw-bold text-primary">$80.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Formulario de Inscripción -->
<section id="inscripcion" class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold text-center mb-2">Formulario de Inscripción</h3>
                        <p class="text-muted text-center mb-4">Completa tus datos para asegurar tu cupo en el curso de tu elección.</p>

                        <form action="procesar.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-semibold">Nombre completó</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cedula" class="form-label fw-semibold">Identificación / Cédula</label>
                                    <input type="text" class="form-control" id="cedula" name="cedula" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-semibold">Teléfono de contacto</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                                </div>
                                <div class="col-12">
                                    <label for="curso_id" class="form-label fw-semibold">Curso a inscribirse</label>
                                    <select class="form-select" id="curso_id" name="curso_id" required>
                                        <option value="" selected disabled>Selecciona un curso...</option>
                                        <option value="1">Desarrollo Web Full Stack ($120.00)</option>
                                        <option value="2">Diseño de Interfaces (UI/UX) ($90.00)</option>
                                        <option value="3">Gestión de Proyectos Ágiles ($80.00)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terminos" required>
                                        <label class="form-check-label text-muted small" for="terminos">
                                            Acepto los términos, condiciones y políticas de privacidad para la inscripción.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Completar Inscripción</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
include_once 'includes/footer.php';
?>