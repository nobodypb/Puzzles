<?php

namespace BikeStore\Factory\Model\Manager;

use BikeStore\Model\Manager\EBikeManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EBikeManagerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$em = $serviceLocator->get('doctrine.entitymanager.custom');
		return new EBikeManager($em->getRepository('\BikeStore\Model\EBike'));
	}
}