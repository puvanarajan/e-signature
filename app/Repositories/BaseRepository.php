<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IBaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 *
 * This class provides a base implementation for the repository pattern.
 */
class BaseRepository implements IBaseRepositoryInterface
{
    /**
     * The repository model.
     *
     * @var Model
     */
    protected Model $model;

    /**
     * Get all the model records in the database.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Create a new model record in the database.
     *
     * @param array $data The data to create the model record.
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Create one or more new model records in the database.
     *
     * @param array $data The array of data to create multiple model records.
     *
     * @return Collection
     */
    public function createMany(array $data): Collection
    {
        $models = new Collection();

        foreach ($data as $d) {
            $models->push($this->create($d));
        }

        return $models;
    }

    /**
     * Get the first model that matches the given attributes or create it if not found.
     *
     * @param array $attributes The attributes to find or create the model.
     * @param array $values The default values to set if the model needs to be created.
     *
     * @return Model
     */
    public function firstOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model->firstOrCreate($attributes, $values);
    }

    /**
     * Get the first model that matches the given attributes or create it if not found.
     *
     * @param array $attributes The attributes to find or create the model.
     * @param array $values The default values to set if the model needs to be created.
     *
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * Delete the specified model record from the database.
     *
     * @param mixed $id The identifier of the model to delete.
     *
     * @return bool|null
     */
    public function deleteById($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Delete the specified model instance.
     *
     * @param Model $model The model instance to delete.
     *
     * @return mixed
     */
    public function deleteByObject($model)
    {
        return $model->delete();
    }

    /**
     * Delete multiple records by their IDs.
     *
     * @param array $ids The array of IDs of the records to delete.
     *
     * @return int The number of records deleted.
     */
    public function deleteManyById(array $ids): int
    {
        return $this->model->destroy($ids);
    }

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
    public function deleteByColumn($columnName, $value, $operator = '=', $forceDelete = false)
    {
        $query = $this->model->where($columnName, $operator, $value);
        return $forceDelete ? $query->forceDelete() : $query->delete();
    }

    /**
     * Get the specified model record from the database.
     *
     * @param mixed $id The identifier of the model to find.
     *
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Update the specified model record in the database.
     *
     * @param mixed $id The identifier of the model to update.
     * @param array $data The data to update the model record.
     *
     * @return Model
     */
    public function updateById($id, array $data): Model
    {
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    /**
     * Update the specified model instance.
     *
     * @param Model $model The model instance to update.
     * @param array $data The data to update the model.
     *
     * @return Model
     */
    public function updateByModelObject(Model $model, array $data): Model
    {
        $model->update($data);
        return $model;
    }

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
    public function findByColumn($columnName, $value, $operator = '=', $orderByColumn = null, $sort = 'asc', $with = []): Collection
    {
        $query = $this->model->where($columnName, $operator, $value);

        if ($orderByColumn) {
            $query = $query->orderBy($orderByColumn, $sort);
        }

        if (count($with) > 0) {
            $query = $query->with($with);
        }

        return $query->get();
    }

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
    public function findByConditions(array $conditions, $orderByColumn = null, $sort = 'asc', $with = []): Collection
    {
        $query = $this->model;

        foreach ($conditions as $condition) {
            if (isset($condition['field'], $condition['operator'], $condition['value'])) {
                if (is_array($condition['value'])) {
                    $query = $query->whereIn($condition['field'], $condition['value']);
                } else {
                    $query = $query->where($condition['field'], $condition['operator'], $condition['value']);
                }
            }
        }

        if ($orderByColumn) {
            $query = $query->orderBy($orderByColumn, $sort);
        }

        if (count($with) > 0) {
            $query = $query->with($with);
        }

        return $query->get();
    }

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
    public function findByPage($page, $limit, $conditions = [], $orderByColumn = null, $sort = 'asc', $with = [])
    {
        $query = $this->model;

        foreach ($conditions as $condition) {
            if (isset($condition['field'], $condition['operator'], $condition['value'])) {
                if (is_array($condition['value'])) {
                    $query = $query->whereIn($condition['field'], $condition['value']);
                } else {
                    $query = $query->where($condition['field'], $condition['operator'], $condition['value']);
                }
            }
        }

        if ($orderByColumn) {
            $query = $query->orderBy($orderByColumn, $sort);
        }

        if (count($with) > 0) {
            $query = $query->with($with);
        }
        return $query->paginate(perPage: $limit, page: $page);
    }
}
