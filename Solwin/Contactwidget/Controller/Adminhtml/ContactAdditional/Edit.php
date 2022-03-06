<?php

declare(strict_types=1);

namespace Solwin\Contactwidget\Controller\Adminhtml\ContactAdditional;

class Edit extends \Solwin\Contactwidget\Controller\Adminhtml\ContactAdditional
{

    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('contactadditional_id');
        $model = $this->_objectManager->create(\Solwin\Contactwidget\Model\ContactAdditional::class);
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Contact form no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('solwin_contactwidget_contactadditional', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Contact form') : __('New Contact form'),
            $id ? __('Edit Contact form') : __('New Contact form')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Contactadditionals'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Contactadditional %1', $model->getId()) : __('New Contactadditional'));
        return $resultPage;
    }
}

