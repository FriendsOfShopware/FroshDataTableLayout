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
     * @var string
     */
    private $jsonListingCountResponse = '';

    /**
     * TemplateRegistration constructor.
     *
     * @param $pluginDirectory
     * @param \Enlight_Template_Manager            $templateManager
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
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'onPreDispatch',
            'Shopware_Controllers_Widgets_Listing_fetchListing_preFetch' => 'onFetchListingPreFetch',
            'Enlight_Controller_Action_PostDispatchSecure_Widgets_Listing' => 'onListingPostDispatch',
            'Theme_Compiler_Collect_Plugin_Javascript' => 'addJsFiles',
            'Theme_Compiler_Collect_Plugin_Less' => 'addLessFiles',
        ];
    }

    public function onPreDispatch()
    {
        $this->templateManager->addTemplateDir($this->pluginDirectory . '/Resources/views');
    }

    public function onFetchListingPreFetch(\Enlight_Event_EventArgs $args)
    {
        $subject = $args->get('subject');
        $result = $args->get('result');
        $productBoxLayout = $subject->View()->getAssign('productBoxLayout');

        if ($productBoxLayout === 'data_table') {
            $recordsTotal = $result->getTotalCount();

            $body = [
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsTotal,
                'data' => array_values($subject->View()->getAssign('sArticles')),
            ];

            $this->jsonListingCountResponse = json_encode($body);
        }
    }

    public function onListingPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        if (
            strtolower($args->getRequest()->getActionName()) === 'listingcount' &&
            $this->jsonListingCountResponse
        ) {
            $args->getResponse()->setBody($this->jsonListingCountResponse);
        }
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function addJsFiles()
    {
        $jsFiles = [
            $this->pluginDirectory . '/Resources/views/frontend/_public/src/js/jquery.dataTables.js',
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
            ],
            $this->pluginDirectory
        );

        return new ArrayCollection([$less]);
    }
}
