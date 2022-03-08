<?php

namespace Combindma\LinkedinInsightTag;

class ConversionLayer
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function set(int $conversionId)
    {
        $this->data [] = $conversionId;
    }

    public function merge(array $newData)
    {
        $this->data = array_merge($this->data, $newData);
    }

    public function clear()
    {
        $this->data = [];
    }

    public function toArray()
    {
        return array_unique($this->data);
    }
}
