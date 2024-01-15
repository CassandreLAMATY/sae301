<?php

namespace App\Form;

use App\Entity\Cards;
use App\Entity\Subjects;
use App\Entity\Types;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('crd_title')
            ->add('crd_desc')
            ->add('crd_from')
            ->add('crd_to')

            ->add('crd_typ', EntityType::class, [
                'class' => Types::class,
                'choice_label' => 'typ_name',
            ])
            ->add('crd_sbj', EntityType::class, [
                'class' => Subjects::class,
                'choice_label' => 'sbj_name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cards::class,
        ]);
    }
}
