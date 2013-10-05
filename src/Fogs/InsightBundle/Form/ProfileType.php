<?php

namespace Fogs\InsightBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dateOfBirth','date',array(
	            'widget'	=> 'single_text',
	            'format'	=> 'dd.MM.yyyy',
	            'attr' 		=> array('class' => 'birthdate'),
            	'required'	=> false
	        ))
            ->add('description')
            ->add('tags', 'tags');
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fogs\InsightBundle\Entity\Profile'
        ));
    }

    public function getName()
    {
        return 'fogs_insightbundle_profiletype';
    }
}
