<?php
/**
 * Created by PhpStorm.
 * User: Marten
 * Date: 01.06.2016
 * Time: 10:55
 */

namespace BikeStore\Controller;


use BikeStore\Form\ArticleFilterForm;
use BikeStore\Form\BikePartFilterForm;
use BikeStore\Form\Hydrator\ArticleFilterHydrator;
use BikeStore\Form\Hydrator\BikePartFilterHydrator;
use BikeStore\Model\Filter\ArticleFilterContainer;
use BikeStore\Model\Filter\BikePartFilterContainer;
use BikeStore\Model\Manager\EquipmentManager;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;

class BikePartController extends AbstractActionController
{
	const ARTICLES_PER_SIDE = 15;

	public function showBikePartListAction()
	{
		/** @var EquipmentManager $equipmentManager */
		$equipmentManager = $this->serviceLocator->get('BikeStore.equipmentManager');

		$filterForm = new BikePartFilterForm();

		/** @var Request $request */
		$request = $this->getRequest();
		$articleFilterContainer = new BikePartFilterContainer();
		$articleFilterContainer->setLimit(self::ARTICLES_PER_SIDE);

		$filterForm->bind($articleFilterContainer);
		if ($request->isGet())
		{
			$data = $request->getQuery()->toArray();
			$filterForm->setData($data);
			$filterForm->isValid();
		}

		$articles = $equipmentManager->findByArticleFilterContainer($articleFilterContainer);
		$page = ceil($articleFilterContainer->getOffset() / self::ARTICLES_PER_SIDE) + 1;
		$maxPage = ceil($articleFilterContainer->getNumberResultsWithoutLimitOffset() / self::ARTICLES_PER_SIDE);
		
		$page = ($page > $maxPage)? 1:$page;
		$page = ($page <= 0)? 1:$page;
		return array(
			"filterForm" => $filterForm,
			"equipments" => $articles,
			"maxpage" => $maxPage,
			"page" => $page,
		);
	}

	public function showBikepartDetailsAction()
	{
		return array(
			'myvar' => '12',
		);

	}
}