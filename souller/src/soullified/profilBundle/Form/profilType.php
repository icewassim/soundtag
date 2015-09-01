<?php

namespace soullified\profilBundle\Form;
#namespace soullified\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class profilType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('fullname','text',array('attr' => array('style' => 'display:inline-block;','class'=>'inputname'),'label'=>false))
            ->add('about','textarea',array('attr' => array('placeholder' => 'About you','class'=>'form-control input-lg about'),'label'=>false,'required'=>false))
           // ->add('feedback')
            // ->add('video',new videoType(),array('required'=>false))
          #  ->add('user',new UserType(),array('required'=>false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'soullified\profilBundle\Entity\profil'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'soullified_profilbundle_profil';
    }
}
