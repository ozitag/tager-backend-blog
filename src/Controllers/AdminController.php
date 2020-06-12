<?php

namespace OZiTAG\Tager\Backend\Blog\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use OZiTAG\Tager\Backend\Core\Controller;
use OZiTAG\Tager\Backend\Core\SuccessResource;
use OZiTAG\Tager\Backend\Admin\Resources\ProfileResource;
use OZiTAG\Tager\Backend\Mail\Features\ListMailLogsFeature;
use OZiTAG\Tager\Backend\Mail\Features\ListMailTemplatesFeature;
use OZiTAG\Tager\Backend\Mail\Features\UpdateMailTemplateFeature;
use OZiTAG\Tager\Backend\Mail\Features\ViewMailTemplateFeature;

class AdminController extends Controller
{
    public function listCategories()
    {
    }

    public function viewCategory($id)
    {
    }

    public function createCategory()
    {
    }

    public function updateCategory($id)
    {
    }

    public function removeCategory($id)
    {
    }

    public function listPosts()
    {
    }

    public function listPostsByCategory($id)
    {
    }

    public function createPost()
    {
    }

    public function viewPost($id)
    {
    }

    public function updatePost($id)
    {
    }

    public function removePost($id)
    {
    }
}
