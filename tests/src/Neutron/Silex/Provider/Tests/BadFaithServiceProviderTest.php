<?php

namespace Neutron\Silex\Provider\Tests;

use Neutron\Silex\Provider\BadFaithServiceProvider;
use Silex\Application;
use Symfony\Component\HttpKernel\Client;

class BadFaithServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $negotiator = null;

        $app = new Application();
        $app->register(new BadFaithServiceProvider());
        $app->get('/', function(Application $app) use (&$negotiator) {
            $negotiator = $app['bad-faith'];
        });

        $client = new Client($app, array());
        $client->request('GET', '/');

        $this->assertInstanceOf('BadFaith\\Negotiator', $negotiator);
    }
}
