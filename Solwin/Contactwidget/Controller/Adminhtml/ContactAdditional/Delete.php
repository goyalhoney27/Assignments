<?php
declare(strict_types=1);

namespace Solwin\Contactwidget\Controller\Adminhtml\ContactAdditional;

class Delete extends \Solwin\Contactwidget\Controller\Adminhtml\ContactAdditional
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('contactadditional_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Solwin\Contactwidget\Model\ContactAdditional::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Contact Form.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['contactadditional_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Contact form to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

