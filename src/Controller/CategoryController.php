<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Flasher\Prime\FlasherInterface;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="app_category")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('dashboard/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/new", name="ap_add_category", methods="POST")
     */
    public function addCategory(EntityManagerInterface $em, Request $request, FlasherInterface $flasher):Response
    {
        //dd($request);
        try{
            $category = new Category();
            $category->setTitle($request->get('title'));
            $em->persist($category);
            $em->flush();
           // $this->addFlash('success', 'Category Added Successfully');
           $flasher->addSuccess('Category added Successfully 😎');
            return $this->redirectToRoute('app_category');
        }catch(\Exception $e){
            //$this->addFlash('error', 'An error occured Please try again !');
            $flasher->addSuccess('An error occured Please try again ! 😕');
            return $this->redirectToRoute('app_category');
        }
    }

    /**
     * @Route("/category/edit", name="ap_edit_category", methods="POST")
     */
    public function updateCategory(EntityManagerInterface $em, Request $request, FlasherInterface $flasher):Response
    {
        try{
            $category = $em->getRepository(Category::class)->find($request->get('catid'));
            $category->setTitle($request->get('title'));
            $em->persist($category);
            $em->flush();
            $flasher->addSuccess('Category updated Successfully 😎');
            return $this->redirectToRoute('app_category');
        }catch(\Exception $e){
            $flasher->addSuccess('An error occured Please try again ! 😕');
            return $this->redirectToRoute('app_category');
        }
    }

     /**
     * @Route("/category/delete/{id}", name="ap_delete_category")
     */
    public function removeCategory(EntityManagerInterface $em, Request $request, $id, FlasherInterface $flasher):Response
    {
        //dd($request);
        try{
            $category = $em->getRepository(Category::class)->find($id);
            $em->remove($category);
            $em->flush();
            $flasher->addSuccess('Category removed Successfully 😎');
            return $this->redirectToRoute('app_category');
        }catch(\Exception $e){
            $flasher->addSuccess('An error occured Please try again ! 😕');
            return $this->redirectToRoute('app_category');
        }
    }
}
