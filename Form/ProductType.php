<?php

namespace MP\Bundle\CatalogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('wholeSalePrice')
            ->add('price')
            ->add('description')
            ->add('ean')
            ->add('reference')
            ->add('isEnabled')
            ->add('categories')
            ->add('owner')
            ->add('brand')
            ->add('features', 'collection', array(
                'type' => new FeatureType(),
                'allow_add' => true,
                'by_reference' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MP\Bundle\CatalogBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'mp_bundle_catalogbundle_producttype';
    }
}
