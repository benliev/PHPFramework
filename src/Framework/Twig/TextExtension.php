<?php

namespace Framework\Twig;

use Twig_SimpleFilter;

/**
 * Class TextExtension
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Twig
 */
class TextExtension extends \Twig_Extension
{
    /**
     * @return Twig_SimpleFilter[]
     */
    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter('excerpt', [$this, 'excerpt'])
        ];
    }

    /**
     * Return an excerpt of the content
     * @param string $content
     * @param int $maxLength
     * @return string
     */
    public function excerpt(string $content, int $maxLength = 100) : string
    {
        if (mb_strlen($content) > $maxLength) {
            $excerpt = mb_substr($content, 0, $maxLength);
            $posLastSpace = mb_strrpos($excerpt, ' ', -1);
            return mb_substr($excerpt, 0, $posLastSpace) . '...';
        }
        return $content;
    }
}
