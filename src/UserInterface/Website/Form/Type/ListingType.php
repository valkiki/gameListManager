<?php

declare(strict_types=1);

namespace App\UserInterface\Website\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('Save', SubmitType::class, array('label' => 'Create Listing'));
    }
}
