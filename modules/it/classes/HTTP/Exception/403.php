<?php defined('SYSPATH') or die('No direct script access.');
class HTTP_Exception_403 extends Kohana_HTTP_Exception_403 {
 
    /**
     * Generate a Response for the 403 Exception.
     *
     * The user should be shown a nice 403 page.
     * 
     * @return Response
     */
    public function get_response()
    {
        Site::ini();
        $content = View::factory('errors/403');
        $view = $this->get_template($content);
 
        // Remembering that `$this` is an instance of HTTP_Exception_404
        $view->message = $this->getMessage();
 
        $response = Response::factory()
            ->status(403)
            ->body($view->render());
 
        return $response;
    }
}