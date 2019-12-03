<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class SocieteController extends AbstractController
{
    /**
     * @Route("/societe", name="societe")
     */
    public function index()
    {

        $repository = $this->getDoctrine()->getRepository(Client::class);
        $client = $repository->findAll();


        return $this->render('societe/index.html.twig', [
            'client' => $client,
        ]);

    }




    /**
     * @Route("/societe/ajouter", name="ajouter_client")
     */
    public function ajouter(Request $request)
    {
        $client=new Client();
        //creation du formulaire
        $formulaire=$this->createForm(ClientType::class, $client);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            //récuppere l'entity manager(sort de connection a la BDD)
            $em=$this->getDoctrine()->getManager();
            //je dis au manager que je veux ajouyer la categorie dans la bdd
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute("societe");

        }




        return $this->render('societe/formulaire.html.twig', [
            'formulaire' => $formulaire->createView(),
            'h1'=> "Ajouter un client"

        ]);
    }




    /**
     * @Route("/client/modifier/{id}", name="modifier_client")
     */
    public function modifier($id, Request $request)
    {
        $repository=$this->getDoctrine()->getRepository(Client::class);
        $client=$repository->find($id);


        $formulaire=$this->createForm(ClientType::class, $client);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            //récuppere l'entity manager(sort de connection a la BDD)
            $em=$this->getDoctrine()->getManager();
            //je dis au manager que je veux ajouyer la categorie dans la bdd
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute("societe");

        }




        return $this->render('societe/formulaire.html.twig', [
            'formulaire' => $formulaire->createView(),
            'h1'=> "Modifier client <i>".$client->GetSociete()."</i>",
        ]);

    }


    /**
     * @Route("/client/supprimer/{id}", name="supprimer_client")
     */

    public function supprimer($id, Request $request)
    {

        $supprimerRepo=$this->getDoctrine()->getRepository(Client::class);
        $client=$supprimerRepo->find($id);


        $formulaire = $this->createFormBuilder()->add("submit", SubmitType::class,["label"=>"OK", "attr"=>["class"=>"btn btn-danger"]])->getForm();
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            //récuppere l'entity manager(sort de connection a la BDD)
            $em=$this->getDoctrine()->getManager();
            //je dis au manager que je veux ajouyer la categorie dans la bdd
            $em->remove($client);
            $em->flush();

            return $this->redirectToRoute("societe");

        }




        return $this->render('societe/formulaire.html.twig', [
            'formulaire' => $formulaire->createView(),
            'h1'=> "Supprimer <i>".$client->GetSociete()."</i>",
        ]);



    }




}