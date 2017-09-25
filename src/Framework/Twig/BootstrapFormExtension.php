<?php

namespace Framework\Twig;

use Twig_SimpleFunction;

/**
 * Class FormExtension
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Twig
 */
class BootstrapFormExtension extends \Twig_Extension
{

    /**
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        $options = [
            'is_safe' => ['html'],
            'needs_context' => true,
        ];
        return [
            new Twig_SimpleFunction('field', [$this, 'field'], $options),
        ];
    }

    /**
     * Build a form HTML field
     * @param array $context
     * @param string $key
     * @param $value
     * @param string $label
     * @param array $options
     * @return string
     */
    public function field(array $context, string $key, $value, string $label, array $options = []): string
    {
        $type = $options['type'] ?? 'text';
        $error = $this->getErrorHTML($context, $key);
        $class = 'form-group';
        $value = $this->convertValue($value);
        $attributes = [
            'class' => 'form-control' . (isset($options['class']) ? ' '.$options['class']: ''),
            'id' => $key,
            'name' => $key,
        ];
        if ($error) {
            $class .= ' has-danger';
            $attributes['class'] .= ' form-control-danger';
        }
        if ($type === 'textarea') {
            $input = $this->textarea($attributes, $value);
        } else {
            $attributes['type'] = $type;
            $input = $this->input($attributes, $value);
        }
        return "
            <div class=\"{$class}\">
                <label for=\"{$key}\">{$label}</label>
                {$input}
                {$error}
            </div>
        ";
    }

    /**
     * Get error in html format
     * @param $context
     * @param $key
     * @return string
     */
    private function getErrorHTML($context, $key)
    {
        $error = $context['errors'][$key] ?? false;
        if ($error) {
            return "<small class=\"form-text text-muted\">{$error}</small>";
        }
        return "";
    }

    /**
     * Build textarea
     * @param array $attributes
     * @param null|string $content
     * @return string
     */
    private function textarea(array $attributes = [], ?string $content = null): string
    {
        return $this->buildTag('textarea', $attributes, $content);
    }

    /**
     * Build input HTML tag
     * @param null|string $value
     * @param array $attributes
     * @return string
     */
    private function input(array $attributes = [], ?string $value = null): string
    {
        if (!is_null($value)) {
            $attributes['value'] = $value;
        }
        return $this->buildTag('input', $attributes);
    }

    /**
     * Build HTML Tag
     * @param string $name
     * @param array $attributes
     * @param null|string $content
     * @return string
     */
    private function buildTag(string $name, array $attributes = [], ?string $content = null): string
    {
        $htmlAttributes = join(' ', array_map(function ($key, $value) {
            return "{$key}=\"{$value}\"";
        }, array_keys($attributes), $attributes));
        if (is_null($content)) {
            return "<{$name} {$htmlAttributes}/>";
        } else {
            return "<{$name} {$htmlAttributes}>{$content}</{$name}>";
        }
    }

    /**
     * Convert value to string
     * @param $value
     * @return string
     */
    private function convertValue($value): string
    {
        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }
        return (string)$value;
    }
}
