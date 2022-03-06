<?php
/**
 * Solwin Infotech
 * Solwin Contact Form Widget Extension
 *
 * @category   Solwin
 * @package    Solwin_Contactwidget
 * @copyright  Copyright © 2006-2020 Solwin (https://www.solwininfotech.com)
 * @license    https://www.solwininfotech.com/magento-extension-license/
 */
namespace Solwin\Contactwidget\Controller\Widget;

/*use Magento\Framework\Mail\Template\TransportBuilder;*/
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Area;
use Zend\Mime\PartFactory;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Zend\Mime\Mime;
use Solwin\Contactwidget\Model\Mail\TransportBuilder;
use Solwin\Contactwidget\Model\ContactAdditionalFactory;

class Index extends \Magento\Framework\App\Action\Action
{

    const FOLDER_LOCATION = 'contactattachment';
    const EMAIL_TEMPLATE = 'contactwidget_section/emailsend/emailtemplate';
    const EMAIL_SENDER = 'contactwidget_section/emailsend/emailsenderto';
    const XML_PATH_EMAIL_RECIPIENT = 'contactwidget_section/emailsend/emailto';
    const REQUEST_URL = 'https://www.google.com/recaptcha/api/siteverify';
    const REQUEST_RESPONSE = 'g-recaptcha-response';

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    protected $partFactory;

    protected $attachments = [];

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var StateInterface
     */
    protected $_inlineTranslation;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var UploaderFactory
     */
    private $fileUploaderFactory;

