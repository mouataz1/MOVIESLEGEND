<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubCategoryController extends AbstractController
{
    /**
     * @Route("/sub/category", name="app_sub_category")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $subcategories = $em->getRepository(SubCategory::class)->findAll();
        return $this->render('sub_category/index.html.twig', [
            'subcategories' => $subcategories,
        ]);
    }
    /**
     * @Route("/sub/category/add", name="app_add_category", methods="POST")
     */
    public function addCategory(EntityManagerInterface $em, Request $request):Response
    {
        try{
            $category = new SubCategory();
            $category->setTitle($request->get('title'))
                    ->setCategory($em->getReference(Category::class, $request->get('category')));
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'SubCategory AddedSuccessfully');
            return $this->redirectToRoute('app_category');
        }catch(\Exception $e){
            $this->addFlash('error', 'An error occured Please try again !');
            return $this->redirectToRoute('app_category');
        }
    }

    /**
     * @Route("/sub/category/update", name="app_update_category", methods="POST")
     */
    public function updateCategory(EntityManagerInterface $em, Request $request):Response
    {
        try{
            $category = $em->getRepository(SubCategory::class)->find($request->get('subcategory'));
            $category->setTitle($request->get('title'))
                    ->setCategory($em->getReference(Category::class, $request->get('category')));
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'SubCategory updated Successfully');
            return $this->redirectToRoute('app_category');
        }catch(\Exception $e){
            $this->addFlash('error', 'An error occured Please try again !');
            return $this->redirectToRoute('app_category');
        }
    }

     /**
     * @Route("/sub/category/remove", name="app_remove_category", methods="POST")
     */
    public function removeCategory(EntityManagerInterface $em, Request $request):Response
    {
        try{
            $category = $em->getRepository(SubCategory::class)->find($request->get('subcategory'));
            $em->remove($category);
            $em->flush();
            $this->addFlash('success', 'SubCategory updated Successfully');
            return $this->redirectToRoute('app_category');
        }catch(\Exception $e){
            $this->addFlash('error', 'An error occured Please try again !');
            return $this->redirectToRoute('app_category');
        }
    }
}
