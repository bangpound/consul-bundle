<?php

namespace ConsulBundle\Controller;

use SensioLabs\Consul\ClientInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProxyController
 * @package ConsulBundle\Controller
 */
class ProxyController
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param $url
     * @param Request $request
     * @return mixed
     */
    public function __invoke($url, Request $request)
    {
        $method = $request->getMethod();
        return call_user_func([$this->client, $method], $url, [
            'query' => $request->query->all(),
            'body' => $request->getContent(),
            'headers' => $request->headers->all(),
        ]);
    }
}
