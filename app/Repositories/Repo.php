<?php


namespace App\Repositories;
use Illuminate\Support\Facades\Config;

abstract class Repo
{
  protected $model = false;
  public function get($select = '*', $take=false)
  {
      $builder = $this->model->select($select);
      if($take) $builder->take($take);
      return $builder->get();
  }

}
