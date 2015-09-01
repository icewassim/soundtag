<?php

namespace soullified\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
          //  ->add('username','text',array('attr' => array('placeholder' => 'Name','class'=>'form-control input-lg'),'label'=>false)) 
          //  ->add('salt')
            ->add('password','password',array('attr' => array('placeholder' => 'Password','class'=>'form-control input-lg'),'label'=>false))
            ->add('email','email',array('attr' => array('placeholder' => 'Email','class'=>'form-control input-lg'),'label'=>false))
          //  ->add('isActive')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'soullified\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'soullified_userbundle_user';
    }
}
