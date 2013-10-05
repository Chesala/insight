<?php

namespace Fogs\InsightBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fogs\InsightBundle\Entity\Inquiry;
use Fogs\InsightBundle\Form\InquiryType;

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
     * @Route("/", name="inquiry")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FogsInsightBundle:Inquiry')->findAll();

        return array(
            'entities' => $entities,
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
        $form = $this->createForm(new InquiryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

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
        $form   = $this->createForm(new InquiryType(), $entity);

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
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
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

        $editForm = $this->createForm(new InquiryType(), $entity);
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

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new InquiryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

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

            $em->remove($entity);
            $em->flush();
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
}
