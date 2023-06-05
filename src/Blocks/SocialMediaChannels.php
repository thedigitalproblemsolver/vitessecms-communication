<?php declare(strict_types=1);

namespace VitesseCms\Communication\Blocks;

use VitesseCms\Block\AbstractBlockModel;
use VitesseCms\Block\Models\Block;
use VitesseCms\Setting\Enum\SettingEnum;

class SocialMediaChannels extends AbstractBlockModel
{
    public function getTemplateParams(Block $block): array
    {
        $settingService = $this->eventsManager->fire(SettingEnum::ATTACH_SERVICE_LISTENER->value,new \stdClass());
        $params = parent::getTemplateParams($block);
        $params['block'] = $block;
        $params['CONTACT_SOCIALMEDIA_LINKEDINURL'] = $settingService->getString('CONTACT_SOCIALMEDIA_LINKEDINURL');
        $params['CONTACT_SOCIALMEDIA_FACEBOOKURL'] = $settingService->getString('CONTACT_SOCIALMEDIA_FACEBOOKURL');
        $params['CONTACT_SOCIALMEDIA_INSTAGRAMURL'] = $settingService->getString('CONTACT_SOCIALMEDIA_INSTAGRAMURL');
        $params['CONTACT_SOCIALMEDIA_TWITTERURL'] = $settingService->getString('CONTACT_SOCIALMEDIA_TWITTERURL');
        $params['CONTACT_SOCIALMEDIA_PINTERESTURL'] = $settingService->getString('CONTACT_SOCIALMEDIA_PINTERESTURL');

        return $params;
    }
}
