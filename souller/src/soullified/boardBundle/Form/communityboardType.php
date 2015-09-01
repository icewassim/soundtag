<?php

namespace soullified\boardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class communityboardType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array('attr' => array('class' =>'form-control','placeholder'=>'Board Title'),'label'=>'Board Title :'))
            ->add('url','text',array('attr' => array('class' =>'form-control','placeholder'=>'Board Link'),'label'=>'Board Url  :'))
            ->add('description','textarea',array('attr' => array('class' =>'form-control description','placeholder'=>'Descripton' ),'label'=>false))
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
