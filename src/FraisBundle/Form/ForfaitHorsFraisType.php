<?php
namespace FraisBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class ForfaitHorsFraisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('wording')
            ->add('price')
            ->add('dateDuFrais', DateType::class, array('required' => false, 'widget' =>'single_text'))
            ->add('comment')
            ->add('pieceJointe', FileType::class, array('required' => false))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FraisBundle\Entity\ForfaitHorsFrais'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fraisbundle_forfaithorsfrais';
    }
}
