<?php

// src/UserBundle/EventListener/ConnexionListener.php

namespace UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FraisBundle\Entity\FicheFrais;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class ConnexionListenner implements EventSubscriberInterface
{
    private $router;
    //private $tokenStorage;
    private $doctrine;

    public function __construct(UrlGeneratorInterface $router, $doctrine /*, TokenStorage $tokenStorage*/)
    {
        $this->router = $router;
        //$this->tokenStorage = $tokenStorage;
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::SECURITY_IMPLICIT_LOGIN => array('fos_user.security.implicit_login', -10)
        );
    }

    public function VerificationFicheFraisExist(FormEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $fichefrais = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FicheFraisBundle:FicheFrais')
            ->getLastEntity($user)
        ;
        if (!null == $fichefrais)
        {
            $month = $ficheFrais->getMonth();
            if (date('M') != $ficheFrais->getMonth()) 
                {
                    $ficheFrais = new FicheFrais();
                    $em = $doctrine->getManager();
                    $em->persist($ficheFrais);
                    $em->flush();
                }
        }
        else
        {
            $ficheFrais = new FicheFrais();
            $em = $doctrine->getManager();
                    $em->persist($ficheFrais);
                    $em->flush();
        }


        $url = $this->router->generate('fichefrais_index');

        $event->setResponse(new RedirectResponse($url));
    }
}