<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $model;

    function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    abstract protected function getModelClass(): string;
}
