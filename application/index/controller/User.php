<?php
namespace app\index\controller;
use \think\Controller; //include ***文件
use \app\index\controller\Index; //include application\index\controller\Index.php

class User extends Controller
{
    public function index()
    {
    	// 渲染到了view的user/index.html
        return $this->fetch();
    }

    public function hl()
    {
    	$index = new Index();
    	$index->vi();
    }
}
