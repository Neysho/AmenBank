<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\VirementAddType;
use App\Entity\Virement;
use App\Repository\VirementRepository;

class VirementController extends AbstractController
{
    /*                       CRUD                    */

    /**
     * @Route("/front/mes_virements_list", name="mes_virements_list")
     */
    public function mes_virements_list(Request $request, PaginatorInterface $paginator)
    {
        $userid=$this->getUser();
        $virement = $this->getDoctrine()->getRepository(Virement:: class)->MesVirements($userid);
        $virement = $this->getDoctrine()->getRepository(Virement:: class)->MesVirements($userid);
        $virement=$paginator->paginate(
            $virement, //on passe les données
            $request->query->getInt('page', 1), //num de la page en cours, 1 par défaut
            5 //nbre d'articles par page
        );
        return $this->render('virement/mes_virements_list.html.twig', array("virement" => $virement));
    }

    /**
     * @Route("/back/virement_list", name="virement_list")
     */
    public function virement_list(Request $request, PaginatorInterface $paginator)
    {
        $virement = $this->getDoctrine()->getRepository(Virement:: class)->findAll();
        $virement=$paginator->paginate(
            $virement, //on passe les données
            $request->query->getInt('page', 1), //num de la page en cours, 1 par défaut
            5 //nbre d'articles par page
        );
        return $this->render('virement/virement_list.html.twig', array("virement" => $virement));
    }
    /**
     * @Route("/back/show_virement/{id}", name="show_virement_by_id")
     */
    public function show_virement_by_id($id)
    {
        $virement = $this->getDoctrine()->getRepository(Virement:: class)->find($id);
        return $this->render('virement/show_virement.html.twig', array("virement" => $virement));
    }
    /**
     * @Route("/back/delete_virement/{id}", name="delete_virement")
     */
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $delete=$em->getRepository(Virement::class)->find($id);
        $em->remove($delete);
        $em->flush();
        $this->addFlash('virement_deleted', 'Virement Deleted Successfully!!');
        return $this->redirectToRoute('virement_list');
    }
    /**
     * @Route("/back/create_virement", name="create_virement")
     * @param Request $request
     * @return Response
     */
    public function create_virement(Request $request)
    {
        $virement=new Virement();
        $form=$this->createForm(VirementAddType::class,$virement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($virement);
            $em->flush();
            $this->addFlash('virement_added', 'Virement Added Successfully!!');
            return $this->redirectToRoute('virement_list');
        }
        return $this->render('virement/create.html.twig', ['CreateForm_Virement'=>$form->createView() ]);
    }

    /**
     * @Route("/back/update_virement/{id}",name="update_virement")
     * @param Request $request
     */
    public function update(VirementRepository $repository,$id,Request $request)
    {
        /** @var UploadedFile $file */
        $virement=$repository->find($id);
        $form=$this->createForm(VirementAddType::class,$virement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('virement_modified', 'Virement Modified Successfully!!');
            return $this->redirectToRoute('virement_list');
        }
        return $this->render('virement/update_virement.html.twig', ['UpdateForm_Virement'=>$form->createView() ]);
    }

    //              extra functions               //

    /**
     * @Route ("/recherche_account_virement",name="recherche_account_virement")
     */
    public function recherche_account_virement(VirementRepository $repository , Request $request, PaginatorInterface $paginator)
    {
        $data=$request->get('search');
        $virement=$repository->SearchNumber($data);
        $virement=$paginator->paginate(
            $virement, //on passe les données
            $request->query->getInt('page', 1), //num de la page en cours, 1 par défaut
            5 //nbre d'articles par page
        );
        return $this->render('virement/virement_list.html.twig',array('virement'=>$virement));
    }

    /**
     * @Route ("/recherche_account_number_virement",name="recherche_account_number_virement")
     */
    public function recherche_account_number_virement(VirementRepository $repository , Request $request, PaginatorInterface $paginator)
    {
        $data=$request->get('search');
        $virement=$repository->SearchUserFromAccount($data);
        $virement=$paginator->paginate(
            $virement, //on passe les données
            $request->query->getInt('page', 1), //num de la page en cours, 1 par défaut
            5 //nbre d'articles par page
        );
        return $this->render('virement/virement_list.html.twig',array('virement'=>$virement));
    }
}
