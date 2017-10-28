<?php
// cieweb/src/Bar/Controller/BarController.php
namespace Bar\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BarController
{
    public function indexAction(Request $request)
    {
        //$debug = $this->container->getParameter('kernel.root_dir'); KO
        //$debug = $this->get('kernel')->getRootDir(); KO
        $debug = 'test';
        $response = render_template_phpEngine($request, array('debug' => $debug));
        return $response;
    }
}
?>
