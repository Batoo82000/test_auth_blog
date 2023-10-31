<?php
namespace App\DataFixtures;

use App\Entity\Post;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 150; $i++) {
            $post = new Post();
            $post->setTitle('title '.$i);
            $post->setSlug('title-slug-'.$i);
            $post->setContent('test content');
            $post->setOnline(true);
            $post->setCategory($this->getReference('category-'.rand(0, 19)));
            $post->setAuthor($this->getReference('user-'.rand(0, 19)));
            $manager->persist($post);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class
        ];
    }
}