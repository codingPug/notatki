<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Note;
use AppBundle\Form\NoteType;
use Symfony\Component\HttpFoundation\Response;


/**
 * Note controller.
 *
 * @Route("/")
 */
class NoteController extends Controller
{
    /**
     * Build up home page
     *
     * @Route("/", name="note_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $form = $this->createForm(NoteType::class, new Note(), ['action' => $this->generateUrl('note_new')]);

        return $this->render('note/index.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    /**
     * Get all notes JSON
     *
     * @Route("/notes/", name="note_list")
     * @Method("GET")
     */
    public function getNotesAction()
    {
        $notes = $em = $this->getDoctrine()->getRepository('AppBundle:Note')
        ->createQueryBuilder('e')
        ->select('e')
        ->getQuery()
        ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return new Response(json_encode($notes), 200);
    }

    /**
     * Creates a new Note entity.
     *
     * @Route("/new", name="note_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $note = new Note();
        $form = $this->createForm(new NoteType(), $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('note_index');
        }
    }

    /**
     * @Route("/api/del/", name="api_note_delete")
     * @Method("POST")
     */
    public function apiDeleteRequest(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $note = $em->getRepository('AppBundle:Note')->find($request->get('id'));

        $em->remove($note);
        $em->flush();

        return new Response(json_encode(['msg' => 'wpis usunieto']), 200);
    }

}
