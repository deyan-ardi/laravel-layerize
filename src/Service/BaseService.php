<?php

namespace DeyanArdi\LaravelLayerize\Service;


class BaseService
{
    protected  $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getByAttr($with = [], $where = [], $method = 'get', $orderBy = null, $orderDirection = 'asc')
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

        if ($method === 'first') {
            return $query->first();
        } elseif ($method === 'fof') {
            return $query->firstOrFail();
        } else {
            return $query->get();
        }
    }
}
