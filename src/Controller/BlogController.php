<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
        
    }

    #[Route('/blog', name: 'blog_index')]
    public function index(PostRepository $postRepository): Response
    {

        $posts = $postRepository->findAll();

        return $this->render('blog/index.html.twig', [
            'posts'=> $posts
        ]);
    }
    
    #[Route('/blog/new-article', name:'blog_new')]
    public function new(Request $request): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('login_auth');
        }

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $post->setAuthor($this->getUser());
            $post->setTitle($data->getTitle());
            $post->setContent($data->getContent());
            $post->setCategory($data->getCategory());
            $post->setOnline($data->isOnline());
            $this->em->persist($post);
            $this->em->flush();
            $this->addFlash('success', 'Votre article a bien été créé.');
            return $this->redirectToRoute('blog_index');
        }

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
