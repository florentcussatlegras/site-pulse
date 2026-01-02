<?php
// src/Form/ResetPasswordType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'data' => $options['token'] ?? null,
                'first_options'  => ['label' => 'Votre nouveau mot de passe :'],
                'second_options' => ['label' => 'Répétez le mot de passe :'],
                'constraints' => [
                    new Assert\Callback(function ($object, ExecutionContextInterface $context) {
                        $first = $object['first'] ?? null;
                        $second = $object['second'] ?? null;

                        if ($first !== $second) {
                            $context->buildViolation('Les mots de passe doivent correspondre.')
                                ->addViolation();
                        }
                    }),
                    new Assert\NotBlank(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'token' => null, // déclaration de l'option "token"
        ]);
    }
}
