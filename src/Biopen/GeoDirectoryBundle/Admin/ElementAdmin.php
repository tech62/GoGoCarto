<?php
/**
 * @Author: Sebastian Castro
 * @Date:   2017-03-28 15:29:03
 * @Last Modified by:   Sebastian Castro
 * @Last Modified time: 2017-05-19 16:42:02
 */
namespace Biopen\GeoDirectoryBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Biopen\GeoDirectoryBundle\Document\ElementStatus;

class ElementAdmin extends AbstractAdmin
{
	private $statusChoices = [
		'-4'=>'Supprimé', 
		'-3'=>'Refusé (votes) ', 
		'-2'=>'Réfusé (admin)', 
		'-1'=>'Besoin modération', 
		'0' => 'En attente',
		'1' => 'Validé (admin)',
		'2' => 'Validé (votes)',
	];

	protected function configureFormFields(FormMapper $formMapper)
	{
	  $formMapper
	  	->add('name', 'text')
	  	->add('status', 'choice', [
               'choices'=> $this->statusChoices,
               ])
		->add('description', 'textarea')
		->add('tel', 'text', array('required' => false)) 
		->add('webSite', 'text', array('required' => false)) 
		->add('mail', 'text', array('required' => false))
		->add('openHoursMoreInfos', 'text', array('required' => false));        
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
	  $datagridMapper
	  	->add('name')
	  	->add('status', 'doctrine_mongo_choice', array(), 
        'choice', 
        array(
            'choices' => $this->statusChoices, 
	         'expanded' => false,    
	         'multiple' => false
	        )
        )
	  	->add('postalCode')
	  	->add('contributorMail');
	}

	protected function configureShowFields(ShowMapper $show)
	{
	  $show
	      ->add('id')
	      ->add('name')
	      ->add('status', 'choice', [
               'choices'=> $this->statusChoices,
               ])
	      ->add('description')
	      ->add('votes', null, array('template' => 'BiopenGeoDirectoryBundle:admin:votes_show.html.twig'))
	      ->add('address')
	      ->add('postalCode')
	      ->add('coordinates.lat')
	      ->add('coordinates.lng')
	      ->add('tel')
	      ->add('webSite')
	      ->add('mail')
	      ->add('openHoursMoreInfos')
	      ->add('contributorMail')
	      ->add('contributorIsRegisteredUser')
	      ->add('created', 'datetime', array("format" => "d/m/Y à H:m"))
	      ->add('updated', 'datetime', array("format" => "d/m/Y à H:m"));
	}

	protected function configureListFields(ListMapper $listMapper)
	{
	  $listMapper
	      ->addIdentifier('name', null,  array('editable' => true))
         ->add('status', 'choice', [
               'choices'=> $this->statusChoices,
               'editable'=>true,
               ])
         ->add('updated','date', array("format" => "d/m/Y"))
	      ->add('_action', 'actions', array(
	          'actions' => array(
	              'show' => array('template' => 'BiopenGeoDirectoryBundle:admin:list__action_show.html.twig'),
	              'edit' => array('template' => 'BiopenGeoDirectoryBundle:admin:list__action_edit.html.twig'),
	              'delete' => array('template' => 'BiopenGeoDirectoryBundle:admin:list__action_delete.html.twig'),
	              'redirect-show' => array('template' => 'BiopenGeoDirectoryBundle:admin:list__action_redirect_show.html.twig'),
	              'redirect-edit' => array('template' => 'BiopenGeoDirectoryBundle:admin:list__action_redirect_edit.html.twig')
	          )
	      ));
	}

	protected function configureRoutes(RouteCollection $collection)
	{
		$collection->add('redirectShow', $this->getRouterIdParameter().'/redirectShow');
		$collection->add('redirectEdit', $this->getRouterIdParameter().'/redirectEdit');
	}
}