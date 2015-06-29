<?php

namespace JorgeLillo\TopGamesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', 'text', array('label' => 'Usuario')
                )
                ->add('password', 'password', array('label' => 'Contraseña')
                )
                ->add('isAdmin', 'checkbox', array(
                    'label' => '¿Administrador?',
                    'required' => FALSE,
                        )
                )
                ->add('isActive', 'checkbox', array(
                    'label' => '¿Activo?',
                    'required' => FALSE,
                        )
                )
                ->add('email', 'email', array(
                    'label' => 'Correo Electrónico'))
                ->add('createTime', 'datetime', array('label' => 'Fecha de alta'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'JorgeLillo\TopGamesBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'topgamesbundle_usuario';
    }

}
