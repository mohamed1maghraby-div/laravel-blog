<?php

namespace App\Traits\Admin;

trait FiltersTrait
{
    private $keyword;
    private $status;
    private $sort_by;
    private $order_by;
    private $limit_by;
    private $categoryId;
    private $postId;

    protected function setFilters($keyword, $status, $sort_by, $order_by, $limit_by)
    {
        $this->keyword =    (isset($keyword) && $keyword != '')           ? $keyword : null;
        $this->status =     (isset($status) && $status != '')             ? $status : null;
        $this->sort_by =    (isset($sort_by) && $sort_by != '')           ? $sort_by : 'id';
        $this->order_by =   (isset($order_by) && $order_by != '')         ? $order_by : 'desc';
        $this->limit_by =   (isset($limit_by) && $limit_by != '')         ? $limit_by : '10';
    }
    
    protected function FiltersCategoryId($category_id)
    {
        $this->categoryId = (isset($category_id) && $category_id != '')   ? $category_id : null;
        return $this->categoryId;
    }

    protected function FiltersPostId($post_id)
    {
        $this->postId = (isset($post_id) && $post_id != '') ? $post_id : null;
        return $this->postId;
    }

    protected function getKeyword()
    {
        return $this->keyword;
    }

    protected function getStatus()
    {
        return $this->status;
    }

    protected function getSortBy()
    {
        return $this->sort_by;
    }

    protected function getOrderBy()
    {
        return $this->order_by;
    }

    protected function getLimitBy()
    {
        return $this->limit_by;
    }
}