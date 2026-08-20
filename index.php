<?php 
$pageTitle = "Gestión de Participantes | EduPortal";
include_once 'includes/header.php';
include_once 'includes/navbar.php';
?>

<div class="container my-5">
    <!-- Encabezado de Sección y Botón para Agregar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-people-fill text-primary me-2"></i>Gestión de Participantes</h2>
            <p class="text-muted mb-0">Administra las inscripciones, edita información y filtra los registros.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalParticipante" onclick="prepararModalCrear()">
            <i class="bi bi-person-plus-fill me-2"></i>Nuevo Participante
        </button>
    </div>

    <!-- Alertas emergentes -->
    <div id="alertContainer"></div>

    <!-- Tarjeta Principal con Buscador y Tabla -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <!-- Controles de Filtrado -->
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="inputBuscar" class="form-control border-start-0 bg-light" placeholder="Buscar por nombre, email o curso..." onkeyup="filtrarTabla()">
                    </div>
                </div>
                <div class="col-md-4">
                    <select id="selectFiltroCurso" class="form-select bg-light" onchange="filtrarTabla()">
                        <option value="">Todos los cursos</option>
                        <!-- Se poblará dinámicamente -->
                    </select>
                </div>
            </div>

            <!-- Tabla de Participantes -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tablaParticipantes">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>Curso Asignado</th>
                            <th>Fecha Inscripción</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyParticipantes">
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Cargando datos...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Unificado para Crear / Editar Participante -->
<div class="modal fade" id="modalParticipante" tabindex="-1" aria-labelledby="modalParticipanteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalParticipanteLabel">Nuevo Participante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="formParticipante" onsubmit="guardarParticipante(event)">
                <div class="modal-body">
                    <input type="hidden" id="participanteId" name="id">

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" required maxlength="100">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="cursoId" class="form-label fw-semibold">Curso</label>
                        <select class="form-select" id="cursoId" required>
                            <option value="" disabled selected>Seleccione un curso...</option>
                            <!-- Cursos dinámicos desde backend/public/cursos.php -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript para Consumo de Endpoints y UI/UX -->
