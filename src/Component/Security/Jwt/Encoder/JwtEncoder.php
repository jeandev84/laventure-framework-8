<?php
namespace Laventure\Component\Security\Jwt\Encoder;


use Laventure\Component\Security\Encoder\Base64Encoder;

/**
 * @inheritdoc
*/
class JwtEncoder implements JwtEncoderInterface
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
    */
    public function decode(string $string): array
    {

    }






    /**
     * @param array $data
     *
     * @return string
    */
    public function encodeFromArray(array $data): string
    {
        return $this->encoder->encode(json_encode($data));
    }







    /**
     * @param string $json
     *
     * @return array
    */
    public function decodeFromJson(string $json): array
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
        return $this->encodeFromArray($payload);
    }





    /**
     * @param string $signature
     *
     * @return string
    */
    protected function hashSignature(string $signature): string
    {
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
        $signature = sprintf('%s.%s.%s', $header, $payload, $this->secretKey);

        return $this->hashSignature($signature);
    }




    /**
     * @param string $token
     *
     * @return array
    */
    protected function getPayloadFromToken(string $token): array
    {

    }
}