<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Prenda;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Prenda controller.
 *
 * @Route("prenda")
 */
class PrendaController extends Controller
{
    /**
     * Lists all prenda entities.
     *
     * @Route("/", name="prenda_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prendas = $em->getRepository('AppBundle:Prenda')->findAll();

        return $this->render('prenda/index.html.twig', array(
            'prendas' => $prendas,
        ));
    }

    /**
     * Creates a new prenda entity.
     *
     * @Route("/new", name="prenda_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $prenda = new Prenda();
        $form = $this->createForm('AppBundle\Form\PrendaType', $prenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prenda);
            $em->flush();

            return $this->redirectToRoute('prenda_show', array('id' => $prenda->getId()));
        }

        return $this->render('prenda/new.html.twig', array(
            'prenda' => $prenda,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a prenda entity.
     *
     * @Route("/{id}", name="prenda_show")
     * @Method("GET")
     */
    public function showAction(Prenda $prenda)
    {
        $deleteForm = $this->createDeleteForm($prenda);

        return $this->render('prenda/show.html.twig', array(
            'prenda' => $prenda,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing prenda entity.
     *
     * @Route("/{id}/edit", name="prenda_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Prenda $prenda)
    {
        $deleteForm = $this->createDeleteForm($prenda);
        $editForm = $this->createForm('AppBundle\Form\PrendaType', $prenda);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prenda_edit', array('id' => $prenda->getId()));
        }

        return $this->render('prenda/edit.html.twig', array(
            'prenda' => $prenda,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a prenda entity.
     *
     * @Route("/{id}", name="prenda_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Prenda $prenda)
    {
        $form = $this->createDeleteForm($prenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($prenda);
            $em->flush();
        }

        return $this->redirectToRoute('prenda_index');
    }

    /**
     * Creates a form to delete a prenda entity.
     *
     * @param Prenda $prenda The prenda entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Prenda $prenda)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prenda_delete', array('id' => $prenda->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
