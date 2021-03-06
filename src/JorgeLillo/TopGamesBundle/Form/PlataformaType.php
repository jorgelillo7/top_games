<?php

namespace JorgeLillo\TopGamesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlataformaType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nombre')
                ->add('color');

        $builder->add('letraBlanca', 'checkbox', array(
            'label' => 'Letra blanca',
            'required' => false,
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'JorgeLillo\TopGamesBundle\Entity\Plataforma'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'jorgelillo_topgamesbundle_plataforma';
    }

}
