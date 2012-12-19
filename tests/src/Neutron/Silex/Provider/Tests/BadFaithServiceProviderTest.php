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

    public function testGetVariants()
    {
        $preferred = null;

        $app = new Application();
        $app->register(new BadFaithServiceProvider());
        $app->get('/', function(Application $app) use (&$preferred) {
            $preferred = $app['bad-faith']->headerLists['accept_language']->getPreferred();
        });

        $client = new Client($app, array());
        $client->request('GET', '/', array(), array(), array(
            'HTTP_ACCEPT_ENCODING' => 'gzip,deflate,sdch',
            'HTTP_ACCEPT_LANGUAGE' => 'de-DE,en;q=0.8',
        ));

        $this->assertEquals('de-DE', $preferred->pref);
    }
}
