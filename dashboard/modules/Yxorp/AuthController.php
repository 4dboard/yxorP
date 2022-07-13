<?php namespace yxorP;
class AuthController extends \LimeExtra\Controller
{
    protected $layout = 'yxorp:views/layouts/app.php';
    protected $user;

    public function __construct($app)
    {
        $user = $app->module('yxorp')->getUser();
        if (!$user) {
            $app->reroute('/auth/login?to=' . $app->retrieve('route'));
            $app->stop();
        }
        parent::__construct($app);
        $this->user = $user;
        $app['user'] = $user;
        $controller = \strtolower(\str_replace('\\', '.', \get_class($this)));
        $app->trigger("app.{$controller}.init", [$this]);
    }
}