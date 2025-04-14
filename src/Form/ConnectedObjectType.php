<?php

namespace App\Form;

use App\Entity\ConnectedObject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnectedObjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Caméra' => 'camera',
                    'Thermostat' => 'thermostat',
                    'Climatisation' => 'clim',
                    'Ordinateur' => 'ordinateur',
                    'Téléphone' => 'telephone',
                    'Frigo connecté' => 'frigo',
                    'Imprimante' => 'imprimante',
                    'Badgeuse' => 'badgeuse',
                    'Box internet' => 'box',
                    'Routeur' => 'routeur',
                    'TV connectée' => 'tv',
                    'Assistant vocal' => 'assistant',
                    'Serrure connectée' => 'serrure',
                    'Machine à café connectée' => 'cafetiere'
                ],
                'placeholder' => 'Choisir un type',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Actif' => 'actif',
                    'Inactif' => 'inactif',
                    'En panne' => 'en_panne',
                ],
                'label' => 'Statut',
                'placeholder' => 'Sélectionnez un statut',
                'required' => true,
                'data' => 'actif',
            ])
            ->add('location', TextType::class, ['required' => false])
            ->add('room', TextType::class, ['required' => false])
            ->add('brand', TextType::class, ['required' => false])
            ->add('description', TextareaType::class, ['required' => false])
            ->add('currentTemp', NumberType::class, ['required' => false, 'data' => 21])
            ->add('targetTemp', NumberType::class, ['required' => false, 'data' => 23])
            ->add('mode', ChoiceType::class, [
                'choices' => [
                    'Automatique' => 'auto',
                    'Refroidir' => 'cool',
                    'Chauffer' => 'heat'
                ],
                'required' => false,
            ])
            ->add('viewAngle', IntegerType::class, ['required' => false, 'data' => 120])
            ->add('resolution', TextType::class, ['required' => false, 'data' => '1080p'])
            ->add('connectivity', TextType::class, ['required' => false, 'data' => 'WiFi'])
            ->add('signal', TextType::class, ['required' => false, 'data' => 'Fort'])
            ->add('batteryLevel', IntegerType::class, ['required' => false, 'data' => 100])
            ->add('storageCapacity', IntegerType::class, ['required' => false, 'data' => 256])
            ->add('ram', IntegerType::class, ['required' => false, 'data' => 8])
            ->add('screenSize', NumberType::class, ['required' => false, 'data' => 13.3])
            ->add('os', TextType::class, ['required' => false, 'data' => 'Windows 11']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConnectedObject::class,
        ]);
    }
}

