<?php

namespace JorgeLillo\TopGamesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListaType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nombre', "text", array(
                    'attr' => array('style' => 'margin-bottom: 10px; margin-top:10px')
                ))
                ->add('descripcion', "text", array(
                    'attr' => array('style' => 'margin-bottom: 10px; width:300px')
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'JorgeLillo\TopGamesBundle\Entity\Lista'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'jorgelillo_topgamesbundle_lista';
    }

}
