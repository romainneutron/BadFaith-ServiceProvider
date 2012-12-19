<?php

/*
 * This file is part of Filesystem Service Provider.
 *
 * (c) 2012 Romain Neutron <imprec@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Neutron\Silex\Provider;

use BadFaith\Negotiator;
use Silex\Application;
use Silex\ServiceProviderInterface;

class BadFaithServiceProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app['bad-faith'] = $app->share(function(Application $app) {
            $server = $app['request']->server->all();
            $normalized = array();
            array_walk($server, function($header, &$key) use (&$normalized) {
                $key = strtolower($key);
                if (strpos($key, 'http_') === 0) {
                    $key = substr($key, 5);
                }
                $normalized[$key] = $header;
            });

            return new Negotiator($normalized, $app['bad-faith.variants']);
        });

        $app['bad-faith.variants'] = array();
    }

    public function boot(Application $app)
    {
    }
}
