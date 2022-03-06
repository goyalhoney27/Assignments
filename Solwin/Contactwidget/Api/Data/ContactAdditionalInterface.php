<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Solwin\Contactwidget\Api\Data;

interface ContactAdditionalInterface
{

    const EMAIL = 'email';
    const COMMENT = 'comment';
    const ATTACHMENT = 'attachment';
    const NAME = 'name';
    const CONTACTADDITIONAL_ID = 'contactadditional_id';
    const FORMTYPE = 'formtype';
    const SUBJECT = 'subject';
    const CUSTOMERTYPE = 'customertype';

    /**
     * Get contactadditional_id
     * @return string|null
     */
    public function getContactadditionalId();

    /**
     * Set contactadditional_id
     * @param string $contactadditionalId
     * @return \Solwin\Contactwidget\ContactAdditional\Api\Data\ContactAdditionalInterface
     */
    public function setContactadditionalId($contactadditionalId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Solwin\Contactwidget\ContactAdditional\Api\Data\ContactAdditionalInterface
     */
    public function setName($name);

    /**
     * Get email
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     * @param string $email
     * @return \Solwin\Contactwidget\ContactAdditional\Api\Data\ContactAdditionalInterface
     */
    public function setEmail($email);

    /**
     * Get subject
     * @return string|null
     */
    public function getSubject();

    /**
     * Set subject
     * @param string $subject
     * @return \Solwin\Contactwidget\ContactAdditional\Api\Data\ContactAdditionalInterface
     */
    public function setSubject($subject);

    /**
     * Get comment
     * @return string|null
     */
    public function getComment();

    /**
     * Set comment
     * @param string $comment
     * @return \Solwin\Contactwidget\ContactAdditional\Api\Data\ContactAdditionalInterface
     */
    public function setComment($comment);

    /**
     * Get attachment
     * @return string|null
     */
    public function getAttachment();

    /**
     * Set attachment
     * @param string $attachment
     * @return \Solwin\Contactwidget\ContactAdditional\Api\Data\ContactAdditionalInterface
     */
    public function setAttachment($attachment);

    /**
     * Get formtype
     * @return string|null
     */
    public function getFormtype();

    /**
     * Set formtype
     * @param string $formtype
     * @return \Solwin\Contactwidget\ContactAdditional\Api\Data\ContactAdditionalInterface
     */
    public function setFormtype($formtype);

    /**
     * Get customertype
     * @return string|null
     */
    public function getCustomertype();

    /**
     * Set customertype
     * @param string $customertype
     * @return \Solwin\Contactwidget\ContactAdditional\Api\Data\ContactAdditionalInterface
     */
    public function setCustomertype($customertype);
}

