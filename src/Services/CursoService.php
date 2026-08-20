<?php
declare(strict_types=1);

require_once __DIR__ . '/../Repositories/CursoRepository.php';

class CursoService
{
    private CursoRepository $repository;

    public function __construct()
    {
        $this->repository = new CursoRepository();
    }

    public function obtenerCursos(): array
    {
        return $this->repository->findAll();
    }
}