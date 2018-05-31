<?php

namespace Biopen\GeoDirectoryBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ImportAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('sourceName', 'text', array('required' => false, 'label' => 'Nom de la source'))
            ->add('fileToImport', 'file', array('label' => 'Fichier à importer'))
            ->add('geocodeIfNecessary', null, array('required' => false, 'label' => 'Géocoder si élements sans latitude ni longitude'))
            ->add('createMissingOptions', null, array('required' => false, 'label' => 'Créer les options manquantes'))
            ->add('parentCategoryToCreateOptions', 'sonata_type_model', array(
                'class'=> 'Biopen\GeoDirectoryBundle\Document\Category', 
                'required' => false, 
                'choices_as_values' => true,
                'label' => 'Catégorie parente pour créer les options manquantes',
                'mapped' => true), array('admin_code' => 'admin.category'))
        ;
    }
   protected function configureRoutes(RouteCollection $collection)
   {
      $collection->add('execute', $this->getRouterIdParameter().'/execute');
   }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
        ;
    }
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fileName')
            //->add('link', 'string', array('template' => 'KPhoenSingleUploadableBundle:Image:list_link.html.twig'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                )
            ))
        ;
    }
}