<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Index\Controller;

use \Leguan\Controller\RestController;

class CurdController extends RestController
{
	public function getTestAction()
	{
		$data = array('json', "get");

		return $data;
	}

	public function postTestAction()
	{
		echo "post";
	}

	public function putTestAction()
	{
		echo "put";
	}

	public function deleteTestAction()
	{
		echo "delete";
	}
}