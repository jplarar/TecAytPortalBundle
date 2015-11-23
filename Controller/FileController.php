<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class FileController extends Controller
{
    public function downloadAction($id, $class)
    {
        $entity = '\Tec\Ayt\CoreBundle\Entity\\'.$class;
        $object = $this->getDoctrine()->getRepository($entity)
            ->find($id);

        if (!$object) {
            throw $this->createNotFoundException(
                'No object found for id '.$id
            );
        }

        $response = $this->generateDownloadResponse($object);
        return $response;
    }

    #####################################
    #          PRIVATE FUNCTIONS        #
    #####################################
    /**
     * Generates Download Response
     *
     * Verifies if file exists and file's type before generating the response.
     *
     * @param  $object
     * @return BinaryFileResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function generateDownloadResponse($object)
    {
        // Check if file exists
        $file = $object->getFileName();
        $path = $this->get('kernel')->getRootDir() . '/../../DeployAyt/ControlAyt/web/uploads/'. $file;
        //$path = $this->get('kernel')->getRootDir() . '/../../control/web/uploads/'. $file;

        if (!file_exists($path)) {
            throw $this->createNotFoundException(
                $path
            );
        }

        // Check the File Type: http://en.wikipedia.org/wiki/Internet_media_type
        $extArr = explode('.', $path);
        $ext = end($extArr);

        // Clean the filename
        $filename = preg_replace("/[^a-z0-9_\s]+/i", "", $object->getFileName()) . '.' . $ext;
        $mimeType = mime_content_type($path);

        // Generate Response
        $response = new BinaryFileResponse($path);
        $response->headers->set('Content-Type', $mimeType);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);

        return $response;
    }

}
