<?php

namespace Kount;

use Kount_Ris_Request_Inquiry;
use Kount_Ris_Request_Update;
use Serializable;

class RisClient implements Serializable
{
    /**
     * Normal inquiry
     * @var Kount_Ris_Request_Inquiry|null
     */
    protected $inquiryClient = null;

    /**
     * Normal inquiry
     * @var Kount_Ris_Request_Update|null
     */
    protected $updateClient = null;

    /** This is designed to be cached
     * @param $inqueryClient Kount_Ris_Request_Inquiry Freshly initialized inquiry client
     * @param $updateClient Kount_Ris_Request_Update Freshly initialized update client
     */
    public function __construct($inqueryClient = null, $updateClient = null)
    {
        $this->inquiryClient = $inqueryClient;
        $this->updateClient = $updateClient;
    }

    public function getInquiryClient(): ?Kount_Ris_Request_Inquiry
    {
        return $this->inquiryClient;
    }

    public function setInquiryClient(?Kount_Ris_Request_Inquiry $inquiryClient): void
    {
        $this->inquiryClient = $inquiryClient;
    }

    public function getUpdateClient(): ?Kount_Ris_Request_Update
    {
        return $this->updateClient;
    }

    public function setUpdateClient(?Kount_Ris_Request_Update $updateClient): void
    {
        $this->updateClient = $updateClient;
    }

    public function serialize(): ?string
    {
        $data = $this->__serialize();

         return serialize($data);
    }

    public function unserialize($data): void
    {
        $unserialized = unserialize($data);

        $this->inquiryClient = $unserialized['inquiry'];
        $this->updateClient = $unserialized['update'];
    }

    public function __serialize(): array
    {
       return array(
            'inquiry' => $this->inquiryClient,
            'update' => $this->updateClient
        );
    }

    public function __unserialize(array $data): void
    {
        $this->unserialize($data['inquiry']);
    }
}