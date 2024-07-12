<?php

namespace App\Controller\API;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    // #[Route('/api/product', name: 'api_create_product',methods: ['GET'])]
    // public function index(): Response
    // {
    //     $products = new Product();
    //     return $this->render('product/index.html.twig', [
    //         'controller_name' => 'ProductController',
    //         'products' => $products
    //     ]);
    // }
    #[Route('/api/product', name: 'api_create_product',methods: ['POST'])]
    public function createProduct(Request $request, EntityManagerInterface $entityManager,ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $product = new Product();
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)      
        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse(['errors' => $errorsString], JsonResponse::HTTP_BAD_REQUEST);
        }
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        
        return new JsonResponse(['message' => 'Product created successfully'.$product->getId()], JsonResponse::HTTP_CREATED);
    }
}


// $this->addSql('ALTER TABLE employee_payment_detail ADD overtime_hourly_rate DOUBLE PRECISION NOT NULL, ADD double_hourly_rate DOUBLE PRECISION NOT NULL');