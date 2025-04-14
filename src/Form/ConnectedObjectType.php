<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Entity\ConnectedObject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnectedObjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'objet'  
            ])
            ->add('type', TextType::class, [
                'label' => 'Type de l\'objet'  
            ])
            ->add('brand', TextType::class, [
                'required' => false,
                'label' => 'Marque de l\'objet'  
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Actif' => 'actif',
                    'Inactif' => 'inactif',
                ],
                'label' => 'Statut de l\'objet'  
            ])
            ->add('location', TextType::class, [
                'required' => false,
                'label' => 'Emplacement de l\'objet'  
            ])
            ->add('room', TextType::class, [
                'required' => false,
                'label' => 'Zone/Pièce'  
            ])
            ->add('lastUsedAt', DateTimeType::class, [
                'required' => false,
                'label' => 'Dernière utilisation',
                'widget' => 'single_text',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description de l\'objet'  
            ])
            ->add('owner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'pseudo',
                'required' => false,
                'label' => 'Utilisateur associé'  
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConnectedObject::class,
        ]);
    }
}
