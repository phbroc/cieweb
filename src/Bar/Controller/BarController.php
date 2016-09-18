<?php
// cieweb/src/Bar/Controller/BarController.php
namespace Bar\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BarController
{
    public function indexAction(Request $request)
    {
        $response = render_template_phpEngine($request, array());
        return $response;
    }
}
?>
