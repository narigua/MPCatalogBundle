<?php

namespace MP\Bundle\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MP\Bundle\CatalogBundle\Entity\ProductOwner;
use MP\Bundle\CatalogBundle\Form\ProductOwnerType;

use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * ProductOwner controller.
 *
 * @Route("/admin/productowner")
 */
class ProductOwnerController extends Controller
{
    /**
     * Lists all ProductOwner entities.
     *
     * @Route("/", name="admin_productowner")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('MPCatalogBundle:ProductOwner')->findAll();

        $adapter = new ArrayAdapter($entities);
        $pager = new PagerFanta($adapter);
        $pager->setMaxPerPage($this->container->getParameter('max_per_page'));

        try {
            $pager->setCurrentPage($request->query->get('page', 1));
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return array(
            'pager' => $pager,
        );
    }

    /**
     * Finds and displays a ProductOwner entity.
     *
     * @Route("/{id}/show", name="admin_productowner_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MPCatalogBundle:ProductOwner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductOwner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new ProductOwner entity.
     *
     * @Route("/new", name="admin_productowner_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ProductOwner();
        $form   = $this->createForm(new ProductOwnerType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new ProductOwner entity.
     *
     * @Route("/create", name="admin_productowner_create")
     * @Method("POST")
     * @Template("MPCatalogBundle:ProductOwner:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new ProductOwner();
        $form = $this->createForm(new ProductOwnerType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been created', array(
                    '%entity%' => 'ProductOwner',
                    '%id%'     => $entity->getId()
                ))
            );

            return $this->redirect($this->generateUrl('admin_productowner_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProductOwner entity.
     *
     * @Route("/{id}/edit", name="admin_productowner_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MPCatalogBundle:ProductOwner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductOwner entity.');
        }

        $editForm = $this->createForm(new ProductOwnerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ProductOwner entity.
     *
     * @Route("/{id}/update", name="admin_productowner_update")
     * @Method("POST")
     * @Template("MPCatalogBundle:ProductOwner:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MPCatalogBundle:ProductOwner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductOwner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ProductOwnerType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been updated', array(
                    '%entity%' => 'ProductOwner',
                    '%id%'     => $entity->getId()
                ))
            );

            return $this->redirect($this->generateUrl('admin_productowner_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ProductOwner entity.
     *
     * @Route("/{id}/delete", name="admin_productowner_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MPCatalogBundle:ProductOwner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProductOwner entity.');
            }

            $em->remove($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been deleted', array(
                    '%entity%' => 'ProductOwner',
                    '%id%'     => $id
                ))
            );
        }

        return $this->redirect($this->generateUrl('admin_productowner'));
    }

    /**
     * Display ProductOwner deleteForm.
     *
     * @Template()
     */
    public function deleteFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MPCatalogBundle:ProductOwner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductOwner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
