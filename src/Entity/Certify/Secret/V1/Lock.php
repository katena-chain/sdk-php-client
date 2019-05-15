<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Entity\Certify\Secret\V1;

use KatenaChain\Client\Crypto\X25519\PublicKey;

/**
 * Lock is a wrapper to an X25519 encryptor (32 bytes), its corresponding nonce (24 bytes) and the raw encrypted content
 * (16 < x < 128 bytes) to perform an ECDH shared key agreement.
 */
class Lock
{
    /**
     * @var PublicKey
     */
    protected $encryptor;

    /**
     * @var string
     */
    protected $nonce;

    /**
     * @var string
     */
    protected $content;

    /**
     * Lock constructor.
     * @param PublicKey $encryptor
     * @param string $nonce
     * @param string $content
     */
    public function __construct(PublicKey $encryptor, string $nonce, string $content)
    {
        $this->encryptor = $encryptor;
        $this->nonce = $nonce;
        $this->content = $content;
    }

    /**
     * content getter.
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * encryptor getter.
     * @return PublicKey
     */
    public function getEncryptor(): PublicKey
    {
        return $this->encryptor;
    }

    /**
     * nonce getter.
     * @return string
     */
    public function getNonce(): string
    {
        return $this->nonce;
    }

    /**
     * toArray returns the array representation of a Lock.
     * @return array
     */
    public function toArray(): array
    {
        return [
            'content'   => base64_encode($this->content),
            'encryptor' => base64_encode($this->encryptor->getKey()),
            'nonce'     => base64_encode($this->nonce),
        ];
    }

    /**
     * fromArray accepts an array representation of a Lock and returns a new instance.
     * @param array $array
     * @return Lock
     */
    public static function fromArray(array $array): self
    {
        $encryptor = new PublicKey(base64_decode($array['encryptor']));
        return new self($encryptor, base64_decode($array['nonce']), base64_decode($array['content']));
    }
}
