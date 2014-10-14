<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Index\Controller;

use \Leguan\Controller\Controller;
use \Usheweb\Chapter\Chapter;

class IndexController extends Controller
{
	public function indexAction()
	{
		$table = 'article';
		
		$condition = array('click' => array('>',5,'or'),'id'=>array('in',array(1,3,5)));
		$article = $this->Db->table($table)->where($condition)->field('id,title')->select();

		$view = $this->view;
		$view->assign('author', 'ushe');
		$view->assign('script', '<script>alert("Leguan")</script>');
		$view->assign('article', $article);
		$view->assign('age',20);
		$view->list = array('apple','pear','orange');
		$view->display();
		echo "<br>";
		echo $this->Debug->execTime();
	}

	public function dbAction()
	{
		$values = array("title"=>"new 'title",'description' => 'test');
		$table = 'article';
		//$this->Debug->dump($this->Db->query('insert into `lg_article` set title = ?,description = ?;'));
		//echo $this->Db->table($table)->values($values)->add();

		$this->Debug->dump(
				$this->Sql->table($table)->where(
			array('click' => array('>',5,'or'),'id'=>array('in',array(1,3,5))))->field('id,title')->select()
			);
	}

	public function chapterAction()
	{
		$chapter = new Chapter();
		$chapter->show();
	}

	public function cacheAction()
	{
		$arr = array('a',123);
		$this->cache->write('test_arr', $arr);
		$this->debug->dump($this->cache->read('test_arr'));
	}

	public function readcacheAction()
	{
		$arr = $this->cache->read('test_arr');
		$this->debug->dump($arr);
	}

	public function defaultAction()
	{
		echo 'defaultAction';
	}

	public function uploadAction()
	{
		$this->view->assign('upload', new \Usheweb\Upload\Upload());
		$this->view->display();
	}

	public function doUploadAction()
	{
		if(!$this->request->isPost()){
			return;
		}

		$upload = new \Usheweb\Upload\Upload();
		$this->debug->dump($upload->run());
	}
}