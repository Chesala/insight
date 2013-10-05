<?php

namespace Fogs\LocationPickerBundle\Form;

use CrEOF\Spatial\PHP\Types\Geometry\Point;

use FPN\TagBundle\Entity\TagManager;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class LocationTransformer implements DataTransformerInterface
{
	
	public function transform($point)
	{
		if ($point instanceof Point) {
			return array(
					'latitude'	=> $point->getLatitude(),
					'longitude'	=> $point->getLongitude(),
			);
		} else {
			return array(
					'latitude'	=> '',
					'longitude'	=> '',
			);
		}
	}

	public function reverseTransform($location)
	{
		if (!isSet($location['longitude']) || empty($location['longitude'])) {
			return;
		} elseif (!isSet($location['latitude']) || empty($location['latitude'])) {
			return;
		} else {
			return new Point($location['longitude'], $location['latitude']);
		}
	}
}