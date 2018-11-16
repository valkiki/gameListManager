<?php

declare(strict_types=1);

namespace App\UserInterface\Website\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ListingType extends AbstractType
{
    public function buildForm
    (
        FormBuilderInterface $builder,
        array $options
    )
    {
        $builder
            ->add('name', TextType::class)
            ->add('Save', SubmitType::class, array('label' => 'Create Listing'));
    }
}