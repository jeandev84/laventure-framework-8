<?php
namespace Laventure\Component\Security\Encoder;

/**
 * @inheritdoc
*/
class Base64Encoder implements Base64EncoderInterface
{

    /**
     * @inheritDoc
    */
    public function encode(string $string): string
    {
        return str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($string));
    }




    /**
     * @inheritDoc
    */
    public function decode(string $string): string
    {
        return base64_decode(str_replace(["-", '_'], ["+", "/"], $string));
    }
}