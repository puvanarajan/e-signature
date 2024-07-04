<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IBaseRepositoryInterface
{
    /**
     * Get all the model records in the database.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Create a new model record in the database.
     *
     * @param array $data The data to create the model record.
     *
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Create one or more new model records in the database.
     *
     * @param array $data The array of data to create multiple model records.
     *
     * @return Collection
     */
    public function createMany(array $data): Collection;

    /**
     * Get the first model that matches the given attributes or create it if not found.
     *
     * @param array $attributes The attributes to find or create the model.
     * @param array $values The default values to set if the model needs to be created.
     *
     * @return Model
     */
    public function firstOrCreate(array $attributes, array $values = []): Model;

    /**
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values = []): Model;

    /**
     * Delete the specified model record from the database.
     *
     * @param mixed $id The identifier of the model to delete.
     *
     * @return bool|null
     *
     * @throws \App\Repositories\Interfaces\Exception
     */
    public function deleteById($id);

    /**
     * Delete the specified model instance.
     *
     * @param Model $model The model instance to delete.
     *
     * @return bool
     */
    public function deleteByObject($model);

    /**
     * Delete multiple records by their IDs.
     *
     * @param array $ids The array of IDs of the records to delete.
     *
     * @return int The number of records deleted.
     */
    public function deleteManyById(array $ids): int;

    /**
     * Delete records by column value.
     *
     * @param string $columnName The column name to search by.
     * @param mixed $value The value to search for.
     * @param string $operator The comparison operator (default: '=').
     * @param bool $forceDelete Whether to force delete the records.
     *
     * @return mixed
     */
    public function deleteByColumn($columnName, $value, $operator = '=', $forceDelete = false);

    /**
     * Get the specified model record from the database.
     *
     * @param mixed $id The identifier of the model to find.
     *
     * @return Model|null
     */
    public function find($id): ?Model;

    /**
     * Update the specified model record in the database.
     *
     * @param mixed $id The identifier of the model to update.
     * @param array $data The data to update the model record.
     *
     * @return Model
     */
    public function updateById($id, array $data): Model;

    /**
     * Update the specified model instance.
     *
     * @param Model $model The model instance to update.
     * @param array $data The data to update the model.
     *
     * @return Model
     */
    public function updateByModelObject(Model $model, array $data): Model;

    /**
     * Find records by column value.
     *
     * @param string $columnName The column name to search by.
     * @param mixed $value The value to search for.
     * @param string $operator The comparison operator (default: '=').
     * @param string|null $orderByColumn The column to order by (optional).
     * @param string $sort The sort direction (default: 'asc').
     * @param array $with Relationships to load with the results.
     *
     * @return Collection
     */
    public function findByColumn($columnName, $value, $operator = '', $orderByColumn = null, $sort = 'asc', $with = []): Collection;

    /**
     * Find records by multiple conditions.
     *
     * @param array $conditions The conditions to search by.
     * @param string|null $orderByColumn The column to order by (optional).
     * @param string $sort The sort direction (default: 'asc').
     * @param array $with Relationships to load with the results.
     *
     * @return Collection
     */
    public function findByConditions(array $conditions, $orderByColumn = null, $sort = 'asc', $with = []): Collection;

    /**
     * Find records by page.
     *
     * @param int $page The page number.
     * @param int $limit The number of records per page.
     * @param array $conditions The conditions to search by.
     * @param string|null $orderByColumn The column to order by (optional).
     * @param string $sort The sort direction (default: 'asc').
     * @param array $with Relationships to load with the results.
     *
     * @return mixed
     */
    public function findByPage($page, $limit, $conditions = [], $orderByColumn = null, $sort = 'asc', $with = []);
}
