<?php


namespace Framework\Validation;

/**
 * Class ValidationError
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Validation
 */
class ValidationError
{

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $rule;

    /**
     * @var array
     */
    private static $messages = [
        'required' => 'Le champs %s est requis',
        'empty' => 'Le champs %s ne peut �tre vide',
        'slug' => 'Le champs %s n\'est pas un slug valide',
        'minLength' => 'le champs %s doit contenir plus de %d caractères',
        'maxLength' => 'le champs %s doit contenir moins de %d caractères',
        'betweenLength' => 'Le champs %s doit contenir entre %d et %d caractères',
        'dateTime' => 'Le champs %s doit être une date valide (%s)',
    ];

    /**
     * @var array
     */
    private $attributes;

    /**
     * ValidationError constructor.
     * @param string $key
     * @param string $rule
     * @param array $attributes
     */
    public function __construct(string $key, string $rule, array $attributes = [])
    {
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }

    /**
     * Return the error message
     * @return string
     */
    public function __toString() : string
    {
        $params = array_merge([
            self::$messages[$this->rule],
            $this->key
        ], $this->attributes);
        return call_user_func_array('sprintf', $params);
    }
}
