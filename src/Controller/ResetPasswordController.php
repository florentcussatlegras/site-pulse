<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\String\ByteString;

class ResetPasswordController extends AbstractController
{
    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');

            /** @var User|null $user */
            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user) {
                // Générer un token sécurisé
                $token = ByteString::fromRandom(32)->toString();
                $user->setResetPasswordToken($token);
                $user->setResetPasswordExpiresAt(new \DateTime('+1 hour'));
                $em->flush();

                // Envoyer email
                $resetUrl = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                $homepageUrl = $this->generateUrl(
                    'app_home',
                    [],
                    UrlGeneratorInterface::ABSOLUTE_URL
                );

                $logoUrl = $this->getParameter('app.base_url') . '/images/logo_site_pulse.png';

                $emailTemplate = (new TemplatedEmail())
                    ->to($user->getEmail())
                    ->subject('Réinitialisation de votre mot de passe')
                    ->htmlTemplate('emails/reset_password.html.twig')
                    ->textTemplate('emails/reset_password.txt.twig')
                    ->context([
                        'resetUrl' => $resetUrl,
                        'user' => $user,
                        'expiresAt' => $user->getResetPasswordExpiresAt(),
                        'homepageUrl' => $homepageUrl,
                        'logoUrl' => $logoUrl,
                    ]);

                $mailer->send($emailTemplate);
            }

            $this->addFlash('success', 'Si cet email existe dans notre système, un lien de réinitialisation vous a été envoyé.');

            return $this->redirectToRoute('app_forgot_password');
        }
        
        return $this->render('security/forgot_password.html.twig');
    }

    #[Route('/reset-password/{token?}', name: 'app_reset_password')]
    public function resetPassword(
        string $token,
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $em->getRepository(User::class)->findOneBy(['resetPasswordToken' => $token]);

        if (!$user || $user->getResetPasswordExpiresAt() < new \DateTime()) {
            $this->addFlash('danger', 'Token invalide ou expiré.');
            return $this->redirectToRoute('app_forgot_password');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            foreach ($form->get('plainPassword')->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user, $plainPassword
                )
            );

            // Supprimer token
            $user->setResetPasswordToken(null);
            $user->setResetPasswordExpiresAt(null);

            $em->flush();

            $this->addFlash('success', 'Mot de passe réinitialisé avec succès !');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
