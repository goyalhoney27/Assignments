<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Controller\Adminhtml\ContactAdditional;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $_storeManager;

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
         $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('contactadditional_id');
        
            $model = $this->_objectManager->create(\Solwin\Contactwidget\Model\ContactAdditional::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This form no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Contact form.'));
                $this->dataPersistor->clear('solwin_contactwidget_contactadditional');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['contactadditional_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the data.'));
            }
        
            $this->dataPersistor->set('solwin_contactwidget_contactadditional', $data);
            return $resultRedirect->setPath('*/*/edit', ['contactadditional_id' => $this->getRequest()->getParam('contactadditional_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

