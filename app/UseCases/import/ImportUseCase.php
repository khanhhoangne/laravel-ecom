<?php

namespace App\UseCases\Import;

use App\UseCases\UseCaseInterface;
use App\Repositories\Import\ImportRepositoryInterface;


class ImportUseCase implements UseCaseInterface {

    protected $importRepo;

    public function __construct(ImportRepositoryInterface $importRepo)
    {
        $this->importRepo = $importRepo;
    }

    public function getAllByCondition($query = []) {
        
    }

    public function getAll() {
        // return $this->importRepo->getAllImport()->toArray();
    }

    public function getAllByDate($date, $sort = 'id', $by = 'desc') {
        return $this->importRepo->getAllImport($date, $sort, $by)->toArray();

    }
 
    public function find($id) {
        return $this->importRepo->find($id);
    }

    public function create($attributes = []) {
        $this->importRepo->create($attributes);
    }

    public function update($id, $attributes = []) {
        $this->importRepo->update($id, $attributes);
    }

    public function delete($id) {
        $this->importRepo->delete($id);
    }

    public function getLastIndex() {
        return $this->importRepo->getLastIndex()->toArray();
    }
}