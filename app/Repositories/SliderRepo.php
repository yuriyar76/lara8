<?php


namespace App\Repositories;


use App\Models\Slider;

class SliderRepo extends Repo
{
    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }
}
