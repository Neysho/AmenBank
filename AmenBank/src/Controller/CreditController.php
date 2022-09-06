<?php

namespace App\Controller;

use App\Entity\Credit;
use App\Entity\User;
use App\Form\CreditAddType;
use App\Form\CreditUpdateType;
use App\Repository\CreditRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends AbstractController
{
    /*                       CRUD                    */

    /**
     * @Route("/mes_demande_credit", name="mes_demande_credit")
     */
    public function mes_demande_credit(Request $request, PaginatorInterface $paginator)
    {
//        $userid=$this->getUser();
//        $credit = $this->getDoctrine()->getRepository(Credit:: class)->MyAccounts($userid);
//        $credit=$paginator->paginate(
//            $credit, //on passe les données
//            $request->query->getInt('page', 1), //num de la page en cours, 1 par défaut
//            5 //nbre d'articles par page
//        );
//        return $this->render('credit/mes_credits_list.html.twig', array("credit" => $credit));
    }

    /**
     * @Route("/back/credit_list", name="credit_list")
     */
    public function credit_list(Request $request, PaginatorInterface $paginator)
    {
        $credit = $this->getDoctrine()->getRepository(Credit:: class)->findAll();
        $credit=$paginator->paginate(
            $credit, //on passe les données
            $request->query->getInt('page', 1), //num de la page en cours, 1 par défaut
            5 //nbre d'articles par page
        );
        return $this->render('credit/credit_list.html.twig', array("credit" => $credit));
    }

    /**
     * @Route("/credit_simulator", name="credit_simulator")
     */
    public function credit_simulator(Request $request) :  Response
    {
        return $this->render('credit/Simulator.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/back/show_credit/{id}", name="show_credit_by_id")
     */
    public function show_credit_by_id($id)
    {
        $credit = $this->getDoctrine()->getRepository(Credit:: class)->find($id);
        return $this->render('credit/show_credit.html.twig', array("credit" => $credit));
    }
    /**
     * @Route("/back/delete_credit/{id}", name="delete_credit")
     */
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $delete=$em->getRepository(Credit::class)->find($id);
        $em->remove($delete);
        $em->flush();
        $this->addFlash('credit_deleted', 'Demande de Credit Supprimée!!');
        return $this->redirectToRoute('credit_list');
    }
    /**
     * @Route("/back/create_credit", name="create_credit")
     * @param Request $request
     * @return Response
     */
    public function create_credit(Request $request)
    {
        /** @var UploadedFile $f_cin
         * @var UploadedFile $f_att_travail
         * @var UploadedFile $f_att_salaire
         * @var UploadedFile $f_doc_credit
         */

        $credit=new Credit();
        $credit->setStatus('En Cours'); // default status
        $userid=$this->getUser();
        $credit->setUser($userid);

        $form=$this->createForm(CreditAddType::class,$credit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $f_cin = $form->get('c_cin')->getData();
            $f_att_travail = $form->get('Attestation_Travail')->getData();
            $f_att_salaire = $form->get('Attestation_Salaire')->getData();
            $f_doc_credit = $form->get('Document_Credit')->getData();

            $uploads_directory = $this->getParameter('credit_uploads_directory');
            $f_cin_name = md5(uniqid()) . '.' . $f_cin->guessExtension();
            $f_att_travail_name = md5(uniqid()) . '.' . $f_att_travail->guessExtension();
            $f_att_salaire_name = md5(uniqid()) . '.' . $f_att_salaire->guessExtension();
            $f_doc_credit_name = md5(uniqid()) . '.' . $f_doc_credit->guessExtension();
            $f_cin->move($uploads_directory,$f_cin_name);
            $f_att_travail->move($uploads_directory,$f_att_travail_name);
            $f_att_salaire->move($uploads_directory,$f_att_salaire_name);
            $f_doc_credit->move($uploads_directory,$f_doc_credit_name);
            $credit->setCCin($f_cin_name);
            $credit->setAttestationTravail($f_att_travail_name);
            $credit->setAttestationSalaire($f_att_salaire_name);
            $credit->setDocumentCredit($f_doc_credit_name);

            $em=$this->getDoctrine()->getManager();
            $em->persist($credit);
            $em->flush();
            $this->addFlash('credit_added', 'Demande de Credit Envoyée!!');
            return $this->redirectToRoute('credit_list');
        }
        return $this->render('credit/create.html.twig', ['CreateForm_Credit'=>$form->createView() ]);
    }

    /**
     * @Route("/back/update_credit/{id}",name="update_credit")
     * @param Request $request
     */
    public function update(CreditRepository $repository,$id,Request $request)
    {
        $credit=$repository->find($id);
        $form=$this->createForm(CreditUpdateType::class,$credit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('credit_modified', 'Demande de Credit Modifiée!!');
            return $this->redirectToRoute('credit_list');
        }
        return $this->render('credit/update_credit.html.twig', ['UpdateForm_Credit'=>$form->createView() ]);
    }

    /**
     * @Route("/back/Credit/downloadfileCIN/{id}")
     */
    public function downloadCreditFileCIN($id) {
        try {
            $file = $this->getDoctrine()->getRepository(Credit:: class)->find($id);
            if (! $file) {
                $array = array (
                    'status' => 0,
                    'message' => 'File does not exist'
                );
                $response = new JsonResponse ( $array, 200 );
                return $response;
            }
          $username = $file->getUser()->getUsername();
            $fileName_CIN = $file->getCCin();
            $file_with_path_CIN = $this->getParameter ( 'credit_uploads_directory' ) . "/" . $fileName_CIN;
            $response = new BinaryFileResponse ( $file_with_path_CIN );
            $response->headers->set ( 'Content-Type', 'text/plain' );
            $path_parts = pathinfo($fileName_CIN);
            $FileType_Cin = $path_parts['extension'];
            $response->setContentDisposition ( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $username . '_CIN.' . $FileType_Cin  );
          return $response;
        } catch ( Exception $e ) {
            $array = array (
                'status' => 0,
                'message' => 'Download error'
            );
            $response = new JsonResponse ( $array, 400 );
            return $response;
        }
    }

    /**
     * @Route("/back/Credit/downloadfileTravail/{id}")
     */
    public function downloadCreditFileTravail($id) {
        try {
            $file = $this->getDoctrine()->getRepository(Credit:: class)->find($id);
            if (! $file) {
                $array = array (
                    'status' => 0,
                    'message' => 'File does not exist'
                );
                $response = new JsonResponse ( $array, 200 );
                return $response;
            }
            $username = $file->getUser()->getUsername();
            $fileName_Travail = $file->getAttestationTravail();
            $file_with_path_CIN = $this->getParameter ( 'credit_uploads_directory' ) . "/" . $fileName_Travail;
            $response = new BinaryFileResponse ( $file_with_path_CIN );
            $response->headers->set ( 'Content-Type', 'text/plain' );
            $path_partz = pathinfo($fileName_Travail);
            $FileType_Travail = $path_partz['extension'];
            $response->setContentDisposition ( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $username . '_AttestationDeTravail.' . $FileType_Travail  );
            return $response;
        } catch ( Exception $e ) {
            $array = array (
                'status' => 0,
                'message' => 'Download error'
            );
            $response = new JsonResponse ( $array, 400 );
            return $response;
        }
    }

    /**
     * @Route("/back/Credit/downloadfileSalaire/{id}")
     */
    public function downloadCreditFileSalaire($id) {
        try {
            $file = $this->getDoctrine()->getRepository(Credit:: class)->find($id);
            if (! $file) {
                $array = array (
                    'status' => 0,
                    'message' => 'File does not exist'
                );
                $response = new JsonResponse ( $array, 200 );
                return $response;
            }
            $username = $file->getUser()->getUsername();
            $fileName_CIN = $file->getAttestationSalaire();
            $file_with_path_CIN = $this->getParameter ( 'credit_uploads_directory' ) . "/" . $fileName_CIN;
            $response = new BinaryFileResponse ( $file_with_path_CIN );
            $response->headers->set ( 'Content-Type', 'text/plain' );
            $path_parts = pathinfo($fileName_CIN);
            $FileType_Cin = $path_parts['extension'];
            $response->setContentDisposition ( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $username . '_AttestationDeSalaire.' . $FileType_Cin  );
            return $response;
        } catch ( Exception $e ) {
            $array = array (
                'status' => 0,
                'message' => 'Download error'
            );
            $response = new JsonResponse ( $array, 400 );
            return $response;
        }
    }

    /**
     * @Route("/back/Credit/downloadfileDocCredit/{id}")
     */
    public function downloadCreditFileDocCredit($id) {
        try {
            $file = $this->getDoctrine()->getRepository(Credit:: class)->find($id);
            if (! $file) {
                $array = array (
                    'status' => 0,
                    'message' => 'File does not exist'
                );
                $response = new JsonResponse ( $array, 200 );
                return $response;
            }
            $username = $file->getUser()->getUsername();
            $fileName_CIN = $file->getDocumentCredit();
            $file_with_path_CIN = $this->getParameter ( 'credit_uploads_directory' ) . "/" . $fileName_CIN;
            $response = new BinaryFileResponse ( $file_with_path_CIN );
            $response->headers->set ( 'Content-Type', 'text/plain' );
            $path_parts = pathinfo($fileName_CIN);
            $FileType_Cin = $path_parts['extension'];
            $response->setContentDisposition ( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $username . '_DocumentCredit.' . $FileType_Cin  );
            return $response;
        } catch ( Exception $e ) {
            $array = array (
                'status' => 0,
                'message' => 'Download error'
            );
            $response = new JsonResponse ( $array, 400 );
            return $response;
        }
    }
}
