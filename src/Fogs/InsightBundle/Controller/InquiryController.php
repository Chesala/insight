<?php

namespace Fogs\InsightBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fogs\InsightBundle\Entity\Inquiry;
use Fogs\InsightBundle\Form\InquiryType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Inquiry controller.
 *
 * @Route("/inquiry")
 */
class InquiryController extends Controller
{
    /**
     * Lists all Inquiry entities.
     *
     * @Route(".{_format}", name="inquiry", defaults={"_format"="html"}, requirements={"_format"="html|xml|json"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction($_format)
    {
    	$criteria = array();
    	
    	// TODO besser mit route /my filtern
        if (!$this->allowModification()) {
        	$criteria['traveller'] = $this->getUser();
        }
        
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FogsInsightBundle:Inquiry')->findBy($criteria);
    	
        if ($_format == 'json') {
        	return new JsonResponse(array('entities' => $entities));
        }
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists inquiry search results
     *
     * @Template()
     */
    public function searchAction($_format, $data)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$entities = $em->getRepository('FogsInsightBundle:Inquiry')->findWithinRange(
    			$data['location'],
    			$data['radius']
    	);
    
    	$inquiries = array();
    	foreach ($entities as $entity) {
    		$inquiry = $entity[0];
    		$inquiry['distance'] = $entity['distance'];
    		$inquiry['location'] = array(
    				'latitude'	=> $inquiry['location']->getLatitude(),
    				'longitude'	=> $inquiry['location']->getLongitude(),
    		);
    		$inquiries[$inquiry['id']] = $inquiry;
    	}
    
    	return array(
    			'entities'		=> $inquiries,
    	);
    }
        
    /**
     * Creates a new Inquiry entity.
     *
     * @Route("/", name="inquiry_create")
     * @Method("POST")
     * @Template("FogsInsightBundle:Inquiry:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Inquiry();
        if (!$this->allowModification()) {
        	$entity->setTraveller($this->getUser());
        }
        $form = $this->createForm($this->get('form.type.inquiry'), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
            		'success',
            		'The inquiry has been created'
            );
            return $this->redirect($this->generateUrl('inquiry_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Inquiry entity.
     *
     * @Route("/new", name="inquiry_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Inquiry();
       	$entity->setTraveller($this->getUser());
        $form   = $this->createForm($this->get('form.type.inquiry'), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Inquiry entity.
     *
     * @Route("/{id}", name="inquiry_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FogsInsightBundle:Inquiry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inquiry entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      			=> $entity,
            'delete_form' 			=> $deleteForm->createView(),
        	'allow_modification'	=> $this->allowModification($entity),
        );
    }

    /**
     * Displays a form to edit an existing Inquiry entity.
     *
     * @Route("/{id}/edit", name="inquiry_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FogsInsightBundle:Inquiry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inquiry entity.');
        }

        if (!$this->allowModification($entity)) {
        	throw new UnauthorizedHttpException('You are not authorized to modify this inquiry.');
        }
        
        $editForm = $this->createForm($this->get('form.type.inquiry'), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Inquiry entity.
     *
     * @Route("/{id}", name="inquiry_update")
     * @Method("PUT")
     * @Template("FogsInsightBundle:Inquiry:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FogsInsightBundle:Inquiry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inquiry entity.');
        }

        if (!$this->allowModification($entity)) {
        	throw new UnauthorizedHttpException('You are not authorized to modify this inquiry.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm($this->get('form.type.inquiry'), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
            		'success',
            		'The inquiry has been updated'
            );
            return $this->redirect($this->generateUrl('inquiry_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Inquiry entity.
     *
     * @Route("/{id}", name="inquiry_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FogsInsightBundle:Inquiry')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Inquiry entity.');
            }

            if (!$this->allowModification($entity)) {
            	throw new UnauthorizedHttpException('You are not authorized to modify this inquiry.');
            }
            
            $em->remove($entity);
            $em->flush();
        
        	$this->get('session')->getFlashBag()->add(
        			'success',
        			'The inquiry has been deleted'
        	);
        } else {
        	foreach ($form->getErrors() as $error) {
        		$this->get('session')->getFlashBag()->add('error', $error->getMessage());
        	}
        }

        return $this->redirect($this->generateUrl('inquiry'));
    }

    /**
     * Creates a form to delete a Inquiry entity by id.
     *
     * @param mixed $id The entity id
     *
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
     * @param Inquiry $entity
     * @return boolean
     */
    private function allowModification(Inquiry $entity = NULL) {
    	return
    	$this->get('security.context')->isGranted('ROLE_ADMIN') ||
    	$entity &&
    	$entity->getTraveller() == $this->getUser()
    	;
    }
}
