<?php
namespace App;

use DB;
use Cache;
class Config extends BaseModel 
{

    protected $table = 'configs';

    public function getConfigByIdentify($identify, $isAll = false){
        $config = $this->where('identify', $identify)->first();
        if(empty($config)){
            throw new \Exception("未查找到配置项");
        }
        
        if($isAll) return $config;

        return $config['values'];
    }
}