<?php defined('SYSPATH') or die('No direct script access.');
class HTTP_Exception_404 extends Kohana_HTTP_Exception_404 {
 
    /**
     * Generate a Response for the 404 Exception.
     *
     * The user should be shown a nice 404 page.
     * 
     * @return Response
     */
    public function get_response()
    {
        Site::ini();
        $content = View::factory('errors/404');
        $view = $this->get_template($content);
 
        // Remembering that `$this` is an instance of HTTP_Exception_404
        $view->message = $this->getMessage();
 
        $response = Response::factory()
            ->status(404)
            ->body($view->render());
            //print_r($this);
 
        return $response;
    }
}