<script>
    const ENDPOINT_PARTICIPANTES = 'backend/public/participantes.php';[cite: 1]
    const ENDPOINT_CURSOS = 'backend/public/cursos.php';[cite: 1]

    let participantesData = [];
    let cursosData = [];
    let modalInstance = null;

    document.addEventListener('DOMContentLoaded', () => {
        modalInstance = new bootstrap.Modal(document.getElementById('modalParticipante'));
        cargarCursos();
        cargarParticipantes();
    });

    // 1. Cargar catálogo de cursos para los dropdowns
    async function cargarCursos() {
        try {
            const res = await fetch(ENDPOINT_CURSOS);[cite: 1]
            cursosData = await res.json();
            
            const selectModal = document.getElementById('cursoId');
            const selectFiltro = document.getElementById('selectFiltroCurso');

            let optionsModal = '<option value="" disabled selected>Seleccione un curso...</option>';
            let optionsFiltro = '<option value="">Todos los cursos</option>';

            cursosData.forEach(c => {
                optionsModal += `<option value="${c.id}">${c.titulo}</option>`;[cite: 1]
                optionsFiltro += `<option value="${c.titulo}">${c.titulo}</option>`;
            });

            selectModal.innerHTML = optionsModal;
            selectFiltro.innerHTML = optionsFiltro;
        } catch (error) {
            mostrarAlerta('Error al cargar la lista de cursos', 'danger');
        }
    }

    // 2. Obtener y renderizar participantes via GET
    async function cargarParticipantes() {
        try {
            const res = await fetch(ENDPOINT_PARTICIPANTES);[cite: 1]
            participantesData = await res.json();
            renderTabla(participantesData);
        } catch (error) {
            mostrarAlerta('Error al cargar los participantes', 'danger');
        }
    }

    function renderTabla(lista) {
        const tbody = document.getElementById('tbodyParticipantes');
        if (lista.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">No se encontraron participantes.</td></tr>`;
            return;
        }

        tbody.innerHTML = lista.map(p => `
            <tr>
                <td class="fw-bold">#${p.id}</td>[cite: 1]
                <td>${escapeHtml(p.nombre)}</td>[cite: 1]
                <td>${escapeHtml(p.email)}</td>[cite: 1]
                <td><span class="badge bg-primary-subtle text-primary fw-semibold">${escapeHtml(p.curso)}</span></td>[cite: 1]
                <td class="small text-muted">${p.fecha_inscripcion || 'N/A'}</td>[cite: 1]
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-warning me-1" onclick="prepararModalEditar(${p.id})" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="eliminarParticipante(${p.id})" title="Eliminar">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    // 3. Filtrado dinámico client-side
    function filtrarTabla() {
        const texto = document.getElementById('inputBuscar').value.toLowerCase();
        const cursoSeleccionado = document.getElementById('selectFiltroCurso').value;

        const filtrados = participantesData.filter(p => {
            const coincideTexto = p.nombre.toLowerCase().includes(texto) || p.email.toLowerCase().includes(texto);
            const coincideCurso = cursoSeleccionado === '' || p.curso === cursoSeleccionado;
            return coincideTexto && coincideCurso;
        });

        renderTabla(filtrados);
    }

    // 4. Preparar modal para Crear (POST)
    function prepararModalCrear() {
        document.getElementById('modalParticipanteLabel').textContent = 'Nuevo Participante';
        document.getElementById('formParticipante').reset();
        document.getElementById('participanteId').value = '';
    }

    // 5. Preparar modal para Editar (PUT)[cite: 1]
    function prepararModalEditar(id) {
        const participante = participantesData.find(p => p.id === id);
        if (!participante) return;

        document.getElementById('modalParticipanteLabel').textContent = 'Editar Participante';
        document.getElementById('participanteId').value = participante.id;
        document.getElementById('nombre').value = participante.nombre;
        document.getElementById('email').value = participante.email;

        // Mapear el ID del curso según su nombre en el objeto
        const cursoEncontrado = cursosData.find(c => c.titulo === participante.curso);
        if (cursoEncontrado) {
            document.getElementById('cursoId').value = cursoEncontrado.id;
        }

        modalInstance.show();
    }

    // 6. Guardar (Crear o Actualizar mediante POST/PUT)[cite: 1]
    async function guardarParticipante(e) {
        e.preventDefault();
        const id = document.getElementById('participanteId').value;
        const nombre = document.getElementById('nombre').value;
        const email = document.getElementById('email').value;
        const cursoId = parseInt(document.getElementById('cursoId').value);

        const esEdicion = id !== '';
        const method = esEdicion ? 'PUT' : 'POST';[cite: 1]
        
        const payload = { cursoId, nombre, email };
        if (esEdicion) payload.id = parseInt(id);

        try {
            const res = await fetch(ENDPOINT_PARTICIPANTES, {[cite: 1]
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (res.ok) {
                mostrarAlerta(`Participante ${esEdicion ? 'actualizado' : 'registrado'} con éxito.`, 'success');
                modalInstance.hide();
                cargarParticipantes();
            } else {
                mostrarAlerta('Ocurrió un error al procesar la solicitud.', 'danger');
            }
        } catch (error) {
            mostrarAlerta('Error de conexión con el servidor.', 'danger');
        }
    }

    // 7. Eliminar Participante (DELETE)[cite: 1]
    async function eliminarParticipante(id) {
        if (!confirm('¿Está seguro de que desea eliminar este participante?')) return;

        try {
            const res = await fetch(ENDPOINT_PARTICIPANTES, {[cite: 1]
                method: 'DELETE',[cite: 1]
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });

            if (res.ok) {
                mostrarAlerta('Participante eliminado correctamente.', 'warning');
                cargarParticipantes();
            } else {
                mostrarAlerta('No se pudo eliminar el participante.', 'danger');
            }
        } catch (error) {
            mostrarAlerta('Error de comunicación con el servicio.', 'danger');
        }
    }

    // Funciones Auxiliares UI
    function mostrarAlerta(mensaje, tipo) {
        const container = document.getElementById('alertContainer');
        container.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show shadow-sm" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) bootstrap.Alert.getOrCreateInstance(alert).close();
        }, 4000);
    }

    function escapeHtml(str) {
        return str ? str.replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[m]) : '';
    }
</script>

<?php include_once 'includes/footer.php'; ?>