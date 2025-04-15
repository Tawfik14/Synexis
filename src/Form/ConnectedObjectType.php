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
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('type', ChoiceType::class, [
                'label' => 'Type d\'objet',
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
                'label' => 'Statut',
                'choices' => [
                    'Actif' => 'actif',
                    'Inactif' => 'inactif',
                    'En panne' => 'en_panne',
                ],
                'placeholder' => 'Sélectionnez un statut',
                'required' => true,
                'data' => 'actif',
            ])
            ->add('location', TextType::class, ['required' => false, 'label' => 'Localisation'])
            ->add('room', TextType::class, ['required' => false, 'label' => 'Pièce'])
            ->add('brand', TextType::class, ['required' => false, 'label' => 'Marque'])
            ->add('description', TextareaType::class, ['required' => false, 'label' => 'Description'])
            ->add('currentTemp', NumberType::class, ['required' => false, 'data' => 21, 'label' => 'Température actuelle (°C)'])
            ->add('targetTemp', NumberType::class, ['required' => false, 'data' => 23, 'label' => 'Température cible (°C)'])
            ->add('mode', ChoiceType::class, [
                'label' => 'Mode',
                'choices' => [
                    'Automatique' => 'auto',
                    'Refroidir' => 'cool',
                    'Chauffer' => 'heat'
                ],
                'required' => false,
            ])
            ->add('viewAngle', IntegerType::class, ['required' => false, 'data' => 120, 'label' => 'Angle de vue (°)'])
            ->add('resolution', TextType::class, ['required' => false, 'data' => '1080p', 'label' => 'Résolution'])
            ->add('connectivity', TextType::class, ['required' => false, 'data' => 'WiFi', 'label' => 'Connectivité'])
            ->add('signal', TextType::class, ['required' => false, 'data' => 'Fort', 'label' => 'Signal'])
            ->add('batteryLevel', IntegerType::class, ['required' => false, 'data' => 100, 'label' => 'Batterie (%)'])
            ->add('storageCapacity', IntegerType::class, ['required' => false, 'data' => 256, 'label' => 'Stockage (Go)'])
            ->add('ram', IntegerType::class, ['required' => false, 'data' => 8, 'label' => 'RAM (Go)'])
            ->add('screenSize', NumberType::class, ['required' => false, 'data' => 13.3, 'label' => 'Taille écran (pouces)'])
            ->add('os', TextType::class, ['required' => false, 'data' => 'Windows 11', 'label' => 'Système d\'exploitation']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConnectedObject::class,
        ]);
    }
}
