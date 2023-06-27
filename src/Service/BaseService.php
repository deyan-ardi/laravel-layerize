<?php

namespace DeyanArdi\LaravelLayerize\Service;


class BaseService
{
    protected  $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

    // To Get First Data From Model
    public function first($where = [], $with = [], $orderBy = null, $orderDirection = 'asc')
    {
        $query = $this->model::query();
        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($where)) {
            foreach ($where as $column => $condition) {
                if (is_array($condition) && count($condition) === 2) {
                    $operator = $condition[0];
                    $value = $condition[1];
                    $query->where($column, $operator, $value);
                } else {
                    $query->where($column, '=', $condition);
                }
            }
        }

        if ($orderBy !== null) {
            $query->orderBy($orderBy, $orderDirection);
        }

        return $query->first();
    }

    // To Get First Or Fail Data
    public function firstOrFail($where = [], $with = [], $orderBy = null, $orderDirection = 'asc')
    {
        $query = $this->model::query();
        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($where)) {
            foreach ($where as $column => $condition) {
                if (is_array($condition) && count($condition) === 2) {
                    $operator = $condition[0];
                    $value = $condition[1];
                    $query->where($column, $operator, $value);
                } else {
                    $query->where($column, '=', $condition);
                }
            }
        }

        if ($orderBy !== null) {
            $query->orderBy($orderBy, $orderDirection);
        }

        return $query->firstOrFail();
    }

    // To Get All Data
    public function get($where = [], $with = [], $orderBy = null, $orderDirection = 'asc')
    {
        $query = $this->model::query();
        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($where)) {
            foreach ($where as $column => $condition) {
                if (is_array($condition) && count($condition) === 2) {
                    $operator = $condition[0];
                    $value = $condition[1];
                    $query->where($column, $operator, $value);
                } else {
                    $query->where($column, '=', $condition);
                }
            }
        }

        if ($orderBy !== null) {
            $query->orderBy($orderBy, $orderDirection);
        }

        return $query->get();
    }

    public function getCount($where = [], $with = [])
    {
        $query = $this->model::query();
        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($where)) {
            foreach ($where as $column => $condition) {
                if (is_array($condition) && count($condition) === 2) {
                    $operator = $condition[0];
                    $value = $condition[1];
                    $query->where($column, $operator, $value);
                } else {
                    $query->where($column, '=', $condition);
                }
            }
        }
        return $query->count();
    }

    public function paginate($perPage = 10, $where = [], $with = [], $orderBy = null, $orderDirection = 'asc')
    {
        $query = $this->model::query();

        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($where)) {
            foreach ($where as $column => $condition) {
                if (is_array($condition) && count($condition) === 2) {
                    $operator = $condition[0];
                    $value = $condition[1];
                    $query->where($column, $operator, $value);
                } else {
                    $query->where($column, '=', $condition);
                }
            }
        }

        if ($orderBy !== null) {
            $query->orderBy($orderBy, $orderDirection);
        }

        return $query->paginate($perPage);
    }

    public function pluck($column, $where = [], $with = [], $orderBy = null, $orderDirection = 'asc')
    {
        $query = $this->model::query();

        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($where)) {
            foreach ($where as $column => $condition) {
                if (is_array($condition) && count($condition) === 2) {
                    $operator = $condition[0];
                    $value = $condition[1];
                    $query->where($column, $operator, $value);
                } else {
                    $query->where($column, '=', $condition);
                }
            }
        }

        if ($orderBy !== null) {
            $query->orderBy($orderBy, $orderDirection);
        }

        return $query->pluck($column);
    }

    public function chunk($size, $callback, $where = [], $with = [], $orderBy = null, $orderDirection = 'asc')
    {
        $query = $this->model::query();

        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($where)) {
            foreach ($where as $column => $condition) {
                if (is_array($condition) && count($condition) === 2) {
                    $operator = $condition[0];
                    $value = $condition[1];
                    $query->where($column, $operator, $value);
                } else {
                    $query->where($column, '=', $condition);
                }
            }
        }

        if ($orderBy !== null) {
            $query->orderBy($orderBy, $orderDirection);
        }

        $query->chunk($size, $callback);
    }

    public function firstOrNew($where = [], $attributes = [])
    {
        $query = $this->model::query();

        if (!empty($where)) {
            foreach ($where as $column => $condition) {
                if (is_array($condition) && count($condition) === 2) {
                    $operator = $condition[0];
                    $value = $condition[1];
                    $query->where($column, $operator, $value);
                } else {
                    $query->where($column, '=', $condition);
                }
            }
        }

        return $query->firstOrNew($attributes);
    }
}
