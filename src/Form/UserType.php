<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\DateType; 

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var User $user */
        $user = $options['data'] ?? null;
        $points = $user?->getPoints() ?? 0;

        $levelChoices = [];
        $levelChoices['Débutant'] = 'debutant';
        if ($points >= 15) {
            $levelChoices['Intermédiaire'] = 'intermediaire';
        }
        if ($points >= 35) {
            $levelChoices['Avancé'] = 'avance';
        }
        if ($points >= 60) {
            $levelChoices['Expert'] = 'expert';
        }

        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo',
            ])
            ->add('gender', ChoiceType::class, [
            'label' => 'Genre',
                'choices' => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                    'Autre' => 'autre',
                ],
                'placeholder' => 'Sélectionnez votre genre',
            ])
            ->add('dob', DateType::class, [
    'label' => 'Date de naissance',
    'widget' => 'single_text',
    'required' => false,
])

            ->add('level', ChoiceType::class, [
                'choices' => $levelChoices,
                'placeholder' => 'Sélectionnez votre niveau',
                'required' => true,
            ])
            ->add('points', IntegerType::class, [
                'required' => false,
                'label' => 'Points',
                'disabled' => true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'required' => false,
            ]);

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            /** @var User $user */
            $user = $event->getData();
            $level = $user->getLevel();
            $currentRoles = $user->getRoles();

            if ($level === 'expert' && !in_array('ROLE_ADMIN', $currentRoles)) {
                $user->setRoles(['ROLE_ADMIN']);
            } elseif ($level === 'avance' && !in_array('ROLE_ADMIN', $currentRoles)) {
                $user->setRoles(['ROLE_ADVANCED']);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
