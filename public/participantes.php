<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../src/Services/ParticipanteService.php';

$method = $_SERVER['REQUEST_METHOD'];
$service = new ParticipanteService();

try {
    switch ($method) {
        case 'GET':
            echo json_encode(['status' => 'success', 'data' => $service->listar()]);
            break;

        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $service->registrar(
                (int) ($input['curso_id'] ?? 0),
                (string) ($input['nombre'] ?? ''),
                (string) ($input['email'] ?? '')
            );
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'Participante registrado.']);
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
            $service->actualizar(
                (int) ($input['id'] ?? 0),
                (int) ($input['curso_id'] ?? 0),
                (string) ($input['nombre'] ?? ''),
                (string) ($input['email'] ?? '')
            );
            echo json_encode(['status' => 'success', 'message' => 'Participante actualizado.']);
            break;

        case 'DELETE':
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
            $service->eliminar((int) ($input['id'] ?? 0));
            echo json_encode(['status' => 'success', 'message' => 'Participante eliminado.']);
            break;

        default:
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
            break;
    }
} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Error interno en el servidor.']);
}