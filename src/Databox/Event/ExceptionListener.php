<?php
namespace Databox\Event;

use Guzzle\Common\Event;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Databox\DataboxException;

class ExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'request.error'        => array('onRequestError',-1),
        );
    }

    /**
     * Called when an error is returned
     *
     * @param Event $event Event emitted
     */
    public function onRequestError(Event $event)
    {
        $response = $event['response']; /* @var $response Response */
        $request = $event['request']; /* @var $request RequestInterface */

        if ($response && ($response->getStatusCode() == 400 || $response->getStatusCode() == 500 || $response->getStatusCode() == 401) && $response->isContentType('application/json')) {
            $event->stopPropagation();
            $e = DataboxException::factory($request,$response);
            throw $e;
        }
    }
}
