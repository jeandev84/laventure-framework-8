<?php
namespace Laventure\Component\Security\Jwt\Encoder;


use InvalidArgumentException;
use Laventure\Component\Security\Encoder\Base64Encoder;
use Laventure\Component\Security\Encoder\EncoderInterface;
use Laventure\Component\Security\Jwt\Encoder\Exception\InvalidSignatureException;
use Laventure\Component\Security\Jwt\Encoder\Exception\TokenExpiredException;


/**
 * @inheritdoc
*/
class JwtEncoder implements EncoderInterface
{


    /**
     * @var Base64Encoder
    */
    protected Base64Encoder $encoder;




    /**
     * @param string $secretKey
    */
    public function __construct(protected string $secretKey)
    {
         $this->encoder = new Base64Encoder();
    }






    /**
     * @inheritDoc
    */
    public function encode(array $data): string
    {
        $header    = $this->encodeHeaders();
        $payload   = $this->encodePayload($data);
        $signature = $this->encodeSignature($header, $payload);

        return sprintf('%s.%s.%s', $header, $payload, $signature);
    }




    /**
     * @inheritDoc
     *
     * @throws InvalidSignatureException|TokenExpiredException
    */
    public function decode(string $string): array
    {
        $payload = $this->getPayloadParams($string);

        if ($payload['exp'] < time()) {
            throw new TokenExpiredException();
        }

        return $payload;
    }






    /**
     * @param array $data
     *
     * @return string
    */
    protected function encodeFromArray(array $data): string
    {
        return $this->encoder->encode(json_encode($data));
    }







    /**
     * @param string $json
     *
     * @return array
    */
    protected function decodeFromJson(string $json): array
    {
        return json_decode($this->encoder->decode($json), true);
    }





    /**
     * @return string
    */
    protected function encodeHeaders(): string
    {
        return $this->encodeFromArray([
            "type" => "JWT",
            "alg"  => "HS256"
        ]);
    }






    /**
     * @param array $payload
     *
     * @return string
    */
    protected function encodePayload(array $payload): string
    {
        if (empty($payload['exp'])) {
            throw new \RuntimeException("parameter 'exp' is required.");
        }

        return $this->encodeFromArray($payload);
    }






    /**
     * @param string $header
     *
     * @param string $payload
     *
     * @return string
    */
    protected function hashSignature(string $header, string $payload): string
    {
        $signature = sprintf('%s.%s.%s', $header, $payload, $this->secretKey);

        return hash_hmac("sha256", $signature, true);
    }








    /**
     * @param string $header
     *
     * @param string $payload
     *
     * @return string
    */
    protected function encodeSignature(string $header, string $payload): string
    {
        return $this->encoder->encode($this->hashSignature($header, $payload));
    }






    /**
     * @param string $token
     *
     * @return array
     * @throws InvalidSignatureException
    */
    protected function getPayloadParams(string $token): array
    {
        if(preg_match("/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/", $token, $matches) !== 1) {
            throw new InvalidArgumentException("invalid token format");
        }


        $tokenParams = array_filter($matches, function ($key) {
            return is_string($key);
        }, ARRAY_FILTER_USE_KEY);


        $tokenParams = $this->matchSignature($tokenParams);

        return $this->decodeFromJson($tokenParams['payload']);
    }






    /**
     * @param array $tokenParams
     *
     * @return array
     *
     * @throws InvalidSignatureException
    */
    protected function matchSignature(array $tokenParams): array
    {
        $signature = $this->hashSignature($tokenParams['header'], $tokenParams['payload']);
        $signatureFromToken = $this->encoder->decode($tokenParams['signature']);

        if (! hash_equals($signature, $signatureFromToken)) {
            throw new InvalidSignatureException("signature doesn't match");
        }

        return $tokenParams;
    }






    /**
     * @return string
    */
    protected function getSecretKey(): string
    {
         return $this->secretKey;
    }
}