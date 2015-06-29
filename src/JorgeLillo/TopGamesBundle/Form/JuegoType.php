<?php

namespace JorgeLillo\TopGamesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JuegoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('titulo', 'text', array(
                    'attr' => array('style' => 'width: 400px')
                ))
                ->add('descripcion', 'textarea', array(
                    'attr' => array('class' => 'bigTextArea')
                ))
                ->add('file', 'file', array(
                    'attr' => array('style' => 'margin-bottom: 10px')
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'JorgeLillo\TopGamesBundle\Entity\Juego',
            'required' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'jorgelillo_topgamesbundle_juego';
    }

}
