<?php

namespace Fogs\InsightBundle\Controller;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

use Symfony\Component\HttpFoundation\ParameterBag;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fogs\InsightBundle\Entity\Search;
use Fogs\InsightBundle\Form\SearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Search controller.
 *
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     * Lists Search search results
     *
     * @Route(".{_format}", name="search", defaults={"_format"="html"}, requirements={"_format"="html|json"})
     * @Method("POST")
     */
    public function searchAction($_format, Request $request)
    {
    	$form = $this->createForm(new SearchType());

   		$form->bind($request);
   		$data = $form->getData();

   		$em = $this->getDoctrine()->getManager();
   		
   		if (!$form->isValid()) {
   			return $this->render('FogsInsightBundle:Default:internal.html.twig', $data);
   		}

   		if ($data['subject'] == SearchType::SUBJECT_TYPE_OFFER) {
   			$repository = $em->getRepository('FogsInsightBundle:Offer');
   		} elseif ($data['subject'] == SearchType::SUBJECT_TYPE_INQUIRY) {
   			$repository = $em->getRepository('FogsInsightBundle:Inquiry');
   		} else {
   			throw new InvalidArgumentException('Unknown subject in search');
   		}
		
		$entities = $repository->findWithinRange($data['location'], $data['radius']);
		
		$results = array();
		foreach ($entities as $entity) {
			$result = $entity[0];
			$result['distance'] = $entity['distance'];
			$result['location'] = array(
					'latitude'	=> $result['location']->getLatitude(),
					'longitude'	=> $result['location']->getLongitude(),
			);
			$results[$result['id']] = $result;
		}
		
		if ($_format == 'json') {
			return new JsonResponse($results);
		} else {
			return array('entities' => $results);
		}

    }

    /**
     * Displays a form to create a new Search entity.
     *
     * @Route("/form", name="search_form")
     * @Method("GET")
     * @Template()
     */
    public function formAction()
    {
        $form   = $this->createForm(new SearchType());

        return array(
            'form'   => $form->createView(),
        );
    }

}
