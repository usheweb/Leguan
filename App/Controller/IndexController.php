<?php

class IndexController extends Controller{

	public function IndexAction(){
		//echo "index";
		//echo "<br>".$this->debug->getExecTime();

		$model = $this->Model;
		//$sql = 'update @_article set title = ?,description = ? where id = ?';
		//$result = $model->query($sql,array('title2','description3',1));
		$sql = 'select * from @_article';
		$result = $model->query($sql);
		$this->View->set('articleList',$result);
		$this->View->set('articleTitle','文章列表');
		$this->Response->send('Article/list');
	}

}