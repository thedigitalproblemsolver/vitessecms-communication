<?php declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use VitesseCms\Communication\Forms\NewsletterTemplateForm;
use VitesseCms\Communication\Models\NewsletterTemplate;
use VitesseCms\Admin\AbstractAdminController;

class AdminnewslettertemplateController extends AbstractAdminController
{
    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = NewsletterTemplate::class;
        $this->classForm = NewsletterTemplateForm::class;
    }
}
