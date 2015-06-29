<?php

namespace Databox;

/**
 *
 * @author Uros Majeric
 *
 */
class KPI implements \JsonSerializable
{

    /**
     * Name of key
     *
     * @var string
     */
    public $key;

    /**
     * Set value
     *
     * @var string
     */
    public $value;

    /**
     * Set date
     *
     * @var DateTime
     */
    public $date;

    /**
     * Array of attributes
     *
     * @var array
     */
    public $attributes;

    /**
     * The prescribed date format
     */
    const DATE_FORMAT = 'Y-m-d\TH:i:s';

    public function __construct($key, $value, $date = null, array $attributes = null)
    {
        $this->key = $key;
        $this->value = json_encode($value);

        if (is_null($date) || ! ($date instanceof \DateTime)) {
            $UTC = new \DateTimeZone("UTC");
            $date = new \DateTime("now", $UTC);
        }
        $this->date = $date->format(self::DATE_FORMAT);

        if (is_null($attributes)) {
            $this->attributes = [];
        } else {
            $this->attributes = $attributes;
        }
    }

    /**
     * Gets the key
     *
     * @return string The key.
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sets the key
     *
     * @param string $key
     *            The key to be set
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Gets the value
     *
     * @return string The value.
     */
    public function getValue()
    {
        if (json_last_error() == JSON_ERROR_NONE) {
            return json_decode($this->value);
        } else {
            return $this->value;
        }
    }

    /**
     * Sets the value
     *
     * @param string $value
     *            Set the values.
     */
    public function setValue($value)
    {
        $this->value = json_encode($value);
    }

    /**
     * Gets the date
     *
     * @return string [description]
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date
     *
     * @param string $date
     *            [description]
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Adds an attribute to the attribute array
     *
     * @param string $key
     *            The attribute's key
     * @param string $value
     *            The value associated with the key
     */
    public function addAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Removes an attribute from the attribute array
     *
     * @param string $key
     *            The attribute key
     */
    public function removeAttribute($key)
    {
        unset($this->attributes[$key]);
    }

    /**
     * Set the attributes array
     *
     * @param array $attributes
     *            The attribute array
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Gets the attribute array
     *
     * @return array The attributes array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Fetches an individual attribute
     *
     * @param string $key
     *            The key for which the value needs to be fetched
     * @return string The value
     */
    public function getAttribute($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
        return null;
    }

    /*
     * (non-PHPdoc)
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['$' . $this->key] = $this->value;
        if (null !== $this->date) {
            if (($this->date instanceof \DateTime)) {
                $json['date'] = $this->date->format(self::DATE_FORMAT);
            } else {
                $json['date'] = $this->date;
            }
        }
        if (null !== $this->attributes) {
            foreach ($this->attributes as $attribute => $attributeValue) {
                $json[$attribute] = $attributeValue;
            }
        }
        return $json;
    }
}

?>
