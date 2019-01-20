<?php

class Shopware_Controllers_Backend_FroshDataTableLayout extends Shopware_Controllers_Backend_ExtJs
{
    public function indexAction()
    {
        $this->View()->loadTemplate('backend/frosh_data_table_layout/app.js');
    }

    /**
     * @throws Exception
     */
    public function listColumnsAction()
    {
        $qb = $this->getModelManager()->getDBALQueryBuilder();

        $qb->select(
                [
                    'SQL_CALC_FOUND_ROWS id',
                    'label',
                    'property',
                    'render',
                    'position',
                ]
            )
            ->from('data_table_columns')
            ->orderBy('position', 'asc')
        ;

        $data = $qb->execute()->fetchAll();

        $total = (int) $this->container->get('dbal_connection')->fetchColumn('SELECT FOUND_ROWS()');

        $this->View()->assign(
            ['success' => true, 'data' => $data, 'total' => $total]
        );
    }

    /**
     * @throws Exception
     */
    public function createColumnAction()
    {
        $params = $this->Request()->getParams();

        $this->getModelManager()->getConnection()->insert(
            'dne_custom_js_css',
            $params
        );

        $this->View()->assign(
            [
                'success' => true,
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function updateColumnAction()
    {
        $params = $this->Request()->getParams();
        $id = (int) $this->Request()->get('id');

        $this->getModelManager()->getConnection()->update(
            'dne_custom_js_css',
            $params,
            ['id' => $id]
        );

        $this->View()->assign(
            [
                'success' => true,
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function deleteColumnAction()
    {
        $id = (int) $this->Request()->get('id');

        $this->getModelManager()->getConnection()->delete(
            'dne_custom_js_css',
            ['id' => $id]
        );

        $this->View()->assign(
            [
                'success' => true,
            ]
        );
    }
}