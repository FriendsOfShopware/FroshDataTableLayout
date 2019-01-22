<?php

namespace FroshDataTableLayout\Subscriber;

use Doctrine\DBAL\Connection;
use Enlight\Event\SubscriberInterface;

/**
 * Class ListingSubscribes
 */
class ListingSubscribes implements SubscriberInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var \Shopware_Components_Config
     */
    private $config;

    /**
     * @var \Enlight_Controller_Front
     */
    private $front;

    /**
     * @var null|string
     */
    private $jsonListingCountResponse = null;

    /**
     * @param Connection                  $connection
     * @param \Shopware_Components_Config $config
     * @param \Enlight_Controller_Front   $front
     */
    public function __construct(
        Connection $connection,
        \Shopware_Components_Config $config,
        \Enlight_Controller_Front $front
    ) {
        $this->connection = $connection;
        $this->config = $config;
        $this->front = $front;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Controllers_Widgets_Listing_fetchListing_preFetch' => 'onFetchListingPreFetch',
            'Enlight_Controller_Action_PostDispatchSecure_Widgets_Listing' => 'onListingWidgetsPostDispatch',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Listing' => 'onListingFrontendPostDispatch',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Search' => 'onListingFrontendPostDispatch',
        ];
    }

    public function onFetchListingPreFetch(\Enlight_Event_EventArgs $args)
    {
        $subject = $args->get('subject');
        $result = $args->get('result');

        if ($this->front->Request()->get('isSearch')) {
            $productBoxLayout = $this->config->get('searchProductBoxLayout');
        } else {
            $productBoxLayout = $subject->View()->getAssign('productBoxLayout');
        }

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

    public function onListingWidgetsPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        if (
            strtolower($args->getRequest()->getActionName()) === 'listingcount' &&
            $this->jsonListingCountResponse
        ) {
            $args->getResponse()->setBody($this->jsonListingCountResponse);
        }
    }

    public function onListingFrontendPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        if (in_array(strtolower($args->getRequest()->getActionName()), ['index', 'defaultsearch'])) {
            $qb = $this->connection->createQueryBuilder();

            $qb->select(
                    [
                        'id',
                        'label',
                        'property',
                        'render',
                        'position',
                    ]
                )
                ->from('data_table_columns')
                ->orderBy('position', 'asc')
            ;

            $args->getSubject()->View()->assign('dataTableListingColumns', $qb->execute()->fetchAll());
        }
    }
}
