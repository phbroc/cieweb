<?php
// cieweb/src/Foo/Controller/FooController.php
namespace Foo\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FooController
{
    public function indexAction(Request $request)
    {
        $response = render_template($request);
        return $response;
    }
}
?>
