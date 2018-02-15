<?php
namespace FraisBundle\Controller;
use FraisBundle\Entity\FicheFrais;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
 * Fichefrai controller.
 *
 */
class FicheFraisController extends Controller
{
    /**
     * Lists all ficheFrai entities.
     *
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $ficheFrais = $em->getRepository('FraisBundle:FicheFrais')->getFraisByDate($user);
        $forfaitHorsFrais = $em->getRepository('FraisBundle:ForfaitHorsFrais')->findAll();
        $forfaitFrais = $em->getRepository('FraisBundle:ForfaitFrais')->findAll();
        return $this->render('fichefrais/index.html.twig', array(
            'ficheFrais' => $ficheFrais,
            'forfaitHorsFrais' => $forfaitHorsFrais,
            'forfaitFrais' => $forfaitFrais,
        ));
    }
    /**
     * Creates a new ficheFrai entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        /*if (null !== $user->getFicheFrais())
           {
                $ficheFrais = $user->getFicheFrais();
                dump($ficheFrais);
                if (date('M') != $ficheFrais->getMonth()) 
                {
                    # code...
                }
           } */
        
        
        $userId = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $ficheFrais = new Fichefrais();
        $form = $this->createForm('FraisBundle\Form\FicheFraisType', $ficheFrais);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ficheFrais->setUser($user);
            $em->persist($ficheFrais);
            $em->flush();
            return $this->redirectToRoute('fichefrais_show', array('id' => $ficheFrais->getId()));
        }
        return $this->render('fichefrais/new.html.twig', array(
            'ficheFrai' => $ficheFrais,
            'form' => $form->createView(),
        ));
    }
    /**
     * Finds and displays a ficheFrai entity.
     *
     */
    public function showAction(FicheFrais $ficheFrai)
    {
        $deleteForm = $this->createDeleteForm($ficheFrai);
        return $this->render('fichefrais/show.html.twig', array(
            'ficheFrai' => $ficheFrai,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Displays a form to edit an existing ficheFrai entity.@
     *
     */
    public function editAction(Request $request, FicheFrais $ficheFrais) //Modifier en addhorsfrait
    {
        return $this->redirectToRoute('forfaithorsfrais_new', array(
            'ficheFraisId' => $ficheFrais->getId()));
    }

    public function addForfaitFraisAction(Request $request, FicheFrais $ficheFrais) //Modifier en addhorsfrait
    {
        return $this->redirectToRoute('forfaitfrais_new', array(
            'ficheFraisId' => $ficheFrais->getId()));
    }

    /**
     * Deletes a ficheFrai entity.
     *
     */
    public function deleteAction(Request $request, FicheFrais $ficheFrai)
    {
        $form = $this->createDeleteForm($ficheFrai);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ficheFrai);
            $em->flush();
        }
        return $this->redirectToRoute('fichefrais_index');
    }
    /**
     * Creates a form to delete a ficheFrai entity.
     *
     * @param FicheFrais $ficheFrai The ficheFrai entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FicheFrais $ficheFrai)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fichefrais_delete', array('id' => $ficheFrai->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
