<?php

/**
 * Copyright (c) 2018, TransChain.
 *
 * This source code is licensed under the Apache 2.0 license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace KatenaChain\Client\Crypto\X25519;

use Exception;
use KatenaChain\Client\Crypto\AbstractKey;
use ParagonIE_Sodium_Compat;
use SodiumException;

/**
 * PrivateKey is an X25519 private key wrapper (64 bytes).
 */
class PrivateKey extends AbstractKey
{

    /**
     * seal encrypts a plain text message decipherable afterwards by the recipient public key.
     * @param string $message
     * @param PublicKey $recipientPublicKey
     * @return array ["encryptedMessage" => string, "nonce" => string]
     * @throws SodiumException
     * @throws Exception
     */
    public function seal(string $message, PublicKey $recipientPublicKey): array
    {
        $keyPair = ParagonIE_Sodium_Compat::crypto_box_keypair_from_secretkey_and_publickey(
            $this->key,
            $recipientPublicKey->getKey()
        );
        $nonce = random_bytes("24");
        $encryptedMessage = ParagonIE_Sodium_Compat::crypto_box($message, $nonce, $keyPair);
        return [
            'encryptedMessage' => $encryptedMessage,
            'nonce'            => $nonce,
        ];
    }

    /**
     * open decrypts an encrypted message with the appropriate sender information.
     * @param string $encryptedMessage
     * @param PublicKey $senderPublicKey
     * @param string $nonce
     * @return string
     * @throws SodiumException
     */
    public function open(string $encryptedMessage, PublicKey $senderPublicKey, string $nonce): string
    {
        $keyPair = ParagonIE_Sodium_Compat::crypto_box_keypair_from_secretkey_and_publickey(
            $this->key,
            $senderPublicKey->getKey()
        );
        return ParagonIE_Sodium_Compat::crypto_box_open($encryptedMessage, $nonce, $keyPair);
    }
}