    /**
     * @var \Solwin\Contactwidget\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $file;


    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Solwin\Contactwidget\Helper\Data $helper,
        ContactAdditionalFactory $modelContactFactory,
        PartFactory $partFactory,
        UploaderFactory $fileUploaderFactory,
        Filesystem $fileSystem,
        File $file
    ) {
        parent::__construct($context);
        $this->_transportBuilder = $transportBuilder;
        $this->_inlineTranslation = $inlineTranslation;
        $this->partFactory = $partFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->modelContactFactory = $modelContactFactory;
        $this->file = $file;
        $this->_helper = $helper;
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->_storeManager = $storeManager;
        $this->fileSystem = $fileSystem;
    }

    public function execute()
    {

        $remoteAddr = filter_input(
            INPUT_SERVER,
            'REMOTE_ADDR',
            FILTER_SANITIZE_STRING
        );
        $data = $this->getRequest()->getParams();
        $resultRedirect = $this->resultRedirectFactory->create();

            if ($data) {
            $name = $data['name'];
            $email = $data['email'];
            $subject = $data['subject'];
            $commnet = $data['comment'];
            $birthday = $data['birthday'];
            $formtype = $data['formtype'];
            $customertype = $data['customertype'];
            $model = $this->modelContactFactory->create();
            $model->setData($data)->save();
            }

        $data['name'] = $this->removeScriptTag($data['name']);
        if ($data['name'] == "") {
            $this->messageManager->addError(__('Name is required field. Please Enter correct value.'));
            $resultRedirect->setPath($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $data['subject'] = $this->removeScriptTag($data['subject']);
        if ($data['subject'] == "") {
            $this->messageManager->addError(__('Subject is required field. Please Enter correct value.'));
            $resultRedirect->setPath($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $data['comment'] = $this->removeScriptTag($data['comment']);
        if ($data['comment'] == "") {
            $this->messageManager->addError(__('What’s on your mind? is required field. Please Enter correct value.'));
            $resultRedirect->setPath($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $data['birthday'] = $this->removeScriptTag($data['birthday']);
        if ($data['birthday'] == "") {
            $this->messageManager->addError(__('Please Enter a Birthday Date.'));
            $resultRedirect->setPath($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $data['formtype'] = $this->removeScriptTag($data['formtype']);
        if ($data['formtype'] == "") {
            $this->messageManager->addError(__('Please Enter a Form Type.'));
            $resultRedirect->setPath($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $data['customertype'] = $this->removeScriptTag($data['customertype']);
        if ($data['customertype'] == "") {
            $this->messageManager->addError(__('Please Choose Customer Type.'));
            $resultRedirect->setPath($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }


        $redirectUrl = $data['currUrl'];
        $secretkey = $this->_helper
                ->getConfigValue(
                    'contactwidget_section/recaptcha/recaptcha_secretkey'
                );
        $sitekey = $this->_helper
                ->getConfigValue(
                    'contactwidget_section/recaptcha/recaptcha_sitekey'
                );
        $enablerecaptcha = $data['enablerecaptcha'];
        if ($enablerecaptcha && ($sitekey == "" || $secretkey == "")) {
            $this->messageManager->addError('Recaptcha enabled but the captcha site key or secret key may be empty. Please contact the store admin for this issue.');
            return $resultRedirect->setUrl($redirectUrl);
        }

        $captchaErrorMsg = $this->_helper
                ->getConfigValue(
                    'contactwidget_section/recaptcha/recaptcha_errormessage'
                );

        if ($data['enablerecaptcha']) {
            if ($captchaErrorMsg == '') {
                $captchaErrorMsg = 'Invalid captcha. Please try again.';
            }
            $captcha = '';
            if (filter_input(INPUT_POST, 'g-recaptcha-response') !== null) {
                $captcha = filter_input(INPUT_POST, 'g-recaptcha-response');
            }

            if (!$captcha) {
                $this->messageManager->addError($captchaErrorMsg);
                return $resultRedirect->setUrl($redirectUrl);
            } else {
                $response = file_get_contents(
                    "https://www.google.com/recaptcha/api/siteverify"
                        . "?secret=" . $secretkey
                        . "&response=" . $captcha
                    . "&remoteip=" . $remoteAddr
                );
                $response = json_decode($response, true);

                if ($response["success"] === false) {
                    $this->messageManager->addError($captchaErrorMsg);
                    return $resultRedirect->setUrl($redirectUrl);
                }
            }
        }

        try {

            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($data);

            $error = false;

            if (!\Zend_Validate::is(trim($data['name']), 'NotEmpty')) {
                $error = true;
            }

            if (!\Zend_Validate::is(trim($data['email']), 'NotEmpty')) {
                $error = true;
            }

            if (!\Zend_Validate::is(trim($data['subject']), 'NotEmpty')) {
                $error = true;
            }

            if (!\Zend_Validate::is(trim($data['comment']), 'NotEmpty')) {
                $error = true;
            }

            if ($error) {
                throw new \Exception();
            }



        $filePath = null;
        $fileName = null;
        $uploaded = false;

        try {
            $fileCheck = $this->fileUploaderFactory->create(['fileId' => 'attachment']);
            $file = $fileCheck->validateFile();
            $attachment = $file['name'] ?? null;
        } catch (\Exception $e) {
            $attachment = null;
        }

        if ($attachment) {
            $upload = $this->fileUploaderFactory->create(['fileId' => 'attachment']);
            $upload->setAllowRenameFiles(true);
            $upload->setFilesDispersion(true);
            $upload->setAllowCreateFolders(true);
            $upload->setAllowedExtensions(['txt', 'csv', 'jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx']);

            $path = $this->fileSystem
                ->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath(self::FOLDER_LOCATION);
            $result = $upload->save($path);
            $uploaded = self::FOLDER_LOCATION . $upload->getUploadedFilename();
            $filePath = $result['path'] . $result['file'];
            $fileName = $result['name'];
        }


            // send mail to recipients
            $this->_inlineTranslation->suspend();
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->_transportBuilder->setTemplateIdentifier(
                $this->_scopeConfig->getValue(
                    self::EMAIL_TEMPLATE,
                    $storeScope
                )
            )->setTemplateOptions(
                [
                                'area' => Area::AREA_FRONTEND,
                                'store' => $this->_storeManager
                                        ->getStore()
                                        ->getId(),
                            ]
            )->setTemplateVars(['data' => $postObject])
                    ->setFrom($this->_scopeConfig->getValue(
                        self::EMAIL_SENDER,
                        $storeScope
                    ))
                    ->addTo($this->_scopeConfig->getValue(
                        self::XML_PATH_EMAIL_RECIPIENT,
                        $storeScope
                    ))
                    ->getTransport();

                    if ($uploaded && !empty($filePath) && $this->file->fileExists($filePath)) {
            $mimeType = mime_content_type($filePath);

            $transport = $this->_transportBuilder->
setTemplateIdentifier(
                $this->_scopeConfig->getValue(
                    self::EMAIL_TEMPLATE,
                    $storeScope
                )
            )
                ->setTemplateOptions(
                    [
                            'area' => Area::AREA_FRONTEND,
                                'store' => $this->_storeManager
                                        ->getStore()
                                        ->getId(),
                    ]
                )
                ->addAttachment($this->file->read($filePath), $fileName, $mimeType)
              ->setTemplateVars(['data' => $postObject])
                    ->setFrom($this->_scopeConfig->getValue(
                        self::EMAIL_SENDER,
                        $storeScope
                    ))
                    ->addTo($this->_scopeConfig->getValue(
                        self::XML_PATH_EMAIL_RECIPIENT,
                        $storeScope
                    ))
                    ->getTransport();
        }

            $transport->sendMessage();
            $this->_inlineTranslation->resume();

            $this->messageManager->addSuccess(__('Contact Us request has been '
                    . 'received. We\'ll respond to you very soon.'));
            return $resultRedirect->setUrl($redirectUrl);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_inlineTranslation->resume();
            $this->messageManager->addException($e, __('Something went wrong '
                    . 'while sending the contact us request.'));
        }
        return $resultRedirect->setUrl($redirectUrl);
    }

    public function removeScriptTag($original_string, $replace_string = "")
    {
        return preg_replace("/<\s*script.*?>.*?(<\s*\/script.*?>|$)/is", $replace_string, $original_string);
    }


}
