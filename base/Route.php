<?php


namespace V_Corp\base;

class Route
{

    protected static $errorView = null;
    protected $urls = [];
    protected $methods = [];

    protected function matchUrl($url)
    {
        $parse_url = parse_url($_SERVER['REQUEST_URI']);
        preg_match('#^' . $url . '$#', $parse_url['path'], $matches);

        return (is_array($matches) && count($matches)) ? $matches : false;
    }

    protected function methods()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        return array_key_exists($method, $this->urls) ? $this->urls[$method] : null;
    }

    protected function notFound()
    {
        return ['handler' => [(new static::$errorView('main', 404, 'Page Not Found')), 'render']];
    }

    public function handle()
    {
        $this->methods = self::methods();
        if ($this->methods) {
            $matches = static::matches();
            if ($matches) {
                return static::result($matches);
            }
        }

        return self::notFound();
    }
}