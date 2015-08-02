<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Skill;
use AppBundle\Form\SkillType;

/**
 * skill controller.
 *
 * @Route("/skill")
 */
class SkillController extends Controller
{

    /**
     * Lists all skill entities.
     *
     * @Route("/", name="skill")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Skill')->findAll();

        return $this->render(":skill:index.html.twig", array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new skill entity.
     *
     * @Route("/", name="skill_create")
     * @Method("POST")
     * @Template("AppBundle:skill:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Skill();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('skill_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a skill entity.
     *
     * @param Skill $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Skill $entity)
    {
        $form = $this->createForm(new SkillType(), $entity, array(
            'action' => $this->generateUrl('skill_create'),
            'method' => 'POST',
            'attr' => array(
                'class' => "form-horizontal"
            )
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create',
            'attr' => array(
                'class' => 'btn btn-default'
            )
        ));

        return $form;
    }

    /**
     * Displays a form to create a new skill entity.
     *
     * @Route("/new", name="skill_new")
     * @Method("GET")

     */
    public function newAction()
    {
        $entity = new Skill();
        $form   = $this->createCreateForm($entity);

        return $this->render(":skill:new.html.twig", array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a skill entity.
     *
     * @Route("/{id}", name="skill_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Skill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find skill entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(":skill:show.html.twig", array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing skill entity.
     *
     * @Route("/{id}/edit", name="skill_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Skill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find skill entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(":skill:edit.html.twig", array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a skill entity.
    *
    * @param Skill $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Skill $entity)
    {
        $form = $this->createForm(new SkillType(), $entity, array(
            'action' => $this->generateUrl('skill_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'attr' => array(
                'class' => "form-horizontal"
            )
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Update',
            'attr' => array(
                'class' => 'btn btn-default'
            )
        ));

        return $form;
    }
    /**
     * Edits an existing skill entity.
     *
     * @Route("/{id}", name="skill_update")
     * @Method("PUT")
     * @Template("AppBundle:skill:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Skill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find skill entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('skill_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a skill entity.
     *
     * @Route("/{id}", name="skill_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Skill')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find skill entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('skill'));
    }

    /**
     * Creates a form to delete a skill entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('skill_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
