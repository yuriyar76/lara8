<?php


namespace App\Repositories;
use App\Factory\Helper;
use Exception;
use Illuminate\Support\Facades\Config;
use Route;


abstract class Repo
{
  protected $model = false;
  public function get($select = '*', $take=false, $pagination = false, $where=false, $sort=false)
  {
      $builder = $this->model->select($select);
      if($take) $builder->take($take);
      if($where) $builder->where($where[0], $where[1]);
      if($pagination){
          if($sort){
              return $this->check($builder->orderBy('id', $sort)->paginate(Config::get('settings.paginate')));
          }
          return $this->check($builder->paginate(Config::get('settings.paginate')));
      }
      if($sort){
          $builder->orderBy('id', $sort);
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

      if($builder){
          if(Helper::isJSON($builder->img)){
              $builder->img = json_decode( $builder->img);
          }
          return $builder;
      }
      abort(404);

    }

}
