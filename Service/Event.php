<?php

namespace ConsulBundle\Service;

use SensioLabs\Consul\Client;
use SensioLabs\Consul\OptionsResolver;

/**
 * Class Event
 * @package ConsulBundle\Service
 */
final class Event implements EventInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Event constructor.
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * @param $name
     * @param $payload
     * @param array $options
     * @return \SensioLabs\Consul\ConsulResponse
     */
    public function fire($name, $payload = null, array $options = array())
    {
        $params = array(
          'body' => $payload,
          'query' => OptionsResolver::resolve($options, array('dc', 'node', 'service', 'tag')),
        );

        return $this->client->put('/v1/event/fire/'. $name, $params);
    }

    /**
     * @param array $options
     * @return \SensioLabs\Consul\ConsulResponse
     */
    public function list(array $options = array())
    {
        $params = array(
          'query' => OptionsResolver::resolve($options, array('name', 'node', 'service', 'tag')),
        );

        return $this->client->get('/v1/event/list', $params);
    }
}
