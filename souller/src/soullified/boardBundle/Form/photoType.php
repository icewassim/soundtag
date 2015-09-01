<?php

namespace soullified\boardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class photoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array('attr' => array('class' =>'form-control','placeholder'=>'Title'),'label'=>false,'required'=>false))
            ->add('description','textarea',array('attr' => array('class' =>'form-control','placeholder'=>'Descripton' ),'label'=>false,'required'=>false))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'soullified\boardBundle\Entity\photo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'soullified_profilbundle_photo';
    }
}
