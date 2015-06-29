<?php
namespace Databox\Event;

use Guzzle\Common\Event;
use Guzzle\Common\Collection;
use Guzzle\Http\Message\EntityEnclosingRequestInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Databox Auth
 * @package Databox
 */
class AuthListener implements EventSubscriberInterface
{
    /**
     *  @var string API Key
     */
    private $apiKey;

    /**
     * Construct a new auth plugin
     *
     * @param string $apiKey apiKey for the connection
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => array('onRequestBeforeSend', -1000)
        );
    }

    public function setApiKey($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * Request before-send event handler
     *
     * @param Event $event Event received
     */
    public function onRequestBeforeSend(Event $event)
    {
        $request = $event['request'];

        if (!is_array($request->getHeader('Accept'))) {
            $request->setheader('Accept', 'application/json');
        }
        $header = $request->getHeader('Authorization');
        if (isset($this->apiKey) && empty($header)) {
            $request->setAuth($this->apiKey, '', 'Basic');
        }
        $request->setHeader('Content-Type', 'application/json');
    }
}
