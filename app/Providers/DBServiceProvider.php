<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder as QueryBuilder;
class DBServiceProvider extends ServiceProvider
{
    public function boot()
    {
        QueryBuilder::macro('item',function (){
            $data = $this->first();
            $data = (array)$data;
            return $data;
        });
        //返回数组列表
        QueryBuilder::macro('lists',function (){
            $data = $this->get()->all();
            $result = [];
            foreach($data as $val){
                $result[] = (array)$val;
            }
            return $result;
        });

    }
}
