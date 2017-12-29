<?php

namespace App;

use DB;
use Cache;
use Illuminate\Http\Request;

class Region extends BaseModel
{
    protected $table      = 'regions';
    protected $primaryKey = 'id';
    protected $guarded    = [];

    public function listToree($list, $pk='id', $pid = 'parent_id', $child = 'children', $root=0) {

        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }


}
