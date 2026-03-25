<?php

namespace App\Foundation;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct($basePath = null)
    {
        parent::__construct($basePath);
        $this->publicPath = $basePath . '/public_html';
        $this->instance('path.public', $this->publicPath());
    }
}
