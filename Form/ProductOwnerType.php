<?php

namespace MP\Bundle\CatalogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductOwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('postCode')
            ->add('city')
            ->add('country')
            ->add('phone')
            ->add('mail')
            ->add('ownerClass')
            ->add('ownerId')
            ->add('ownerHash')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MP\Bundle\CatalogBundle\Entity\ProductOwner'
        ));
    }

    public function getName()
    {
        return 'mp_bundle_catalogbundle_productownertype';
    }
}
