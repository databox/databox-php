<?php
namespace Databox;

use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

class DataboxException extends BadResponseException
{

    /**
     * Reason for the exception, ie. 'Too Many Requests'
     * @var string
     */
    protected $type;

    /**
     * Message, ie. 'One request every 15 minute is allowed.'
     * @var string
     */
    protected $message;

    /**
     * Factory method to create a new response exception based on the response code.
     *
     * @param RequestInterface $request  Request
     * @param Response         $response Response received
     *
     * @return BadResponseException
     */
    public static function factory(RequestInterface $request, Response $response)
    {
        $data = $response->json();

        // Only override the expected response
        if (!isset($data['data']['type']) || !isset($data['data']['message'])) {
            return parent::factory($request,$response);
        }

        $e = new DataboxException("{$data['data']['type']} ({$data['data']['message']})");
        $e->setResponse($response);
        $e->setRequest($request);

        $e->setType($data['data']['type']);
        $e->setWebMessage($data['data']['message']);

        return $e;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getWebMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setWebMessage($message)
    {
        $this->message = $message;
    }

}
