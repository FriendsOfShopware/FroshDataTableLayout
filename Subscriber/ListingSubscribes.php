<?php

namespace FroshDataTableLayout\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Connection;
use Enlight\Event\SubscriberInterface;
use Shopware\Components\Theme\LessDefinition;

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
     * @var string
     */
    private $jsonListingCountResponse = '';

    /**
     * TemplateRegistration constructor.
     *
     * @param Connection $connection
     */
    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
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
        ];
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
        if (strtolower($args->getRequest()->getActionName()) === 'index') {
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
