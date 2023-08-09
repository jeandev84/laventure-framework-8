<?php
namespace Laventure\Component\Security\Jwt\Provider;

use Laventure\Component\Security\Jwt\Encoder\JwtEncoder;
use Laventure\Component\Security\User\Token\UserTokenInterface;
use Laventure\Component\Security\User\UserInterface;

class JwtProvider implements JwtProviderInterface
{

         /**
         * @param JwtEncoder $encoder
        */
        public function __construct(protected JwtEncoder $encoder)
        {
        }




        /**
         * @inheritDoc
        */
        public function findById(int $id): ?UserInterface
        {

        }




        /**
         * @inheritDoc
        */
        public function findByUsername(string $username): ?UserInterface
        {

        }





        /**
         * @inheritDoc
        */
        public function findByRememberIdentifier($identifier): ?UserInterface
        {

        }




        /**
         * @inheritDoc
        */
        public function updatePasswordHash(UserInterface $user, string $hash): mixed
        {

        }




        /**
         * @inheritDoc
        */
        public function updateRememberToken(UserInterface $user, string $hash): mixed
        {

        }





       /**
        * @inheritDoc
       */
       public function getToken(): UserTokenInterface
       {

       }





      /**
       * @inheritDoc
      */
      public function createToken(UserInterface $user): UserTokenInterface
      {

      }




      /**
       * @inheritDoc
      */
      public function hasToken(): bool
      {

      }




     /**
      * @inheritDoc
     */
     public function removeToken(UserInterface $user): bool
     {

     }




    /**
     * @inheritDoc
    */
    public function createRememberToken(UserInterface $user): static
    {

    }




    /**
     * @inheritDoc
    */
    public function hasRememberToken(): bool
    {

    }




    /**
     * @inheritDoc
    */
    public function removeRememberToken(UserInterface $user)
    {

    }
}