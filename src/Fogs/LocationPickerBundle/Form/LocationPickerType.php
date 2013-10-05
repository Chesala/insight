<?php

namespace Fogs\LocationPickerBundle\Form;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\FormView;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

class LocationPickerType extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$transformer = new LocationTransformer();
		$builder->addModelTransformer($transformer);
	}
	
	public function getParent()
	{
		return 'text';
	}

	public function getName()
	{
		return 'locationpicker';
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'typeahead' 		=> false,
        	'hide_map'			=> false,
        	'map_zoom'			=> 10,
        	'marker_drabbable'	=> true,
        	'debug'				=> false,
        ));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
   		$view->vars['typeahead'] 		= $options['typeahead'];
   		$view->vars['hide_map'] 		= $options['hide_map'];
   		$view->vars['map_zoom'] 		= $options['map_zoom'];
   		$view->vars['marker_drabbable']	= $options['marker_drabbable'] ? 'true' : 'false';
   		$view->vars['debug']			= $options['debug'];
   		$view->vars['js_name']			= str_replace(array('[', ']'), array('_', ''), $view->vars['full_name']);
    }

}