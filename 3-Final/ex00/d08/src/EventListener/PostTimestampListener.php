<?php

namespace App\EventListener;

use App\Entity\Post;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class PostTimestampListener
{
    public function prePersist(Post $post, LifecycleEventArgs $event): void
    {
        if ($post instanceof Post && $post->getCreated() === null) {
            $post->setCreated(new \DateTimeImmutable());
        }
    }
}