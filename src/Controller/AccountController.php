<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/account', name: 'app_account_')]
class AccountController extends AbstractController
{
    #[Route('/settings', name: 'settings')]
public function settings(
    Request $request,
    UserPasswordHasherInterface $passwordHasher,
    EntityManagerInterface $em
): Response {
    /** @var \App\Entity\User $user */
    $user = $this->getUser();

    if (!$user) {
        throw $this->createAccessDeniedException();
    }

    $form = $this->createForm(ChangePasswordType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $currentPassword = $form->get('currentPassword')->getData();

        if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
            $form->get('currentPassword')
                ->addError(new FormError('Mot de passe actuel incorrect'));
        } else {
            $newPassword = $form->get('newPassword')->getData();

            $user->setPassword(
                $passwordHasher->hashPassword($user, $newPassword)
            );

            $em->flush();

            $this->addFlash('success', 'Mot de passe mis à jour avec succès');

            return $this->redirectToRoute('app_account_settings');
        }
    }

    return $this->render('pages/account/settings.html.twig', [
        'passwordForm' => $form->createView(),
    ]);
}

}
