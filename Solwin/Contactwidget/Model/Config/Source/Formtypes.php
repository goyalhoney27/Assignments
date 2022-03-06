<?php
namespace Solwin\Contactwidget\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Formtypes implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'General Form',
                'value' => 'general'
            ],
            1 => [
                'label' => 'Wholesale Form',
                'value' => 'wholesale form'
            ],
        ];

        return $options;
    }
}
?>