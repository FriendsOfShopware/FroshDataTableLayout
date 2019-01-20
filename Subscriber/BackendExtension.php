<?php

namespace FroshDataTableLayout\Subscriber;

use Enlight\Event\SubscriberInterface;

class BackendExtension implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDir;

    /**
     * @param string $pluginDir
     */
    public function __construct($pluginDir)
    {
        $this->pluginDir = $pluginDir;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Backend_Category' => 'onBackendCategoryPostDispatch',
        ];
    }

    /**
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function onBackendCategoryPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        /** @var $view \Enlight_View_Default */
        $view = $args->getSubject()->View();

        $view->addTemplateDir(
            $this->pluginDir . '/Resources/views/backend/'
        );

        if ($args->getRequest()->getActionName() === 'load') {
            $templates = [
                'base/Shopware.apps.Base.store.ProductBoxLayout.js',
            ];
            foreach ($templates as $template) {
                $view->extendsTemplate($template);
            }
        }
    }
}
