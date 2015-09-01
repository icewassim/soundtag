<?php

namespace soullified\boardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class boardType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array('attr' => array('class' =>'form-control','placeholder'=>'Title'),'label'=>'Board Title :'))
            ->add('url','text',array('attr' => array('class' =>'form-control','placeholder'=>'Link'),'label'=>'Board Url  :'))
            ->add('description','textarea',array('attr' => array('class' =>'form-control description','placeholder'=>'Descripton' ),'label'=>false,'required'=>false))
            ->add('Viewprivacy','choice',array('choices'=>array('public' =>'Every one' ,'friends'=>'My Friends','owner'=>'Only me' ),'label'=>'Who can See your Board :'))
            ->add('Commentprivacy','choice',array('choices'=>array('public' =>'Every one' ,'friends'=>'My Friends','owner'=>'Only me' ),'label'=>'Who can Write on you  Board :'))       
       ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'soullified\boardBundle\Entity\board'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'soullified_profilbundle_board';
    }
}
