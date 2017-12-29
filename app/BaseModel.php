<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model 
{
    public function getNumber($identify, $other = []){
        $rules = (new Config)->getConfigByIdentify($identify);

        if(preg_match("/\{rand(:)?(\d*)?\}/i", $rules)){
            $rules = preg_replace_callback("/\{rand(:)?(\d*)?\}/i", function($matches){
                return $this->getRandNumber($matches[2]);
            }, $rules);
        }
        if(preg_match("/\{yyyy\}/i", $rules, $matches)){
            $rules = preg_replace("/\{yyyy\}/i", date('Y'), $rules);
        }
        if(preg_match("/\{yy\}/i", $rules, $matches)){
            $rules = preg_replace("/\{yy\}/i", date('y'), $rules);
        }
        if(preg_match("/\{mm\}/i", $rules, $matches)){
            $rules = preg_replace("/\{mm\}/i", date('m'), $rules);
        }
        if(preg_match("/\{dd\}/i", $rules, $matches)){
            $rules = preg_replace("/\{dd\}/i", date('d'), $rules);
        }
        if(preg_match("/\{count(:)?(\d*)?\}/i", $rules)){
            $count = $this->count()+1;
            $rules = preg_replace_callback("/\{count(:)?(\d*)?\}/i", function($matches) use($count){
                return $this->getPad($count, $matches[2]);
            }, $rules);
        }
        if(preg_match("/\{ycount(:)?(\d*)?\}/i", $rules)){
            $ycount = $this->whereYear('created_at', date('Y'))->count()+1;
            $rules = preg_replace_callback("/\{ycount(:)?(\d*)?\}/i", function($matches) use($ycount){
                return $this->getPad($ycount, $matches[2]);
            }, $rules);
        }
        if(preg_match("/\{mcount(:)?(\d*)?\}/i", $rules)){
            $mcount = $this->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count()+1;
            $rules = preg_replace_callback("/\{mcount(:)?(\d*)?\}/i", function($matches) use($mcount){
                return $this->getPad($mcount, $matches[2]);
            }, $rules);
        }
        if(preg_match("/\{dcount(:)?(\d*)?\}/i", $rules)){
            $dcount = $this->whereDate('created_at', date("Y-m-d"))->count()+1;
            $rules = preg_replace_callback("/\{dcount(:)?(\d*)?\}/i", function($matches) use($dcount){
                return $this->getPad($dcount, $matches[2]);
            }, $rules);
        }
        return $rules;
    }

    public function getRandNumber($length = 6){
        if(empty($length) || $length <= 0){
            return 6;
        }
        $tem = array_rand([0,1,2,3,4,5,6,7,8,9], $length);
        return implode('', $tem);
    }

    public function getPad($number, $length = null){
        $length = intval($length);
        if(empty($length) || $length <= 0){
            return $number;
        }

        if(strlen($number) > $length){
            $number = substr($number, 0, $length);
        }

        return str_pad($number,$length,'0',STR_PAD_LEFT);
    }
}