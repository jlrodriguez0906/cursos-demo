<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../src/Services/CursoService.php';

try {
    $service = new CursoService();
    echo json_encode([
        'status' => 'success',
        'data' => $service->obtenerCursos()
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error interno en el servidor.'
    ]);
}