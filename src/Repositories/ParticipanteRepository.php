<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/Database.php';

class ParticipanteRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $sql = "SELECT p.id, p.nombre, p.email, p.fecha_inscripcion, c.titulo AS curso 
                FROM participantes p 
                INNER JOIN cursos c ON p.curso_id = c.id 
                ORDER BY p.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, curso_id, nombre, email FROM participantes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(int $cursoId, string $nombre, string $email): bool
    {
        $sql = "INSERT INTO participantes (curso_id, nombre, email) VALUES (:curso_id, :nombre, :email)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':curso_id' => $cursoId,
            ':nombre'   => $nombre,
            ':email'    => $email
        ]);
    }

    public function update(int $id, int $cursoId, string $nombre, string $email): bool
    {
        $sql = "UPDATE participantes SET curso_id = :curso_id, nombre = :nombre, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'       => $id,
            ':curso_id' => $cursoId,
            ':nombre'   => $nombre,
            ':email'    => $email
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM participantes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}