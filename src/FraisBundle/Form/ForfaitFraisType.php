<?php

namespace FraisBundle\Form;

use Sensio\Bundle\GeneratorBundle\Model\Bundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FraisBundle\Repository\ForfaitRepository;
use FraisBundle\Entity\Forfait;


use Doctrine\ORM\QueryBuilder;


class ForfaitFraisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            //->add('Type', ChoiceType::class, array(
            //    'choices'  => array(
            //    'Repas' => 'repas',
            //    'Nuitée' => 'nuitee',
            //    'Repas + Nuitée' => 'repas + nuitee',
            //    'frais transport' => 'frais transport',
            //),))
            ->add('dateDuFrais')
            ->add('Type', EntityType::class, array(
                'class'        => 'FraisBundle:Forfait',
                'choice_label' => 'wording',
                'multiple'     => false,
            ))

        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FraisBundle\Entity\ForfaitFrais'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fraisbundle_forfaitfrais';
    }


}
