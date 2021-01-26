<?php


namespace App\Repositories;


use App\Models\Portfolio;

class PortfolioRepo extends Repo
{
    public function __construct(Portfolio $portfolio)
    {
        $this->model = $portfolio;
    }
}
