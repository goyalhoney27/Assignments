<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Solwin\Contactwidget\Model;

use Magento\Framework\Model\AbstractModel;
use Solwin\Contactwidget\Api\Data\ContactAdditionalInterface;

class ContactAdditional extends AbstractModel implements ContactAdditionalInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Solwin\Contactwidget\Model\ResourceModel\ContactAdditional::class);
    }

    /**
     * @inheritDoc
     */
    public function getContactadditionalId()
    {
        return $this->getData(self::CONTACTADDITIONAL_ID);
    }

    /**
     * @inheritDoc
     */
    public function setContactadditionalId($contactadditionalId)
    {
        return $this->setData(self::CONTACTADDITIONAL_ID, $contactadditionalId);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @inheritDoc
     */
    public function getSubject()
    {
        return $this->getData(self::SUBJECT);
    }

    /**
     * @inheritDoc
     */
    public function setSubject($subject)
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    /**
     * @inheritDoc
     */
    public function getComment()
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * @inheritDoc
     */
    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * @inheritDoc
     */
    public function getAttachment()
    {
        return $this->getData(self::ATTACHMENT);
    }

    /**
     * @inheritDoc
     */
    public function setAttachment($attachment)
    {
        return $this->setData(self::ATTACHMENT, $attachment);
    }

    /**
     * @inheritDoc
     */
    public function getFormtype()
    {
        return $this->getData(self::FORMTYPE);
    }

    /**
     * @inheritDoc
     */
    public function setFormtype($formtype)
    {
        return $this->setData(self::FORMTYPE, $formtype);
    }

    /**
     * @inheritDoc
     */
    public function getCustomertype()
    {
        return $this->getData(self::CUSTOMERTYPE);
    }

    /**
     * @inheritDoc
     */
    public function setCustomertype($customertype)
    {
        return $this->setData(self::CUSTOMERTYPE, $customertype);
    }
}

