<?php
namespace Laventure\Component\Filesystem\File;

/**
 * @Base64File
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Filesystem\File
*/
class Base64File
{

    /**
     * @var string
    */
    protected string $encodedString;



    /**
     * @var string
    */
    protected string $extension;



    /**
     * @param string $encodedString
     *
     * @param string $extension
    */
    public function __construct(string $encodedString, string $extension = '')
    {
        $this->encodedString = $encodedString;
        $this->extension     = $extension;
    }





    /**
     * @return bool
    */
    public function valid(): bool
    {
        return preg_match('/^(?:[data]{4}:(text|image|application)\/[a-z]*)/', $this->encodedString);
    }






    /**
     * @param bool $strict
     *
     * @return bool|string
    */
    public function decode(bool $strict = false): bool|string
    {
        return base64_decode($this->encodedString, $strict);
    }





    /**
     * @return string
     */
    public function source(): string
    {
        return $this->encodedString;
    }





    /**
     * @return string
    */
    public function data(): string
    {
        $content = explode(';base64,', $this->encodedString, 2)[1] ?? '';

        if (! $content) {
            return '';
        };

        return base64_decode($content);
    }






    /**
     * @return string
     */
    public function extension(): string
    {
        if ($this->extension) {
            return $this->extension;
        }

        return explode('/', $this->mimeType(), 2)[1] ?? '';
    }






    /**
     * @return int
     */
    public function size(): int
    {
        return @getimagesize($this->encodedString);
    }






    /**
     * @return string
     */
    public function mimeType(): string
    {
        return @mime_content_type($this->encodedString);
    }





    /**
     * @param array $allowedFileTypes
     *
     * @return bool
    */
    public function allowedTypes(array $allowedFileTypes): bool
    {
        return in_array($this->mimeType(), $allowedFileTypes);
    }
}