<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Imagine\Image\ImageInterface;

class FileManager
{
    private $fileDirectory;

    public function __construct(
        $fileDirectory,
    ) {
        $this->fileDirectory = $fileDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $fileDirectory = $this->getFileDirectory();

        try {
            $file->move($fileDirectory, $fileName);
        } catch (FileException $e) {
            echo ($e);
        }

        return $fileName;
    }

    public function getFileDirectory()
    {
        return $this->fileDirectory;
    }

    public function deleteFile($fileName): void
    {
        if ($fileName !== null) {
            $fileSystem = new Filesystem();
            $fileSystem->remove($fileName);
        }
    }


    public function generateThumbnail($filePath)
    {
        $imagine = new Imagine();
        $image = $imagine->open($filePath);

        $thumbnail = $image->thumbnail(new Box(100, 100), ImageInterface::THUMBNAIL_OUTBOUND);

        $response = new Response();
        $thumbnailData = $thumbnail->get('jpg');

        $response->headers->set('Content-Type', 'image/jpeg');
        $response->headers->set('Content-Disposition', 'inline; filename="thumbnail.jpg"');
        $response->setContent($thumbnailData);

        return $response;
    }
}
