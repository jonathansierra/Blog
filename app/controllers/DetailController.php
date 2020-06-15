<?php 
    namespace App\Controllers;
    use App\Models\BlogPost;
    use App\Controllers\BaseController;

    class DetailController extends BaseController {
        
	    public function getIndex($id) {        
            $blogPosts = BlogPost::where('id', $id) -> get();        
            return $this -> render('detail.twig', [
                'blogPosts' => $blogPosts
            ]);    
    }	
}