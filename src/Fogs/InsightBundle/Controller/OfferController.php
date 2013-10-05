<?php

namespace Fogs\InsightBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fogs\InsightBundle\Entity\Offer;
use Fogs\InsightBundle\Form\OfferType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Offer controller.
 *
 * @Route("/offer")
 */
class OfferController extends Controller
{
    /**
     * Lists all Offer entities.
     *
     * @Route("", name="offer")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
    	$criteria = array();
    	
    	// TODO besser mit route /my filtern
        if (!$this->allowModification()) {
        	$criteria['host'] = $this->getUser();
        }
        
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FogsInsightBundle:Offer')->findBy($criteria);
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists Offer search results
     *
     * @Template()
     */
    public function searchAction($_format, $data)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('FogsInsightBundle:Offer')->findWithinRange(
        		$data['location'],
        		$data['radius']
        );
        
        $offers = array();
        foreach ($entities as $entity) {
        	$offer = $entity[0];
        	$offer['distance'] = $entity['distance'];
        	$offer['location'] = array(
        		'latitude'	=> $offer['location']->getLatitude(),
        		'longitude'	=> $offer['location']->getLongitude(),
        	);
        	$offers[$offer['id']] = $offer;
        }
        
        return array(
            'entities'		=> $offers,
        );
    }

    /**
     * Creates a new Offer entity.
     *
     * @Route("/", name="offer_create")
     * @Method("POST")
     * @Template("FogsInsightBundle:Offer:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Offer();

        if (!$this->allowModification()) {
        	$entity->setHost($this->getUser());
        }
        $form = $this->createForm($this->get('form.type.offer'), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

        	$this->get('session')->getFlashBag()->add(
        			'success',
        			'The offer has been created'
        	);
        	return $this->redirect($this->generateUrl('offer_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Offer entity.
     *
     * @Route("/new", name="offer_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Offer();
       	$entity->setHost($this->getUser());
        $form = $this->createForm($this->get('form.type.offer'), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Offer entity.
     *
     * @Route("/{id}", name="offer_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FogsInsightBundle:Offer')->find($id);

        if (!$entity) {
        	throw $this->createNotFoundException('Unable to find Offer entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      			=> $entity,
            'delete_form' 			=> $deleteForm->createView(),
        	'allow_modification'	=> $this->allowModification($entity)
        );
    }

    /**
     * Displays a form to edit an existing Offer entity.
     *
     * @Route("/{id}/edit", name="offer_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FogsInsightBundle:Offer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offer entity.');
        }

        if (!$this->allowModification($entity)) {
        	throw new UnauthorizedHttpException('You are not authorized to modify this offer.');
        }

        $editForm = $this->createForm($this->get('form.type.offer'), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Offer entity.
     *
     * @Route("/{id}", name="offer_update")
     * @Method("PUT")
     * @Template("FogsInsightBundle:Offer:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FogsInsightBundle:Offer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offer entity.');
        }

        if (!$this->allowModification($entity)) {
        	throw new UnauthorizedHttpException('You are not authorized to modify this offer.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm($this->get('form.type.offer'), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

        	$this->get('session')->getFlashBag()->add(
        			'success',
        			'The offer has been updated'
        	);
            return $this->redirect($this->generateUrl('offer_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Offer entity.
     *
     * @Route("/{id}", name="offer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FogsInsightBundle:Offer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Offer entity.');
            }

            if (!$this->allowModification($entity)) {
        		throw new UnauthorizedHttpException('You are not authorized to modify this offer.');
        	}

            $em->remove($entity);
            $em->flush();
        
        	$this->get('session')->getFlashBag()->add(
        			'success',
        			'The offer has been deleted'
        	);
        } else {
        	foreach ($form->getErrors() as $error) {
        		$this->get('session')->getFlashBag()->add('error', $error->getMessage());
        	}
        }

        return $this->redirect($this->generateUrl('offer'));
    }

    /**
     * Creates a form to delete a Offer entity by id.
     *
     * @param mixed $id The entity id
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Check, if modification is allowed
     * 
     * @param Offer $entity
     * @return boolean
     */
    private function allowModification(Offer $entity = NULL) {
    	return 
    		$this->get('security.context')->isGranted('ROLE_ADMIN') ||
    			$entity && 
    			$entity->getHost() == $this->getUser()
    	;
    }
    
}
