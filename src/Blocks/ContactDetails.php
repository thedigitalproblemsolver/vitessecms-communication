<?php
declare(strict_types=1);

namespace VitesseCms\Communication\Blocks;

use Phalcon\Di\Di;
use stdClass;
use VitesseCms\Block\AbstractBlockModel;
use VitesseCms\Block\Models\Block;
use VitesseCms\Core\Services\ViewService;
use VitesseCms\Setting\Enum\SettingEnum;
use VitesseCms\Setting\Services\SettingService;

class ContactDetails extends AbstractBlockModel
{
    private readonly SettingService $settingService;

    public function __construct(ViewService $view, Di $di)
    {
        parent::__construct($view, $di);

        $this->settingService = $this->eventsManager->fire(SettingEnum::ATTACH_SERVICE_LISTENER->value, new stdClass());
    }

    public function getTemplateParams(Block $block): array
    {
        $params = parent::getTemplateParams($block);
        $params['CONTACT_ADDRESS_COMPANYNAME'] = $this->settingService->getString('CONTACT_ADDRESS_COMPANYNAME');
        $params['CONTACT_ADDRESS_STREET'] = $this->settingService->getString('CONTACT_ADDRESS_STREET');
        $params['CONTACT_ADDRESS_HOUSENUMBER'] = $this->settingService->getString('CONTACT_ADDRESS_HOUSENUMBER');
        $params['CONTACT_ADDRESS_ZIPCODE'] = $this->settingService->getString('CONTACT_ADDRESS_ZIPCODE');
        $params['CONTACT_ADDRESS_CITY'] = $this->settingService->getString('CONTACT_ADDRESS_CITY');
        $params['CONTACT_ADDRESS_COUNTRY'] = $this->settingService->getString('CONTACT_ADDRESS_COUNTRY');
        $params['CONTACT_ADDRESS_PHONENUMBER'] = $this->settingService->getString('CONTACT_ADDRESS_PHONENUMBER');
        $params['CONTACT_ADDRESS_EMAIL'] = $this->settingService->getString('CONTACT_ADDRESS_EMAIL');
        $params['CONTACT_VAT_NUMBER'] = $this->settingService->getString('CONTACT_VAT_NUMBER');
        $params['CONTACT_CHAMBER-OF-COMMERCE_NUMBER'] = $this->settingService->getString(
            'CONTACT_CHAMBER-OF-COMMERCE_NUMBER'
        );
        $params['CONTACT_PAYMENT_IBAN'] = $this->settingService->getString('CONTACT_PAYMENT_IBAN');
        $params['CONTACT_PAYMENT_BIC'] = $this->settingService->getString('CONTACT_PAYMENT_BIC');

        return $params;
    }
}