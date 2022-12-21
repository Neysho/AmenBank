<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Totp\TotpAuthenticatorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\QrCode\QrCodeGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/authentication/2fa/enable", name="app_2fa_enable")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function enable2fa(TotpAuthenticatorInterface $totpAuthenticator, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        if (!$user->isTotpAuthenticationEnabled()) {
            $user->setTotpSecret($totpAuthenticator->generateSecret());
            $entityManager->flush();
        }
       // dd($totpAuthenticator->getQRContent($user));
      return $this->render('security/enable2fa.html.twig');
    }
    /**
     * @Route("/authentication/2fa/qr-code", name="app_qr_code")
     */
    public function displayGoogleAuthenticatorQrCode(QrCodeGenerator $qrCodeGenerator)
    {

        $qrCode = $qrCodeGenerator->getTotpQrCode($this->getUser());
        return new Response($qrCode->writeString(), 200, ['Content-Type' => 'image/png']);
    }
}
