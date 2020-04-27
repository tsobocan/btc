<?php

    class BlockChainConnector
    {

        private $api_url;

        public function __construct()
        {
            $this->api_url = 'https://blockchain.info/rawtx/';
        }

        public function getData($tx_hash)
        {
            try {
                return file_get_contents($this->buildURL($tx_hash));
            } catch (Exception $e) {
                return NULL;
            }
        }

        private function buildURL($tx_hash)
        {
            return $this->api_url . $tx_hash;
        }
    }