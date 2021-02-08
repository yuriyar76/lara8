<?php


namespace App\Repositories;
use App\Factory\Helper;
use Illuminate\Support\Facades\Config;

abstract class Repo
{
  protected $model = false;
  public function get($select = '*', $take=false, $pagination = false, $where=false)
  {
      $builder = $this->model->select($select);
      if($take) $builder->take($take);
      if($where) $builder->where($where[0], $where[1]);
      if($pagination){
          return $this->check($builder->paginate(Config::get('settings.paginate')));
      }
      return $this->check($builder->get());
  }

    protected function check($result)
    {
        if($result->isEmpty()){
            return false;
        }

        $result->transform(function ($item, $key){
            if(Helper::isJSON( $item->img)){
                $item->img = json_decode($item->img);

            }
            return $item;
        });
        //dd($result);
        return $result;

    }

    public function one($alias, $attr=[]){
      $builder =  $this->model->where('alias', $alias)->first();
      return $builder;
    }

}
