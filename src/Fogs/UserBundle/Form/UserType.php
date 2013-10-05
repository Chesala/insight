<?php

namespace Fogs\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('read_only' => true))
        	->add('profile', 'entity', array(
            	'class'		=> 'Fogs\InsightBundle\Entity\Profile',
            	'property'	=> 'name'		
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fogs\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'fogs_userbundle_usertype';
    }
}
