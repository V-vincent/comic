<?php
namespace app\index\controller;

/**
* 漫画控制器
*/
class Comic extends \think\Controller
{
	
	public function info()
	{
		// 获取当前这条漫画的信息
		$id = input('id');
		$info = db('comic')->where("id=$id")->find();

		$this->assign('info',$info);
		return $this->fetch();
	}
}


?>