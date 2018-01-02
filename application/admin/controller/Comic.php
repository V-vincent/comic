<?php
namespace app\admin\controller;

class Comic extends \think\Controller
{
	public function index()
	{
		$where_data = [];
		if(input('comic_name')){
			$where_data['comic_name'] = ['like','%'.input('comic_name').'%'];
		}
		if (input('cate_id')>0) {
			$where_data['cate_id'] = input('cate_id');
		}
		// desc 降序 从大到小 最新的在最前面
		// asc 升序 从小到大 最旧的在最前面
		$list=db("comic")->alias('m')
						->field('m.id, m.cate_id, m.comic_name, c.cate_name') 
						->join('cate c','m.cate_id=c.id')
						->order('m.id desc')
						->where($where_data)
						->select();
		foreach ($list as $key => $value) {
			$list[$key]['dblStatus'] = false;
		}							
		$this->assign('list',json_encode($list));

		$cate_list = db('cate')->select();
		$this->assign('cate_list',$cate_list);

		return $this->fetch();
	}
	public function add()
	{
		$list = db('cate')->select();
		$this->assign('list',$list);
		return $this->fetch();
	}

	public function save()
	{
		$data  = input();
		$thumb = request()->file('comic_thumb');
		if($thumb){
			$info = $thumb->move(ROOT_PATH.'/public/uploads');
			if($info){
				$data['comic_thumb'] = $info->getSaveName();
			}else{
				 echo $info->getError();
			}
		}
		db("comic")->insert($data);
		$this->success('添加成功','index');
	}
    public function edit()
    {
    	$id=input('id');
    	$info = db('comic')->where("id=$id")->find();
    	$this->assign('info',$info);  

    	$list = db('cate')->select();
		$this->assign('list',$list);  
    	return $this->fetch();
    }

	public function update()
	{
		$update_data = input();
		$id = input('id');
		$thumb = request()->file('comic_thumb');
		if($thumb){
			$info = $thumb->move(ROOT_PATH.'/public/uploads');
			if($info){
				$update_data['comic_thumb'] = $info->getSaveName();
			}else{
				echo $info->getError();
			}
		}		 
		
		 db('comic')->where("id=$id")->update($update_data);
		 $this->success('更新成功！','index',true,true);
	}    

	public function delete(){
		$id = input('id');
		if ($id>0) {
			db('comic')->where("id=$id")->delete();
			$this->success('删除成功！','index');
		}		
    }

	public function update2()
	{
		$update_data = input();
		$id = input('id');
		db('comic')->where("id=$id")->update($update_data);
		return file_get_contents(url('admin/comic/index','',true,true));
	}   
}