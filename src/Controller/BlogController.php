<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog_index')]
    public function index(PostRepository $postRepository): Response
    {

        $posts = $postRepository->findAll();

        return $this->render('blog/index.html.twig', [
            'posts'=> $posts
        ]);
    }
    
    #[Route('/blog/new-article', name:'blog_new')]
    public function new(): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('login_auth');
        }

        $post = new Post();
        $form = $this->createForm(PostType::class);
        return $this->render('blog/new.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/blog/{slug}', name:'blog_show')]
    public function show(Post $post): Response
    {
        return $this->render('blog/show.html.twig', [
            'post'=> $post
        ]);
    }

}
