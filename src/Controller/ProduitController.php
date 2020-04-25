<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
//use App\Service\FileUploader;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/nouveau", name="nouveau")
     */
    public function nouveau(Request $request, EntityManagerInterface $manager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            if ($form->isSubmitted() && $form->isValid()) {

                $file = $form['imageFile']->getData();
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
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/anchors", name = "anchors")
     */
    public function affichage(ProduitRepository $produitRepository)
    {
        $anchors = $produitRepository->findAll();
        return $this->render('home/anchors.html.twig', [
            'controller_name' => 'ProduitController',
            'anchors' => $anchors
        ]);
    }
}
