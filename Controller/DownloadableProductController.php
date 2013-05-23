<?php

namespace MP\Bundle\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MP\Bundle\CatalogBundle\Entity\DownloadableProduct;
use MP\Bundle\CatalogBundle\Form\DownloadableProductType;

use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * DownloadableProduct controller.
 *
 * @Route("/admin/downloadableproduct")
 */
class DownloadableProductController extends Controller
{
    /**
     * Lists all DownloadableProduct entities.
     *
     * @Route("/", name="admin_downloadableproduct")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('MPCatalogBundle:DownloadableProduct')->findAll();

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
     * Finds and displays a DownloadableProduct entity.
     *
     * @Route("/{id}/show", name="admin_downloadableproduct_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MPCatalogBundle:DownloadableProduct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DownloadableProduct entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new DownloadableProduct entity.
     *
     * @Route("/new", name="admin_downloadableproduct_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DownloadableProduct();
        $form   = $this->createForm(new DownloadableProductType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new DownloadableProduct entity.
     *
     * @Route("/create", name="admin_downloadableproduct_create")
     * @Method("POST")
     * @Template("MPCatalogBundle:DownloadableProduct:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new DownloadableProduct();
        $form = $this->createForm(new DownloadableProductType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been created', array(
                    '%entity%' => 'DownloadableProduct',
                    '%id%'     => $entity->getId()
                ))
            );

            return $this->redirect($this->generateUrl('admin_downloadableproduct_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing DownloadableProduct entity.
     *
     * @Route("/{id}/edit", name="admin_downloadableproduct_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MPCatalogBundle:DownloadableProduct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DownloadableProduct entity.');
        }

        $editForm = $this->createForm(new DownloadableProductType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing DownloadableProduct entity.
     *
     * @Route("/{id}/update", name="admin_downloadableproduct_update")
     * @Method("POST")
     * @Template("MPCatalogBundle:DownloadableProduct:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MPCatalogBundle:DownloadableProduct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DownloadableProduct entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DownloadableProductType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been updated', array(
                    '%entity%' => 'DownloadableProduct',
                    '%id%'     => $entity->getId()
                ))
            );

            return $this->redirect($this->generateUrl('admin_downloadableproduct_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a DownloadableProduct entity.
     *
     * @Route("/{id}/delete", name="admin_downloadableproduct_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MPCatalogBundle:DownloadableProduct')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DownloadableProduct entity.');
            }

            $em->remove($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('%entity%[%id%] has been deleted', array(
                    '%entity%' => 'DownloadableProduct',
                    '%id%'     => $id
                ))
            );
        }

        return $this->redirect($this->generateUrl('admin_downloadableproduct'));
    }

    /**
     * Display DownloadableProduct deleteForm.
     *
     * @Template()
     */
    public function deleteFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MPCatalogBundle:DownloadableProduct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DownloadableProduct entity.');
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
