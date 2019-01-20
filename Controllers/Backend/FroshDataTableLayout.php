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
        $id = (int) $this->Request()->get('id');
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

        if ($id) {
            $qb->where('id = :id')->setParameter(':id', $id);
        }

        $data = $qb->execute()->fetchAll();

        $this->View()->assign(
            [
                'success' => true,
                'data' => $data,
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function createColumnAction()
    {
        $params = $this->Request()->getPost();

        $position = (int) $this->container->get('dbal_connection')
            ->fetchColumn('SELECT COUNT(*) FROM data_table_columns');

        $params['position'] = $position;

        $this->getModelManager()->getConnection()->insert(
            'data_table_columns',
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
        $params = $this->Request()->getPost();
        $id = (int) $this->Request()->get('id');

        $this->getModelManager()->getConnection()->update(
            'data_table_columns',
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

        $qb = $this->getModelManager()->getDBALQueryBuilder();
        $qb->select(
                [
                    'position',
                ]
            )
            ->from('data_table_columns')
            ->where('id = :id')
            ->setParameter(':id', $id)
        ;

        $index = (int) $qb->execute()->fetchColumn();

        $stmt = $this->container->get('dbal_connection')
            ->prepare('UPDATE `data_table_columns` SET `position` = `position` - 1 WHERE `position` > :pos');

        $stmt->bindParam(':pos', $index);
        $stmt->execute();

        $this->getModelManager()->getConnection()->delete(
            'data_table_columns',
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
    public function updatePositionAction()
    {
        $id = (int) $this->Request()->get('id');
        $index = (int) $this->Request()->get('index');

        $qb = $this->getModelManager()->getDBALQueryBuilder();
        $qb->select(
                [
                    'position',
                ]
            )
            ->from('data_table_columns')
            ->where('id = :id')
            ->setParameter(':id', $id)
        ;

        $oldPos = (int) $qb->execute()->fetchColumn();

        if ($oldPos > $index) {
            $stmt = $this->container->get('dbal_connection')
                ->prepare('UPDATE `data_table_columns` SET `position` = `position` + 1 WHERE `position` <= :pos AND `position` >= :index');
        } else {
            $stmt = $this->container->get('dbal_connection')
                ->prepare('UPDATE `data_table_columns` SET `position` = `position` - 1 WHERE `position` >= :pos AND `position` <= :index');
        }
        $stmt->bindParam(':pos', $oldPos);
        $stmt->bindParam(':index', $index);
        $stmt->execute();

        $stmt = $this->container->get('dbal_connection')
            ->prepare('UPDATE `data_table_columns` SET `position` = :pos WHERE `id` = :id');

        $stmt->bindParam(':pos', $index);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $this->View()->assign(
            [
                'success' => true,
            ]
        );
    }
}
