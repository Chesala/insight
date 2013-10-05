<?php

namespace Fogs\InsightBundle\Repository;

use CrEOF\Spatial\PHP\Types\Geometry\Point;

use Doctrine\ORM\EntityRepository;

/**
 * OfferRepository
 */
class OfferRepository extends EntityRepository
{
	
	public function findWithinRange(Point $point, $radius, $parameters = array()) {
		$alias = 'offer';
		$qb = $this->createQueryBuilder($alias);
		GisAwareRepository::findWithinRange($qb, $point, $radius, $alias, 'location');
		return $qb->getQuery()->getArrayResult();
	}

}
