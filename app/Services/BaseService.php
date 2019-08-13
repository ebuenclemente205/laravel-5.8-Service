<?php

namespace App\Services;

use Exception;

class BaseService
{
    /**
     * The base service model
     *
     * @var
     */
    protected $model;

    /**
     * Create a new service instance
     *
     * @param $model
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get all instances of model
     *
     * @return void
     */
    public function all()
    {
        return self::search([]);
    }

    /**
     * Search model instances  by parameters
     *
     * @return
     */
    public function search(array $columns = [], int $paginate = 0)
    {
        $query = new $this->model;
        foreach ($columns as $column => $value) {
            $query = $query->where($column, $value);
        }
        return $paginate ? $query->paginate($paginate) : $query->get();
    }

    /**
     * Register new model
     *
     * @return mixed
     */
    public function create(array $details)
    {
        try {
            return $this->model::create($details);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Show singular model instance
     *
     * @param mixed $model
     *
     * @return mixed
     */
    public function show($model)
    {
        if (empty($model) || is_string($model)) {
            return null;
        }
        return $model;
    }

    /**
     * Paginated subscribers
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function paginate(int $length = 10)
    {
        return self::search([], $length);
    }
}
