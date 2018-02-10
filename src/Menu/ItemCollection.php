<?php

namespace Styde\Html\Menu;

use Closure;
use ArrayIterator;
use IteratorAggregate;
use Styde\Html\Menu\Item\{Action, RawUrl, Route, Url};

class ItemCollection implements IteratorAggregate
{
    public $items = [];
    public $defaultSecure;

    public function __construct(bool $defaultSecure = true)
    {
        $this->defaultSecure = $defaultSecure;
    }
    
    /**
     * Add a menu item.
     *
     * @param  \Styde\Html\Menu\Item $item
     * @return \Styde\Html\Menu\Item
     */
    public function add(Item $item): Item
    {
        $this->items[] = $item;

        return $item;
    }

    public function raw(string $url, string $text)
    {
        return $this->add(new RawUrl($url, $text));
    }

    public function url(string $url, $text, $parameters = [])
    {
        return $this->add(new Url($url, $text, $parameters, $this->defaultSecure));
    }

    public function route(string $url, $text, $parameters = [])
    {
        return $this->add(new Route($url, $text, $parameters));
    }

    public function action(string $url, $text, $parameters = [])
    {
        return $this->add(new Action($url, $text, $parameters, $this->defaultSecure));
    }

    public function placeholder($text)
    {
        return $this->add(new RawUrl('#', $text));
    }

    public function submenu($text, Closure $setup)
    {
        return $this->add(new RawUrl('#', $text))->submenu($setup);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}