<?php

namespace App;

use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;

class DualKernel implements HttpKernelInterface, TerminableInterface
{
    /**
     * @var Kernel
     */
    private $adminKernel;

    /**
     * @var Kernel
     */
    private $websiteKernel;

    /**
     * @param mixed[] $context
     */
    public function __construct($context)
    {
        (new Dotenv())->bootEnv(\dirname(__DIR__) . '/.env');

        Request::enableHttpMethodParameterOverride();

        $this->adminKernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG'], SuluKernel::CONTEXT_ADMIN);

        $this->websiteKernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG'], SuluKernel::CONTEXT_WEBSITE);

        // Comment this line if you want to use the "varnish" http
        // caching strategy. See http://sulu.readthedocs.org/en/latest/cookbook/caching-with-varnish.html
        // if ('dev' !== $context['APP_ENV']) {
        //    $this->websiteKernel = $this->websiteKernel->getHttpCache();
        // }
    }

    public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
    {
        (new Dotenv())->bootEnv(\dirname(__DIR__) . '/.env');

        if (preg_match('/^\/admin(\/|$)/', $request->getPathInfo())) {
            return $this->adminKernel->handle($request, $type, $catch);
        }

        return $this->websiteKernel->handle($request, $type, $catch);
    }

    public function terminate(Request $request, Response $response)
    {
        if (preg_match('/^\/admin(\/|$)/', $request->getPathInfo())) {
            return $this->adminKernel->terminate($request, $response);
        }

        return $this->websiteKernel->terminate($request, $response);
    }
}
