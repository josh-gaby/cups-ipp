<?php

namespace Smalot\Cups\Manager\Traits;

use Smalot\Cups\CupsException;

/**
 * Trait LanguageAware
 *
 * @package Smalot\Cups\Manager\Traits
 */
trait LanguageAware
{

    /**
     * @var string
     */
    protected $language;

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     *
     * @return LanguageAware
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string
     * @throws CupsException
     */
    protected function buildLanguage(): string
    {
        $language = strtolower($this->getLanguage());
        return chr(0x48) // natural-language type | value-tag
          .chr(0x00).chr(0x1B) //  name-length
          .'attributes-natural-language' //attributes-natural-language
          .$this->builder->formatStringLength($language) // value-length
          .$language; // value
    }
}
