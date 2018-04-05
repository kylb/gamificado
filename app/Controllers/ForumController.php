<?php 

namespace App\Controllers;

use Core\BaseController;
use App\Models\PublicationsBaseModel;
use App\Models\EssaysBaseModel;

class ForumController extends BaseController
{
	private $publication;

	public function forum()
	{
		$this->setPageTitle('Forum');
		$model = new PublicationsBaseModel();
		$this->view->publication = $model->All();
		$this->renderView("forum/table","layout");
	}

	public function listar($id)
	{
		$this->setPageTitle('Listar Forum');
		$model = new EssaysBaseModel();
		$this->view->publication = $model->findEssays($id);
		$this->renderView("forum/table1","layout");
	}

}

?>
