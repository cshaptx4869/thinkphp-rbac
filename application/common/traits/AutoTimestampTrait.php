<?php


namespace app\common\traits;


trait AutoTimestampTrait
{
    protected $createdAt = 'created_at';
    protected $updatedAt = 'updated_at';
    protected $deletedAt = 'deleted_at';

    public function autoTimestamp(array &$data)
    {
        $time = time();
        $data[$this->createdAt] = $time;
        $data[$this->updatedAt] = $time;
    }

    public function createdAt(array &$data)
    {
        $data[$this->createdAt] = time();
    }

    public function updatedAt(array &$data)
    {
        $data[$this->updatedAt] = time();
    }

    public function deletedAt(array &$data)
    {
        $data[$this->deletedAt] = time();
    }
}