<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new Softwarebetrieb\ToolsBundle\SoftwarebetriebToolsBundle(),
            new Fogs\InsightBundle\FogsInsightBundle(),
            new Fogs\UserBundle\FogsUserBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

    public function getCacheDir()
    {
    	if (get_cfg_var('system.cache_dir')) {
    		return get_cfg_var('system.cache_dir').DIRECTORY_SEPARATOR.$this->getApplicationName().DIRECTORY_SEPARATOR.$this->environment;
    	} else {
    		return parent::getCacheDir();
    	}
    }

    public function getLogDir()
    {
    	if (get_cfg_var('system.log_dir')) {
    		return get_cfg_var('system.log_dir').DIRECTORY_SEPARATOR.$this->getApplicationName().DIRECTORY_SEPARATOR.$this->environment;
    	} else {
    		return parent::getLogDir();
    	}
    }

    public function getApplicationName()
    {
    	return basename(dirname(dirname(__FILE__)));
    }

    public function init()
    {
    	umask(0007);
    	parent::init();
    }
}
