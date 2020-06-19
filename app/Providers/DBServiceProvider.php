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
            return $data?$data:false;
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
        //分页方法
        QueryBuilder::macro('pages',function ($perPage = 15, $columns = ['*'],$pageName='page', $page = null){
            $lists = [];
            $pageobj = $this->paginate($perPage,$columns,$pageName,$page);
            $temp_list = $pageobj->items();
            foreach ($temp_list as $val) {
                $lists[] = (array)$val;
            }
            return array('total'=>$pageobj->total(),'lists'=>$lists);
        });

    }
}
