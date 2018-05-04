<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Team;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\Post;
use AppBundle\Service\FileUploader;

class PostUploadListener
{
    private $uploader;
    private $fileName;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        if ($entity instanceof Post || $entity instanceof  Team) {
            $file = $entity->getImage();

            // only upload new files
            if ($file instanceof UploadedFile) {
                $fileName = $this->uploader->upload($file);
                $entity->setImage($fileName);
            }


        }

        return;
    }
}