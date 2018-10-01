<?php

namespace Omnipay\Paynl\Common;


class Item extends \Omnipay\Common\Item
{
    const PRODUCT_TYPE_ARTICLE = 'ARTICLE';
    const PRODUCT_TYPE_SHIPPING = 'SHIPPING';
    const PRODUCT_TYPE_HANDLING = 'HANDLING';
    const PRODUCT_TYPE_DISCOUNT = 'DISCOUNT';

    /**
     * @return string
     */
    public function getProductId()
    {
        return $this->getParameter('productId');
    }

    /**
     * @param $productId string
     *
     * @return $this
     */
    public function setProductId($productId)
    {
        return $this->setParameter('productId', $productId);
    }

    /**
     * @return string
     */
    public function getProductType()
    {
        return $this->getParameter('productType');
    }

    /**
     * @param $productType string
     *
     * @return $this
     */
    public function setProductType($productType)
    {
        return $this->setParameter('productType', $productType);
    }

    /**
     * @return float
     */
    public function getVatPercentage()
    {
        return $this->getParameter('vatPercentage');
    }

    /**
     * @param $vatPercentage float
     *
     * @return $this
     */
    public function setVatPercentage($vatPercentage)
    {
        return $this->setParameter('vatPercentage', $vatPercentage);
    }
}