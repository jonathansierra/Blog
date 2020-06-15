<?php

    namespace App\Controllers\Admin;

    use App\Controllers\BaseController;
    use App\Models\BlogPost;
    use Sirius\Validation\Validator;

    class PostController extends BaseController {

        public function getIndex() {
            $blogPosts = BlogPost::all();
            return $this->render('admin/posts.twig', ['blogPosts' => $blogPosts]);
        }

        public function getCreate() {
            //admin/posts/create
            return $this->render('admin/insert-post.twig');
        }

        public function postCreate() {
            $errors = [];
            $result = false;
            //Create Validator
            $validator = new Validator();
            //Add rules
            $validator->add('title', 'required');
            //required
            $validator->add('content', 'required');
            if($validator->validate($_POST)) {
                //Add new post -> put the parameters in the constructor
                $blogPost = new BlogPost([
                    'title' => $_POST['title'],
                    'content' => $_POST['content'],
                ]);
                if($_POST['img']) {
                    $blogPost->img_url = $_POST['img'];
                }

                $blogPost->save();
                $result = true;
            } else {
                $errors = $validator->getMessages();
            }
            return $this->render('admin/insert-post.twig', [
                'result' => $result,
                'errors' => $errors
            ]);
        }
    }