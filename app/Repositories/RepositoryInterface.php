<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = []);

    /**
     * Update
     * @param array $conditions
     * @param array $fieldAllows
     * @param array $attributes
     * @return mixed
     */
    public function updateMany($conditions, $fieldAllows = [], $attributes = []);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Delete
     * @param array $conditions
     * @return mixed
     */
    public function removeByCondition($conditions = []);

    // advanced
    /**
     * Find with conditions
     * @param array $conditions
     * @return mixed
     */
    public function findOne($conditions = []);

    /**
     * Find all with conditions, $orderBy, $limit
     * @param array $conditions, array $orderBy, string $limit
     * @return mixed
     */
    public function findByField ($conditions = [], $orderBy = [], $fieldAllows = [], $limit = []);

    /**
     * count all with conditions
     * @param array $conditions
     * @return mixed
     */
    public function countIf ($conditions = [], $fieldAllows = []);

    public function handleConditions($conditions = [],$fieldAllows = [], $query);

    public function handleOrderBy($orderBy = [], $fieldAllows = [], $query);

    public function handleLimit($limit = [], $query);

    public function checkFieldAllow($field, $fieldAllows = []);
    
    public function findByFieldVersionOld ($conditions = [], $orderBy = '', $limit = '', $convert = false);
}