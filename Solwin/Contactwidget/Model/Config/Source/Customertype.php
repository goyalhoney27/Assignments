<?php
namespace Solwin\Contactwidget\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Customertype implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'General',
                'value' => 'general'
            ],
            1 => [
                'label' => 'Wholesale',
                'value' => 'wholesale'
            ],
        ];

        return $options;
    }
}
?>