<?php

class Li_Customform_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction () {
        echo get_class($mailTemplate = Mage::getModel('core/email_template'));
        die();
        $this->loadLayout();
        /*block defined in design_layout*/
        $this->getLayout()->getBlock('block_newform')
            ->setFormAction( Mage::getUrl('*/*/post') );
        $this->renderLayout();
    }
    public function secondAction () {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function subscriptionAction () {
        echo 'start';
        $subscription = Mage::getModel('customform/subscription');
        echo get_class($subscription);
        $subscription->setFirstname('John');
        $subscription->setLastname('Doe');
        $subscription->setEmail('john.doe@example.com');
        $subscription->setMessage('A short message to test');

        $subscription->save();

        echo 'success';
    }

    public function postAction () {
        $post = $this->getRequest()->getPost();
        var_dump($post);
        if ($post) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $error = false;

                if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }

                if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                    $error = true;
                }

                if ($error) {
                    throw new Exception();
                }

                var_dump($error);

            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
            }

        } else {
            echo 'oh no!';
        }
    }

    public function collectionAction () {

        $productCollection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('image');

        foreach ($productCollection as $product) {
            Zend_Debug::dump($product->debug());
        }

        echo $productCollection->getSelect()->__toString();

    }

}