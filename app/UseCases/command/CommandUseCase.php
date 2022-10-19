<?php

namespace App\UseCases\Command;

use App\UseCases\UseCaseInterface;
use App\Repositories\Command\CommandRepositoryInterface;

class CommandUseCase implements UseCaseInterface {

    protected $commandRepo;

    public function __construct(CommandRepositoryInterface $commandRepo)
    {
        $this->commandRepo = $commandRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        return $this->commandRepo->getAll();
    }

    public function find($id) {
        return $this->commandRepo->find($id);
    }

    public function create($attributes = []) {
       return $this->commandRepo->create($attributes);
    }

    public function update($id, $attributes = []) {
        return $this->commandRepo->update($id, $attributes);
    }

    public function delete($id) {
        $this->commandRepo->delete($id);
    }
    
    public function getCommand($conditions = []) {
        return $this->commandRepo->findOne($conditions);
    }
}