<?php
declare(strict_types=1);

require_once __DIR__ . '/../Repositories/ParticipanteRepository.php';
require_once __DIR__ . '/../Repositories/CursoRepository.php';

class ParticipanteService
{
    private ParticipanteRepository $participanteRepo;
    private CursoRepository $cursoRepo;

    public function __construct()
    {
        $this->participanteRepo = new ParticipanteRepository();
        $this->cursoRepo = new CursoRepository();
    }

    public function listar(): array
    {
        return $this->participanteRepo->findAll();
    }

    public function registrar(int $cursoId, string $nombre, string $email): bool
    {
        $this->validarDatos($cursoId, $nombre, $email);
        return $this->participanteRepo->create($cursoId, trim($nombre), trim($email));
    }

    public function actualizar(int $id, int $cursoId, string $nombre, string $email): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("ID inválido.");
        }
        $this->validarDatos($cursoId, $nombre, $email);
        return $this->participanteRepo->update($id, $cursoId, trim($nombre), trim($email));
    }

    public function eliminar(int $id): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("ID inválido.");
        }
        return $this->participanteRepo->delete($id);
    }

    private function validarDatos(int $cursoId, string $nombre, string $email): void
    {
        if (empty(trim($nombre)) || mb_strlen($nombre) > 100) {
            throw new InvalidArgumentException("El nombre es obligatorio y no debe superar 100 caracteres.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("El formato del correo electrónico no es válido.");
        }
        if (!$this->cursoRepo->findById($cursoId)) {
            throw new InvalidArgumentException("El curso especificado no existe.");
        }
    }
}