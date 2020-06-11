<?php
namespace App\Providers;

use Illuminate\Support\Facades\DB;
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
            $data = $this->get()->toArray();
            $result = [];
            foreach($data as $val){
                $result[] = (array)$val;
            }
            return $result;
        });
        //自定义索引
        QueryBuilder::macro('cates',function ($index){
            $lists = $this->get()->toArray();
            $res = [];
            foreach ($lists as $value){
                $res[$value->$index] = (array)$value;
            }
            return $res;
        });

    }
}
