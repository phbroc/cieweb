<?php
// cieweb/src/Index/Controller/IndexController.php
namespace Index\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    public function indexAction(Request $request)
    {
        $response = new Response('index');
        return $response;
    }
}
