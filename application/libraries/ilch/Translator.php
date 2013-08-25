<?php
/**
 * Holds class Ilch_Translator.
 *
 * @author Jainta Martin
 * @copyright Ilch CMS 2.0
 * @package ilch
 */

defined('ACCESS') or die('no direct access');

/**
 * Handles translations for ilch.
 *
 * Loads a translations array from a translation file, searches for translations
 * in the translation array and returns translations.
 *
 * @author Jainta Martin
 * @package ilch
 */
class Ilch_Translator
{
    /**
     * Holds the translations for each loaded translation file.
     *
     * Key as the short locale, value as the translations array from the
     * translations file.
     *
     * @var mixed[]
     */
    private $_translations = array();

    /**
     * The locale in which the texts should be translated.
     *
     * @var string
     */
    private $_locale = 'de_DE';

    /**
     * Sets the locale to use for the request.
     *
     * @param string $locale
     */
    public function __construct($locale = null)
    {
        /*
         * If a setting is given, set the locale to the given one.
         */
        if($locale !== null)
        {
            $this->_locale = $locale;
        }
    }

    /**
     * Loads a translation array for the set locale from the given directory.
     *
     * @param string $transDirectory The directory where the translation resides.
     * @return boolean True if the translations got loaded, false if not.
     */
    public function load($transDir)
    {
        if(!is_dir($transDir))
        {
            return false;
        }

        $localeShort = $this->shortenLocale($this->_locale);
        $transFile = $transDir.'/translations_'.$localeShort.'.php';

        if(is_file($transFile))
        {
            $this->_translations = require $transFile;
            return true;
        }
    }

    /**
     * Returns the translated text for a specific key.
     *
     * Can also replace placeholders with a given string e. g. for names. As
     * default, trans() uses the request locale.
     *
     * @param string $key
     * @param mixed[] $placeholders Key as the placeholder, value as the text which
     * the placeholder gonna be replaced with.
     * @return string
     */
    public function trans($key, $placeholders = array())
    {
        if(isset($this->_translations[$key]))
        {
            $translatedText = $this->_translations[$key];
        }
        else
        {
            /*
             * If no translation exists, return the key as fallback.
             */
            $translatedText = $key;
        }

        foreach($placeholders as $placeholder => $value)
        {
            $translatedText = str_replace($placeholder, $value, $translatedText);
        }

        return $translatedText;
    }

    /**
     * Returns the translation array.
     */
    public function getTranslations()
    {
        return $this->_translations;
    }

    /**
     * Shortens the locale so only the first to characters get returned.
     *
     * @param string $locale
     * @return string
     */
    public function shortenLocale($locale)
    {
        return substr($locale, 0, 2);
    }

    /**
     * Returns the locale used for the translation.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->_locale;
    }
}