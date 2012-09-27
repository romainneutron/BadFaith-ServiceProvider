#BadFaith Silex ServiceProvider

BadFaith is a content negociation library you will find
[here](https://github.com/winmillwill/BadFaith).

Here is the Silex Service Provider :

```php
$app = new Application();
$app->register(new BadFaithServiceProvider());

// optionnal variants
$app['bad-faith.variants'] = array(
    'charset'=> 'UTF-8,iso-8859-1;q=0.9'
);

$app->get('/', function(Application $app) {
    $app['bad-faith']->getPreferred('encoding');
});
$app->run();
```

##License

MIT License
