<?php

namespace App\UseCases;

interface UseCaseInterface {
    public function getAllByCondition($query = []);

    public function getAll();

    public function find($id);

    public function create($attributes = []);

    public function update($id, $attributes = []);
}