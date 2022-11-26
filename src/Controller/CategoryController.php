<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="app_category")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/add", name="app_add_category", methods="POST")
     */
    public function addCategory(EntityManagerInterface $em, Request $request):Response
    {
        try{
            $category = new Category();
            $category->setTitle($request->get('title'));
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Category AddedSuccessfully');
            return $this->redirectToRoute('app_category');
        }catch(\Exception $e){
            $this->addFlash('error', 'An error occured Please try again !');
            return $this->redirectToRoute('app_category');
        }
    }

    /**
     * @Route("/category/update", name="app_update_category", methods="POST")
     */
    public function updateCategory(EntityManagerInterface $em, Request $request):Response
    {
        try{
            $category = $em->getRepository(Category::class)->find($request->get('category'));
            $category->setTitle($request->get('title'));
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Category updated Successfully');
            return $this->redirectToRoute('app_category');
        }catch(\Exception $e){
            $this->addFlash('error', 'An error occured Please try again !');
            return $this->redirectToRoute('app_category');
        }
    }

     /**
     * @Route("/category/remove", name="app_remove_category", methods="POST")
     */
    public function removeCategory(EntityManagerInterface $em, Request $request):Response
    {
        try{
            $category = $em->getRepository(Category::class)->find($request->get('category'));
            $em->remove($category);
            $em->flush();
            $this->addFlash('success', 'Category updated Successfully');
            return $this->redirectToRoute('app_category');
        }catch(\Exception $e){
            $this->addFlash('error', 'An error occured Please try again !');
            return $this->redirectToRoute('app_category');
        }
    }
}
