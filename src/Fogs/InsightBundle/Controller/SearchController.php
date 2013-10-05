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

   		if ($form->isValid()) {
	   		if ($data['subject'] == SearchType::SUBJECT_TYPE_OFFER) {
	   			return $this->forward('FogsInsightBundle:Offer:search', array('_format' => $_format, 'data' => $data));
	   		} elseif ($data['subject'] == SearchType::SUBJECT_TYPE_INQUIRY) {
	   			return $this->forward('FogsInsightBundle:Inquiry:search', array('_format' => $_format, 'data' => $data));
	   		} else {
	   			throw new InvalidArgumentException('Unknown subject in search');
	   		}
		}
		 
		return $this->render('FogsInsightBundle:Default:internal.html.twig', $data);
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
