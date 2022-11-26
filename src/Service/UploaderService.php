<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploaderService
{
    private $slugger;
    private $parameter;
    public function __construct(SluggerInterface $slugger, ContainerInterface $parameter)
    {
        $this->slugger = $slugger;
        $this->parameter = $parameter;
    }
    public function upload($file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        try {
            $file->move(
                $this->parameter->getParameter('IMAGES'),
                $newFilename
            );
        } catch (FileException $e) {
            dd($e);
        }
        return $newFilename;

    }
}