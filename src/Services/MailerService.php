<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Services;

use Phalcon\Incubator\Mailer\Manager;
use Phalcon\Incubator\Mailer\Message;
use VitesseCms\Communication\External\Html2text;
use VitesseCms\Content\Services\ContentService;
use VitesseCms\Core\Services\ViewService;
use VitesseCms\Core\Utils\FileUtil;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Sef\Utils\UtmUtil;
use VitesseCms\Setting\Services\SettingService;

final class MailerService
{
    private readonly Manager $mailManager;

    public function __construct(
        private readonly SettingService $setting,
        private readonly ContentService $content,
        private readonly ViewService $view,
        private readonly \Phalcon\Events\Manager $eventsManager
    ) {
        $this->mailManager = new Manager([
            'driver' => 'sendmail',
            'from' => [
                'email' => $setting->getString('WEBSITE_CONTACT_EMAIL'),
                'name' => $setting->getString('WEBSITE_DEFAULT_NAME'),
            ],
        ]);
    }

    public function sendMail(
        string $toAddress,
        string $subject,
        string $body,
        string $emailType = '',
        string $replyTo = ''
    ): bool {
        return (bool)$this->prepareMail(
            $toAddress,
            $subject,
            $body,
            $emailType,
            $replyTo
        )->send();
    }

    public function prepareMail(
        string $toAddress,
        string $subject,
        string $body,
        string $emailType = '',
        string $replyTo = ''
    ): Message {
        $parsedBody = $this->parseBody($body, $emailType);

        $mailMessage = $this->mailManager->createMessage()
            ->to($toAddress)
            ->subject($this->prepareString($subject))
            ->content($parsedBody)
            ->contentAlternative((new Html2text($parsedBody))->get_text(), Message::CONTENT_TYPE_PLAIN);
        if ($this->setting->has('WEBSITE_CATCHALL_EMAIL')) :
            $mailMessage->bcc($this->setting->get('WEBSITE_CATCHALL_EMAIL'));
        endif;

        if ($replyTo) :
            $mailMessage->replyTo($replyTo);
        endif;

        $this->embedImages($mailMessage);

        return $mailMessage;
    }

    protected function parseBody(string $body, string $emailType = ''): string
    {
        $template = 'default';

        if (!empty($emailType)) {
            $tmp = explode('/', $emailType);
            $tmp = array_reverse($tmp);
            $template = $tmp[0];
        }

        return UtmUtil::append(
            $this->content->parseContent(
                $this->eventsManager->fire(
                    ViewEnum::RENDER_TEMPLATE_EVENT,
                    new RenderTemplateDTO(
                        'emails/' . $template,
                        '',
                        ['sendMailBody' => $this->prepareString($body)],
                        true
                    )
                )
            )
        );
    }

    protected function prepareString(string $content): string
    {
        preg_match_all('/{{([a-zA-Z_]*)}}/', $content, $aMatches);
        if (is_array($aMatches) && isset($aMatches[1]) && is_array($aMatches[1])) {
            foreach ($aMatches[1] as $key => $value) {
                $content = str_replace(
                    ['https://{{' . $value . '}}', 'https://{{' . $value . '}}', '{{' . $value . '}}'],
                    ['{{' . $value . '}}', '{{' . $value . '}}', $this->view->getVar($value)],
                    $content
                );
            }
        }

        return $content;
    }

    protected function embedImages(Message $message): void
    {
        $content = $message->getContent();
        $search = $replace = [];

        preg_match_all('@src="([^"]+)"@', $content, $imageUrls);
        if (is_array($imageUrls) && isset($imageUrls[1]) && is_array($imageUrls[1])) {
            foreach ($imageUrls[1] as $imageUrl) {
                $localFile = FileUtil::urlToLocalMapper($imageUrl);
                if (is_file($localFile)) {
                    $cid = $message->embed($localFile);
                    $search[] = $imageUrl;
                    $replace[] = $cid;
                }
            }

            $message->content(str_replace($search, $replace, $content));
        }
    }
}
