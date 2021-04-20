<?php declare(strict_types=1);

namespace VitesseCms\Communication\Helpers;

use DateTime;
use VitesseCms\Communication\Factories\NewsletterListMemberFactory;
use VitesseCms\Communication\Models\Newsletter;
use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Communication\Repositories\RepositoryCollection;
use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;

class NewsletterHelper
{
    public static function addMemberByEmail(Newsletter $newsletter, string $email): void
    {
        $newsletterList = NewsletterList::findById($newsletter->_('list'));
        if ($newsletterList) :
            $newsletterList->addMember($email);
            $newsletterList->save();
            if ($newsletter->_('sendAfterSubscribtion')) {
                self::queueMembers(
                    $newsletter,
                    NewsletterListMemberFactory::create($email, new DateTime(), $newsletterList)
                );
            }
        endif;
    }

    public static function queueMembers(
        Newsletter $newsletter,
        RepositoryCollection $repositories,
        array $member = null
    ): void
    {
        if (!$newsletter->hasChildren) :
            NewsletterQueueHelper::addToQueue($newsletter, null, $member);
        else :
            $childNewsletters = $repositories->newsletter->findAll(
                new FindValueIterator([new FindValue('parentId', (string)$newsletter->getId())])
            );

            $referenceTime = new DateTime();
            while ($childNewsletters->valid()) :
                $childNewsletter = $childNewsletters->current();
                if ($childNewsletter->getDays() !== null) :
                    $referenceTime->modify('+' . $childNewsletter->getDays() . ' days');
                endif;
                if ($childNewsletter->getSendTime() !== null) :
                    $timeArray = explode(':', $childNewsletter->getSendTime());
                    $referenceTime->setTime($timeArray[0], $timeArray[1], 0);
                endif;
                NewsletterQueueHelper::addToQueue($childNewsletter, $referenceTime, $member);
                $childNewsletters->next();
            endwhile;
        endif;
    }

    public static function unsubscribeMemberByEmail(Newsletter $newsletter, string $email)
    {
        $newsletterList = NewsletterList::findById($newsletter->_('list'));
        if ($newsletterList) :
            $newsletterList->unsubscribeMember($email);
            $newsletterList->save();
        endif;
    }

    public static function removeMemberByEmail(Newsletter $newsletter, string $email)
    {
        $newsletterList = NewsletterList::findById($newsletter->_('list'));
        if ($newsletterList) :
            $newsletterList->removeMember($email);
            $newsletterList->save();
        endif;
    }
}
