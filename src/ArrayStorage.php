<?php

namespace Brisum\Lib;

class ArrayStorage
{
    protected $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function set($key, $value)
    {
        $this->setByPath($key, $value);
    }

    public function get($key)
    {
        return $this->getByPath($key);
    }

    public function del($key)
    {
        $this->delByPath($key);
    }

//    public static function merge(array $array1, array $array2)
//    {
//        $merged = $array1;
//
//        foreach ($array2 as $key => & $value) {
//            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
//                $merged[$key] = $this->merge($merged[$key], $value);
//            } else {
//                if (is_numeric($key)) {
//                    if (!in_array($value, $merged)) {
//                        $merged[] = $value;
//                    }
//                } else {
//                    $merged[$key] = $value;
//                }
//            }
//        }
//
//        return $merged;
//    }

    protected function setByPath($path, $value)
    {
        $pieces = explode('/', $path);
        $lastPiece = array_pop($pieces);
        $data = &$this->data;

        foreach ($pieces as $piece) {
            if (!isset($data[$piece]) || !is_array($data[$piece])) {
                $data[$piece] = [];
            }
            $data = &$data[$piece];
        }
        $data[$lastPiece] = $value;
    }

    protected function getByPath($path = null)
    {
        $pieces = $path ? explode('/', $path) : array();
        $data = &$this->data;

        foreach ($pieces as $piece) {
            if (!isset($data[$piece])) {
                return null;
            }
            $data = &$data[$piece];
        }

        return $data;
    }

    protected function delByPath($path)
    {
        $pieces = explode('/', $path);
        $key = array_pop($pieces);
        $data = &$this->data;

        foreach ($pieces as $piece) {
            if (!isset($data[$piece])) {
                return;
            }
            $data = &$data[$piece];
        }

        unset($data[$key]);
    }
}
