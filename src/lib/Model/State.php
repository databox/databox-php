<?php
/**
 * State
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  Databox
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Static OpenAPI document of Push API resource
 *
 * Push API resources Open API documentation
 *
 * The version of the OpenAPI document: 0.3.15-sdk.5
 * Generated by: https://openapi-generator.tech
 * Generator version: 7.6.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Databox\Model;
use \Databox\ObjectSerializer;

/**
 * State Class Doc Comment
 *
 * @category Class
 * @package  Databox
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class State
{
    /**
     * Possible values of this enum
     */
    public const DOWN = 'DOWN';

    public const UP = 'UP';

    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::DOWN,
            self::UP
        ];
    }
}


