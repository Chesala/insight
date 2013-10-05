<?php

namespace Fogs\InsightBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fogs\InsightBundle\Entity\Profile;
use Fogs\InsightBundle\Form\ProfileType;
use Fogs\UserBundle\Entity\User;

/**
 * Profile controller.
 *
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    
    /**
     * Lists all Profile entities.
     *
     * @Route("/", name="profile")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FogsInsightBundle:Profile')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Profile entity.
     *
     * @Route("/", name="profile_create")
     * @Method("POST")
     * @Template("FogsInsightBundle:Profile:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Profile();
        $form = $this->createForm(new ProfileType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('profile_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Finds and displays a Profile entity.
     *
     * @Route("/{id}", name="profile_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
		$entity = $this->getProfile($id);
    	
        return array(
        	'id'		  => $id,
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Profile entity.
     *
     * @Route("/{id}/edit", name="profile_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
		$entity = $this->getProfile($id);
    	        
        $editForm = $this->createForm(new ProfileType(), $entity);

        return array(
        	'id'		  => $id,
        	'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Profile entity.
     *
     * @Route("/{id}", name="profile_update")
     * @Method("PUT")
     * @Template("FogsInsightBundle:Profile:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
		$entity = $this->getProfile($id);
        
        $editForm = $this->createForm(new ProfileType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
        	$em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
            		'success',
            		'Your changes were saved!'
            );
            
            return $this->redirect($this->generateUrl('profile_show', array('id' => $id)));
        }

        return array(
        	'id'		  => $id,
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
 
    
    private function getProfile($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	if ($id == 'me') {
    		$user = $this->get('security.context')->getToken()->getUser();
    		$profile = $em->getRepository('FogsInsightBundle:Profile')->findOneBy(array('owner' => $user));
    	} else {
    		$profile = $em->getRepository('FogsInsightBundle:Profile')->find($id);
    	}
    	
    	if (!$profile) {
    		throw $this->createNotFoundException('Unable to find Profile entity.');
    	}
    	
    	return $profile;
    }
        
}