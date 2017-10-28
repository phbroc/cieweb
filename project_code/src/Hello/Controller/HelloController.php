<?php
// cieweb/src/Hello/Controller/HelloController.php
namespace Hello\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloController
{
    public function indexAction(Request $request, $name)
    {
        $response = render_template_twig($request, array('name' => $name));
        return $response;
    }
}
?>