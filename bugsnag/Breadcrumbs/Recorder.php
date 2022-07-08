<?php namespace Bugsnag\Breadcrumbs;

use Countable;
use Iterator;
use ReturnTypeWillChange;

class Recorder implements Countable, Iterator
{
    const MAX_ITEMS = 25;
    private $breadcrumbs = [];
    private $head = 0;
    private $pointer = 0;
    private $position = 0;

    public function record(Breadcrumb $breadcrumb)
    {
        if ($this->breadcrumbs && $this->pointer === $this->head) {
            $this->head = ($this->head + 1) % static::MAX_ITEMS;
        }
        $this->breadcrumbs[$this->pointer] = $breadcrumb;
        $this->pointer = ($this->pointer + 1) % static::MAX_ITEMS;
    }

    public function clear()
    {
        $this->head = 0;
        $this->pointer = 0;
        $this->position = 0;
        $this->breadcrumbs = [];
    }

    #[ReturnTypeWillChange] public function current()
    {
        return $this->breadcrumbs[($this->head + $this->position) % static::MAX_ITEMS];
    }

    #[ReturnTypeWillChange] public function key()
    {
        return $this->position;
    }

    #[ReturnTypeWillChange] public function next()
    {
        $this->position++;
    }

    #[ReturnTypeWillChange] public function rewind()
    {
        $this->position = 0;
    }

    #[ReturnTypeWillChange] public function valid()
    {
        return $this->position < $this->count();
    }

    #[ReturnTypeWillChange] public function count()
    {
        return count($this->breadcrumbs);
    }
}