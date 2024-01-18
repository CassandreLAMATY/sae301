<?php

namespace App\Form;

use App\Entity\Cards;
use App\Entity\Subjects;
use App\Entity\Types;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;


class CardsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('crd_typ', EntityType::class, [
                'class' => Types::class,
                'choice_label' => 'typ_name',
                'attr' => ['id' => 'crd_typ'],
                'placeholder' => 'Choisissez un type d\'évènement',
                'required' => true,
            ])

            //->addEventSubscriber(new CardsFormListener())
            ->add('crd_title',TextType::class ,  [
                'attr' => ['id' => 'crd_title'],
            ])
            ->add('crd_desc',   TextType::class, [
                'attr' => ['id' => 'crd_desc'],
            ])

            ->add('crd_from', DateTimeType::class, [
                'attr' => ['id' => 'crd_from'],
                'required' => false,
            ])
            ->add('crd_to', DateTimeType::class, [
                'attr' => ['id' => 'crd_to'],
            ])
            ->add('crd_sbj', EntityType::class, [
                'class' => Subjects::class,
                'choice_label' => 'sbj_name',
                'required' => false,
            ])
            ->add('crd_grp', ChoiceType::class, [
                'choices' => [
                    'TD' => true,
                    'TP' => false,
                ],
                'attr' => ['id' => 'crd_grp'],
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cards::class,
        ]);
    }
}
