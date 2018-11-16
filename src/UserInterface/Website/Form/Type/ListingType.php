<?php

declare(strict_types=1);

namespace App\UserInterface\Website\Form\Type;

use App\Core\Listing\Entity\Listing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ListingType
 * @package App\UserInterface\Website\Form\Type
 */
class ListingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder
            ->add('name', TextType::class)
            ->add('Save', SubmitType::class, ['label' => 'listing.create']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
            'translation_domain' => 'listing'
        ]);
    }
}
