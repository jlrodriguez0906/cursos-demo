<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/Database.php';

class CursoRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db::query("SELECT id, titulo, descripcion, fecha_inicio, estado FROM cursos ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, titulo, descripcion, fecha_inicio, estado FROM cursos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}