<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseRepository
{
    protected $allowedFilters = [];
    protected $allowedSorts = [];

    public function __construct()
    {
        $model = app()->make($this->model());

        if (! $model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of ".Model::class);
        }

        $this->model = $model;
    }

    abstract public function model();

    abstract public function forceDelete($model);

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    abstract public function update($model, array $data);

    /**
     * Restore the soft deleted model
     * @param $model
     * @return mixed
     */
    abstract public function restore($model);


    public function search(string $search)
    {
        return app()->make($this->model)->search($search);
    }

    /**
     * search result from the query params passed in the api
     * @return QueryBuilder
     */
    public function buildQuery()
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters($this->allowedFilters)
            ->allowedSorts($this->allowedSorts);
    }

    public function query(callable $callback)
    {
        return $this->model->query($callback);
    }

    public function getDeleted($orderBy = 'created_at', $sort = 'desc')
    {
        $this->model = $this->model
            ->onlyTrashed()
            ->orderBy($orderBy, $sort);
        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $model
     * @return mixed
     */
    public function softDelete(Model $model)
    {
        return $model->delete();
    }

}
