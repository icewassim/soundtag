<?php

namespace soullified\profilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class friendrequestType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content','textarea',array('attr' => array('class' =>'form-control','placeholder'=>'Descripton' ),'required'=>false,'label'=>false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'soullified\profilBundle\Entity\friendrequest'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'soullified_profilbundle_friendrequest';
    }
}
