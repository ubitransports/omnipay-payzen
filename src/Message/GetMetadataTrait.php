<?php

namespace Omnipay\PayZen\Message;

trait GetMetadataTrait
{
    public function getMetadata(): array
    {
        $prefix = 'vads_ext_info_';
        $metadata = array();

        foreach ($this->data as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $metadata[substr($key, strlen($prefix))] = $value;
            }
        }

        return $metadata;
    }
}
