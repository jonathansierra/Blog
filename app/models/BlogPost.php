<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class BlogPost extends Model {
        //The name of the table in this case "blog_posts"
        protected $table = 'blog_posts';
        //Bring the fields of the database
        protected $fillable = ['title', 'content', 'img_url'];
    }