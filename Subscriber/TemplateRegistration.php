<?php

namespace FroshDataTableLayout\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Shopware\Components\Theme\LessDefinition;

/**
 * Class TemplateRegistration
 */
class TemplateRegistration implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @var \Enlight_Template_Manager
     */
    private $templateManager;

    /**
     * TemplateRegistration constructor.
     *
     * @param $pluginDirectory
     * @param \Enlight_Template_Manager $templateManager
     */
    public function __construct(
        $pluginDirectory,
        \Enlight_Template_Manager $templateManager
    ) {
        $this->pluginDirectory = $pluginDirectory;
        $this->templateManager = $templateManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch',
            'Theme_Compiler_Collect_Plugin_Javascript' => 'addJsFiles',
            'Theme_Compiler_Collect_Plugin_Less' => 'addLessFiles',
        ];
    }

    public function onPreDispatch()
    {
        $this->templateManager->addTemplateDir($this->pluginDirectory . '/Resources/views');
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function addJsFiles()
    {
        $jsFiles = [
            $this->pluginDirectory . '/Resources/views/frontend/_public/src/js/jquery.dataTables.js',
            $this->pluginDirectory . '/Resources/views/frontend/_public/src/js/dataTables.responsive.js',
            $this->pluginDirectory . '/Resources/views/frontend/_public/src/js/jquery.init-dataTables.js',
        ];

        return new ArrayCollection($jsFiles);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function addLessFiles()
    {
        $less = new LessDefinition(
            [],
            [
                $this->pluginDirectory . '/Resources/views/frontend/_public/src/less/jquery.dataTables.less',
                $this->pluginDirectory . '/Resources/views/frontend/_public/src/less/responsive.dataTables.less',
            ],
            $this->pluginDirectory
        );

        return new ArrayCollection([$less]);
    }
}
