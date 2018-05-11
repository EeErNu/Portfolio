<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Service\FileUploader;
use AppBundle\Entity\Post;
use AppBundle\Entity\Team;
use AppBundle\Entity\Goal;
use AppBundle\Entity\Company;
use AppBundle\Entity\Project;
use AppBundle\Entity\Volunteer;
use AppBundle\Entity\University;

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
        if ($entity instanceof Post || $entity instanceof Team ||
            $entity instanceof Company || $entity instanceof Volunteer ||
            $entity instanceof University || $entity instanceof Goal ||
            $entity instanceof Project) {
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