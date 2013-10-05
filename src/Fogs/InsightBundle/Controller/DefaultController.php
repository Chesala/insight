<?php

namespace Fogs\InsightBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
		$template = 
    		$this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')?
    		'internal.html.twig' :
    		'external.html.twig';
    	
    	return $this->render('FogsInsightBundle:Default:'.$template, array());
    }

    /**
     * @Route("/about", name="about")
     * @Template
     */
    public function aboutAction()
    {
    	return array();
    }

    /**
     * @Route("/legal", name="legal")
     * @Template
     */
    public function legalAction()
    {
    	return array();
    }    
}
