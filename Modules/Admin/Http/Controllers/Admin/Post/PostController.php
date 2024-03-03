<?php

namespace Modules\Admin\Http\Controllers\Admin\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Post;
use Modules\Admin\Repositories\PostRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\AdminController;

class PostController extends AdminController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$posts = $this->post->all();

        return $this->view('admin::posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('admin::posts.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post $post
     * @return Response
     */
    public function edit(Post $post)
    {
        return $this->view('admin::posts.edit', compact('post'));
    }


}
