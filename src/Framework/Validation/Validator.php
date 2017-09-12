<?php


namespace Framework\Validation;

/**
 * Class Validator
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework
 */
class Validator
{

    /**
     * @var array
     */
    private $params;

    /**
     * @var string[]
     */
    private $errors = [];

    /**
     * Validator constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param string[] ...$keys
     * @return Validator
     */
    public function required(string ...$keys) : self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                $this->addError($key, 'required');
            }
        }
        return $this;
    }

    /**
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Check if param is a slug
     * @param string $key
     * @return self
     */
    public function slug(string $key) : self
    {
        $value = $this->getValue($key);
        if (!is_null($value) && !preg_match('/^([a-z0-9+-?])+$/', $value)) {
            $this->addError($key, 'slug');
        }
        return $this;
    }

    /**
     * Fields must be not empty
     * @param string[] ...$keys
     * @return Validator
     */
    public function notEmpty(string ...$keys) : self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (empty($value)) {
                $this->addError($key, 'empty');
            }
        }
        return $this;
    }

    /**
     * @param string $key
     * @param int|null $min
     * @param int|null $max
     * @return Validator
     */
    public function length(string $key, ?int $min = null, ?int $max = null): self
    {
        $value = $this->getValue($key);
        $length = mb_strlen($value);
        if (!is_null($min) and !is_null($max) and ($length < $min or $length > $max)) {
            $this->addError($key, 'betweenLength', [$min, $max]);
        } elseif (!is_null($min) and $length < $min) {
            $this->addError($key, 'minLength', [$min]);
        } elseif (!is_null($max) and $length > $max) {
            $this->addError($key, 'maxLength', [$max]);
        }
        return $this;
    }

    public function dateTime(string $key, string $format = 'Y-m-d H:i:s'): self
    {
        $value = $this->getValue($key);
        $date = \DateTime::createFromFormat($format, $value);
        $errors = \DateTime::getLastErrors();
        if ($errors['error_count'] > 0 or $errors['warning_count'] > 0 or $date === false) {
            $this->addError($key, 'dateTime', [$format]);
        }
        return $this;
    }

    /**
     * Validator is valid if we have not errors
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Add error
     * @param string $key
     * @param string $rule
     * @param array $attributes
     */
    private function addError(string $key, string $rule, array $attributes = [])
    {
        $this->errors[$key] = new ValidationError($key, $rule, $attributes);
    }
    
    
    /**
     * Get value in params
     * @param string $key
     * @return NULL|mixed
     */
    private function getValue(string $key)
    {
        return $this->params[$key] ?? null;
    }
}
