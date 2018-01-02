<?php
namespace app\admin\controller;
/**
* 分类控制器
*/
class Cate extends \think\Controller
{
	public function index()
	{
		$list = db('cate')->paginate(10);//分页
		$this->assign('list',$list);
		return $this->fetch();
	}

	public function add()
	{
		return $this->fetch();
	}

	public function save()
	{
		db('cate')->insert(input());
		$this->success('分类添加成功！','index');
	}
}