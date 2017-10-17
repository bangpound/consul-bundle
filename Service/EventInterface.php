<?php

namespace ConsulBundle\Service;

interface EventInterface
{
    const SERVICE_NAME = 'event';

    /**
     * @param $name
     * @param $payload
     * @param array $options
     * @return \SensioLabs\Consul\ConsulResponse
     */
    public function fire($name, $payload = null, array $options = array());

    /**
     * @param array $options
     * @return \SensioLabs\Consul\ConsulResponse
     */
    public function list(array $options = array());
}