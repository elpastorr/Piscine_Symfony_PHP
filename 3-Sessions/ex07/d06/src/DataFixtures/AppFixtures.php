<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail("user$i@oui.com");
            $user->setPassword(password_hash('000000', PASSWORD_BCRYPT));
            $user->setReputation($i * 3); // 3,6,9,12,15 points
            $manager->persist($user);
            $users[] = $user;
        }

        foreach ($users as $user) {
            for ($j = 1; $j <= 2; $j++) {
                $post = new Post();
                $post->setTitle("Post $j by {$user->getEmail()}");
                $post->setContent("Content for post $j");
                $post->setAuthor($user);
                $post->setCreated(new \DateTime());
                $manager->persist($post);
            }
        }

        $manager->flush();
    }
}
