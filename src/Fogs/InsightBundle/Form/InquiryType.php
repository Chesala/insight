<?php

namespace Fogs\InsightBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityRepository;

class InquiryType extends AbstractType
{
	/**
	 * @var SecurityContext
	 */
	private $securityContext;
	
	public function __construct(SecurityContext $securityContext)
	{
		$this->securityContext = $securityContext;
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
	        ->add('location', 'locationpicker', array(
				'typeahead'	=> true,
	        	'required'	=> false
	        ))
        ;

	    // admins can also edit the traveller of this inquiry
	    if ($this->securityContext->isGranted('ROLE_ADMIN')) {
	    	$builder->add('traveller', 'entity', array(
	    			'class'			=> 'Fogs\UserBundle\Entity\User',
	    			'query_builder' => function(EntityRepository $er) {
	    				return $er->createQueryBuilder('u')
	    				->orderBy('u.username', 'ASC');
	    			},
	    	));
	    }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fogs\InsightBundle\Entity\Inquiry'
        ));
    }

    public function getName()
    {
        return 'fogs_insightbundle_inquirytype';
    }
}
