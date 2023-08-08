<?php
namespace Laventure\Component\Security\Jwt\Authenticator;

use Laventure\Component\Security\Jwt\Encoder\JwtEncoderInterface;

class JwtAuthenticator
{

      /**
       * @var JwtEncoderInterface
      */
      protected JwtEncoderInterface $encoder;



      public function __construct()
      {
      }
}