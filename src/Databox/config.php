<?php
/**
 * Databox Push API description.
 * See developers.databox.com for more info
 * Provided as a PHP array to allow PHP APC caching
 */
return array(
    'name' => 'Databox',
    'apiVersion' => '2.0',
    'description' => 'Databox PushAPI client',
    'operations' => array(
        'SetPushData' => array(
            'httpMethod' => 'POST',
            'uri' => '',
            'summary' => 'Push data to your custom connection',
            'responseClass' => 'SetPushDataOutput',
            'parameters' => array(
                'payload' => array(
                    'description' => 'The actual data payload',
                    'type' => 'string',
                    'location' => 'body',
                    'required' => true
                ),
            )
        ),
        'GetPushDataLog' => array(
            'httpMethod' => 'POST',
            'uri' => 'lastpushes',
            'summary' => 'Get a log of last pushed data',
            'responseClass' => 'GetPushDataLogOutput',
            'parameters' => array()
            )
        )
    ),
    'models' => array(
        'SetPushDataOutput' => array(
            'type' => 'object',
            'additionalProperties' => array(
                'location' => 'json'
            )
        ),
        'GetPushDataLogOutput' => array(
            'type' => 'object',
            'additionalProperties' => array(
                'location' => 'json'
            )
        ),
    )
);
