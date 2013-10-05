<?php

namespace Fogs\InsightBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotNull;

class searchType extends AbstractType
{
	
	const SUBJECT_TYPE_OFFER = 'offer';
	const SUBJECT_TYPE_INQUIRY = 'inquiry';
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('subject', 'choice', array(
   				'choices'   => array(
   						self::SUBJECT_TYPE_OFFER => 'Reisender', 
   						self::SUBJECT_TYPE_INQUIRY => 'Gastgeber'
   				),
        		'empty_value' => 'Ich bin..',
        		'label'		=> ' ',
	            'attr' 		=> array('class' => 'input-medium'),
        		)
        	)
        	->add('object', 'choice', array(
   				'choices'   => array('accomodation' => 'Übernachtung', 'company' => 'Gesellschaft', 'sightseeing' => 'Führungen'),
        		'empty_value' => 'und suche/biete..',
        		'label'		=> ' ',
	            'attr' 		=> array('class' => 'input-medium'),
        		)
        	)
        	->add('location', 'locationpicker', array(
	        	'hide_map'	=> true,
	        	'typeahead'	=> true,
        		'label'		=> ' ',
	        	'attr' 		=> array('placeholder' => 'in Region / Ort'),
        		'constraints' => array(new NotNull()),
	        	)
	        )
        	->add('radius', 'choice', array(
   				'choices'   => array(1 => '1 km', 2 => '2 km', 5 => '5 km', 10 => '10 km', 25 => '25 km'),
        		'empty_value' => 'Entfernung',
        		'label'		=> ' ',
	            'attr' 		=> array('class' => 'input-medium'),
        		)
        	)
	        ->add('validFrom','date',array(
	            'widget'	=> 'single_text',
	            'format'	=> 'dd.MM.yyyy',
	            'attr' 		=> array('class' => 'input-small futuredate', 'placeholder' => 'von'),
            	'required'	=> false,
        		'label'		=> ' ',
        	))
            ->add('validUntil','date',array(
	            'widget'	=> 'single_text',
	            'format'	=> 'dd.MM.yyyy',
	            'attr' 		=> array('class' => 'input-small futuredate', 'placeholder' => 'bis'),
            	'required'	=> false,
        		'label'		=> ' ',
            ))
        ;
    }

    public function getName()
    {
        return 'fogs_insightbundle_searchtype';
    }
}
