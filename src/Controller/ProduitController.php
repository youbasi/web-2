<?php

namespace App\Controller;

use App\Entity\Enchere;
use App\Entity\Produit;
use App\Form\AnchorsType;
use App\Form\ProduitType;
use App\Repository\EnchereRepository;
use App\Service\FileUploader;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/nouveau", name="nouveau")
     */
    public function nouveau(Request $request, EntityManagerInterface $manager, FileUploader $fileUploader): Response
    {
        $produit = new Produit();
        $date = new Enchere();
        $formDate = $this->createForm(AnchorsType::class, $date);
        $formProduit = $this->createForm(ProduitType::class, $produit);
        //$form = $formDate && $formProduit;
        $formDate->handleRequest($request);
        $formProduit->handleRequest($request);
        //$form = $formDate && $formProduit;
        if($formDate->isSubmitted() && $formDate->isValid()){
            $manager->persist($date);
            $manager->flush();
        }
        if($formProduit->isSubmitted() && $formProduit->isValid())
        {
            $file = $formProduit['image']->getData();
                    $filename = (new \DateTime())->format('Y-m-d-H-i-s') . $file->getClientOriginalName();

                    $directory = '../public/images/produits';

                    $file->move($directory, $filename);
        /*$file = $produit->getImageFile();
        $filename = $fileUploader->upload($file);
        $produit->setImage($filename);*/
        $manager->persist($produit);
        $manager->flush();
        return $this->redirectToRoute("anchors");
        }
        
        return $this->render('produit/nouveau.html.twig', [
            'produit' => '$produit',
            'form' => $formProduit->createView(),
            'formDate' => $formDate->createView()
        ]);
    }
    
    /*public function date(Request $request, EntityManagerInterface $manager): Response
    {
        $date = new Enchere();
        $form = $this->createForm(AnchorsType::class, $date);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($date);
            $manager->flush();
        }
        return $this->render('date.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/anchors", name = "anchors")
     */
    public function affichage(ProduitRepository $produitRepository, EnchereRepository $enchereRepository)
    {
        //$anchors = $produitRepository->findAll() + $enchereRepository->findAllTime();
        $anchors = $produitRepository->findAll();
         $produits = $enchereRepository->findAllTime();
        return $this->render('home/anchors.html.twig', [
            'controller_name' => 'ProduitController',
            'anchors' => $anchors,
            'produits' => $produits
        ]);
    }
}
