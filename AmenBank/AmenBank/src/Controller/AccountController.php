<?php

namespace App\Controller;

use App\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AccountRepository;
use App\Form\AccountAddType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;


class AccountController extends AbstractController
{

    /*                       CRUD                    */

    /**
     * @Route("/front/my_accounts_list", name="my_accounts_list")
     */
    public function my_accounts_list(Request $request, PaginatorInterface $paginator)
    {
        $userid=$this->getUser();
        $account = $this->getDoctrine()->getRepository(Account:: class)->MyAccounts($userid);
        $account=$paginator->paginate(
            $account, //on passe les données
            $request->query->getInt('page', 1), //num de la page en cours, 1 par défaut
            5 //nbre d'articles par page
        );
        return $this->render('/account/my_accounts_list.html.twig', array("account" => $account));
    }

    /**
     * @Route("/back/account_list", name="account_list")
     */
    public function account_list(Request $request, PaginatorInterface $paginator)
    {
        $account = $this->getDoctrine()->getRepository(Account:: class)->findAll();
        $account=$paginator->paginate(
            $account, //on passe les données
            $request->query->getInt('page', 1), //num de la page en cours, 1 par défaut
            5 //nbre d'articles par page
        );
        return $this->render('/account/account_list.html.twig', array("account" => $account));
    }
    /**
     * @Route("/back/show_account/{id}", name="show_account_by_id")
     */
    public function show_account_by_id($id)
    {
        $account = $this->getDoctrine()->getRepository(Account:: class)->find($id);
        return $this->render('account/show_account.html.twig', array("account" => $account));
    }
    /**
     * @Route("/back/delete_account/{id}", name="delete_account")
     */
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $delete=$em->getRepository(Account::class)->find($id);
        $em->remove($delete);
        $em->flush();
        $this->addFlash('account_deleted', 'Account Deleted Successfully!!');
        return $this->redirectToRoute('account_list');
    }
    /**
     * @Route("/back/create_account", name="create_account")
     * @param Request $request
     * @return Response
     */
    public function create_account(Request $request)
    {
        $account=new Account();
        $form=$this->createForm(AccountAddType::class,$account);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($account);
            $em->flush();
            $this->addFlash('account_added', 'Account Added Successfully!!');
            return $this->redirectToRoute('account_list');
        }
        return $this->render('account/create.html.twig', ['CreateForm_Account'=>$form->createView() ]);
    }

    /**
     * @Route("/back/update_account/{id}",name="update_account")
     * @param Request $request
     */
    public function update(AccountRepository $repository,$id,Request $request)
    {
        /** @var UploadedFile $file */
        $account=$repository->find($id);
        $form=$this->createForm(AccountAddType::class,$account);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('account_modified', 'Account Modified Successfully!!');
            return $this->redirectToRoute('account_list');
        }
        return $this->render('account/update_account.html.twig', ['UpdateForm_Account'=>$form->createView() ]);
    }

     //              extra functions

    /**
     * @Route ("/recherche_number",name="recherche_number")
     */
    public function recherche_number(AccountRepository $repository , Request $request, PaginatorInterface $paginator)
    {
        $data=$request->get('search');
        $account=$repository->SearchNumber($data);
        $account=$paginator->paginate(
            $account, //on passe les données
            $request->query->getInt('page', 1), //num de la page en cours, 1 par défaut
            5 //nbre d'articles par page
        );
        return $this->render('account/account_list.html.twig',array('account'=>$account));
    }

    /**
     * @Route ("/recherche_user_account",name="recherche_user_account")
     */
    public function recherche_user_account(AccountRepository $repository , Request $request, PaginatorInterface $paginator)
    {
        $data=$request->get('search');
        $account=$repository->SearchUserFromAccount($data);
        $account=$paginator->paginate(
            $account, //on passe les données
            $request->query->getInt('page', 1), //num de la page en cours, 1 par défaut
            5 //nbre d'articles par page
        );
        return $this->render('account/account_list.html.twig',array('account'=>$account));
    }
}
