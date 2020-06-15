<?php

    namespace App\Controllers;
    use App\Models\BlogPost;

    class IndexController extends BaseController {

        public function getIndex() {
            //Use the Class BlogPost
            $blogPosts = BlogPost::query()->orderBy('id', 'desc')->get();
            return $this->render('index.twig', ['blogPosts' => $blogPosts]);
        }
    }