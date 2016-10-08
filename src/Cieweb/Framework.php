<?php
// cieweb/src/Cieweb/Framework.php
namespace Cieweb;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Filesystem\Filesystem;

class Framework
{
    protected $matcher;
    protected $resolver;

    public function __construct(UrlMatcher $matcher, ControllerResolver $resolver)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
    }
    
    protected function fileResponse($path, $extension)
    {
        $pos = strrpos($path, "/");
        if ($pos === false) {
            $name = $path;
        }
        else {
            $name = substr($path,$pos+1);
        }
        // prepare BinaryFileResponse
        $response = new BinaryFileResponse($path);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $name,
            iconv('UTF-8', 'ASCII//TRANSLIT', $name)
        );
        // detecter le type de fichier?
        // à compléter car là c'est uniquement à CSS
        if ($extension === '.css') $response->headers->set('Content-Type', 'text/css'); 
        $response->prepare(Request::createFromGlobals());
        return $response;
    }

    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            $basePath = __DIR__.'/web';
            $filePath = $basePath.$request->getPathInfo();
            $extension = substr($filePath, strrpos($filePath, "."));
            // check if file exists
            $fs = new FileSystem();
            if (!$fs->exists($filePath)) {
                    return new Response('file not Found: '.$request->getPathInfo(), 404);
            } else if ($extension === '.css') {
                    //return new Response('file exists !', 200);
                    return $this->fileResponse($filePath, $extension);
            } else {
                    return new Response('An error occurred.', 500);
            }
        } catch (Exception $e) {
            return new Response('An error occurred: '.$e, 500);
        }
    }
}