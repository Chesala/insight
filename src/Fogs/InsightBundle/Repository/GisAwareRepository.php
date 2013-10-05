<?php

namespace Fogs\InsightBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use CrEOF\Spatial\PHP\Types\Geometry\Point;

class GisAwareRepository
{
	
	
	public static function findWithinRange(QueryBuilder $qb, Point $point, $radius, $entityAlias, $locationAlias)
	{
		$qb->addSelect(
					'( 3959 * acos(cos(radians(' . $point->getLatitude() . '))' .
					'* cos( radians( y('.$entityAlias.'.'.$locationAlias.') ) )' .
					'* cos( radians( x('.$entityAlias.'.'.$locationAlias.') )' .
					'- radians(' . $point->getLongitude() . ') )' .
					'+ sin( radians(' . $point->getLatitude() . ') )' .
					'* sin( radians( y('.$entityAlias.'.'.$locationAlias.') ) ) ) ) as distance'
			)
		->having('distance < :distance')
		->setParameter('distance', $radius)
		->orderBy('distance', 'ASC')
		;
	}
	
}