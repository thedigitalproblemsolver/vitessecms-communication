<?php declare(strict_types=1);

namespace VitesseCms\Communication\Blocks;

use Phalcon\Di\Di;
use VitesseCms\Block\AbstractBlockModel;
use VitesseCms\Block\Models\Block;
use VitesseCms\Core\Services\ViewService;
use VitesseCms\Setting\Enum\SettingEnum;
use VitesseCms\Setting\Services\SettingService;

class SocialMediaChannels extends AbstractBlockModel
{
    private readonly SettingService $settingService;

    public function __construct(ViewService $view, Di $di)
    {
        parent::__construct($view, $di);

        $this->settingService = $this->eventsManager->fire(SettingEnum::ATTACH_SERVICE_LISTENER->value,new \stdClass());
    }

    public function getTemplateParams(Block $block): array
    {
        $params = parent::getTemplateParams($block);
        $params['block'] = $block;
        $params['CONTACT_SOCIALMEDIA_LINKEDINURL'] = $this->settingService->getString('CONTACT_SOCIALMEDIA_LINKEDINURL');
        $params['CONTACT_SOCIALMEDIA_FACEBOOKURL'] = $this->settingService->getString('CONTACT_SOCIALMEDIA_FACEBOOKURL');
        $params['CONTACT_SOCIALMEDIA_INSTAGRAMURL'] = $this->settingService->getString('CONTACT_SOCIALMEDIA_INSTAGRAMURL');
        $params['CONTACT_SOCIALMEDIA_TWITTERURL'] = $this->settingService->getString('CONTACT_SOCIALMEDIA_TWITTERURL');
        $params['CONTACT_SOCIALMEDIA_PINTERESTURL'] = $this->settingService->getString('CONTACT_SOCIALMEDIA_PINTERESTURL');
        $params['CONTACT_SOCIALMEDIA_GITHUB'] = $this->settingService->getString('CONTACT_SOCIALMEDIA_GITHUB');

        return $params;
    }
}
