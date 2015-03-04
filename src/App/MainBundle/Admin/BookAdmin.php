<?php

namespace App\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class BookAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('authors', null, array('label' => 'app.main_bundle_author'), null, array('expanded' => true, 'multiple' => true))
            ->add('title')
            ->add('isbn')
            ->add('genre')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('authors', null, array(
                'sortable' => true,
                'editable' => false,
                'sort_field_mapping'=> array('fieldName'=>'name'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'authors'))
            ))
            ->add('isbn', null, ['sortable' => false])
            ->add('title')
            ->add('genre', null, array(
                'sortable' => true,
                'editable' => false,
                'sort_field_mapping' => array('fieldName'=>'type'),
                'sort_parent_association_mappings' => array(array('fieldName'=>'genre'))
    ))
            ->add('publisher')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))

        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('authors')
            ->add('title')
            ->add('isbn')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('isbn')
            ->add('id')
        ;
    }
}
