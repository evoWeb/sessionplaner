<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Factory;

use Evoweb\Sessionplaner\Domain\Finisher\SuggestFormFinisher;
use Evoweb\Sessionplaner\Domain\Repository\TagRepository;
use Evoweb\Sessionplaner\Enum\SessionLevelEnum;
use Evoweb\Sessionplaner\Enum\SessionRequestTypeEnum;
use Evoweb\Sessionplaner\Enum\SessionTypeEnum;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator;
use TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator;
use TYPO3\CMS\Extbase\Validation\Validator\StringLengthValidator;
use TYPO3\CMS\Form\Domain\Configuration\ConfigurationService;
use TYPO3\CMS\Form\Domain\Factory\AbstractFormFactory;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;
use TYPO3\CMS\Form\Domain\Model\FormElements\GenericFormElement;
use TYPO3\CMS\Form\Domain\Model\FormElements\Section;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class SuggestFormFactory extends AbstractFormFactory
{
    protected ConfigurationService $formConfigurationService;

    protected ConfigurationManagerInterface $configurationManager;

    protected TagRepository $tagRepository;

    public function __construct(
        ConfigurationManagerInterface $configurationManager,
        ConfigurationService $formConfigurationService,
        TagRepository $tagRepository
    ) {
        $this->configurationManager = $configurationManager;
        $this->formConfigurationService = $formConfigurationService;
        $this->tagRepository = $tagRepository;
    }

    public function build(array $configuration, string $prototypeName = null): FormDefinition
    {
        $prototypeName = 'standard';

        $prototypeConfiguration = $this->formConfigurationService->getPrototypeConfiguration($prototypeName);

        $settings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'sessionplaner'
        );

        /** @var FormDefinition $form */
        $form = GeneralUtility::makeInstance(FormDefinition::class, 'suggest', $prototypeConfiguration);
        $form->setRenderingOption('controllerAction', 'form');
        $form->setRenderingOption('submitButtonLabel', $this->getLocalizedLabel($settings['suggest']['form']['submitButtonLabel']));
        $page = $form->createPage('suggestform');

        // Personal Information
        /** @var Section $personalInformation */
        $personalInformation = $page->createElement('personalinformation', 'Fieldset');
        $personalInformation->setLabel($this->getLocalizedLabel($settings['suggest']['form']['personalinformation']));

        /** @var GenericFormElement $fullnameField */
        $fullnameField = $personalInformation->createElement('fullname', 'Text');
        $fullnameField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['fullname']['label']));
        $fullnameField->setProperty(
            'elementDescription',
            $this->getLocalizedLabel($settings['suggest']['fields']['fullname']['description'])
        );
        $fullnameField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));

        /** @var GenericFormElement $emailField */
        $emailField = $personalInformation->createElement('email', 'Text');
        $emailField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['email']['label']));
        $emailField->setProperty(
            'elementDescription',
            $this->getLocalizedLabel($settings['suggest']['fields']['email']['description'])
        );
        $emailField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));
        $emailField->addValidator(GeneralUtility::makeInstance(EmailAddressValidator::class));

        if ($settings['suggest']['fields']['twitter']['enable']) {
            /** @var GenericFormElement $twitterField */
            $twitterField = $personalInformation->createElement('twitter', 'Text');
            $twitterField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['twitter']['label']));
            $twitterField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['twitter']['description'])
            );
        }

        // Session Information
        /** @var Section $sessionInformation */
        $sessionInformation = $page->createElement('sessioninformation', 'Fieldset');
        $sessionInformation->setLabel($this->getLocalizedLabel($settings['suggest']['form']['sessioninformation']));

        if ($settings['suggest']['fields']['requesttype']['enable']) {
            /** @var GenericFormElement $requesttypeField */
            $requesttypeField = $sessionInformation->createElement('requesttype', 'SingleSelect');
            $requesttypeField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['requesttype']['label']));
            $requesttypeField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['requesttype']['description'])
            );
            $requesttypeField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));
            $requesttypeFieldOptions = SessionRequestTypeEnum::getOptions();
            foreach ($requesttypeFieldOptions as $requesttypeFieldOptionKey => $requesttypeFieldOptionValue) {
                $requesttypeFieldOptions[$requesttypeFieldOptionKey] = LocalizationUtility::translate($requesttypeFieldOptionValue);
            }
            $prependOptionLabel = ' ';
            if (!empty($settings['suggest']['fields']['requesttype']['prependOptionLabel'])) {
                $prependOptionLabel = $this->getLocalizedLabel($settings['suggest']['fields']['requesttype']['prependOptionLabel']);
            }
            $requesttypeField->setProperty('prependOptionLabel', $prependOptionLabel);
            $requesttypeField->setProperty('options', $requesttypeFieldOptions);
        }

        if ($settings['suggest']['fields']['type']['enable']) {
            /** @var GenericFormElement $typeField */
            $typeField = $sessionInformation->createElement('type', 'SingleSelect');
            $typeField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['type']['label']));
            $typeField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['type']['description'])
            );
            $typeField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));
            $typeFieldOptions = SessionTypeEnum::getOptions();
            foreach ($typeFieldOptions as $typeFieldOptionKey => $typeFieldOptionValue) {
                $typeFieldOptions[$typeFieldOptionKey] = LocalizationUtility::translate($typeFieldOptionValue);
            }
            $prependOptionLabel = ' ';
            if (!empty($settings['suggest']['fields']['type']['prependOptionLabel'])) {
                $prependOptionLabel = $this->getLocalizedLabel($settings['suggest']['fields']['type']['prependOptionLabel']);
            }
            $typeField->setProperty('prependOptionLabel', $prependOptionLabel);
            $typeField->setProperty('options', $typeFieldOptions);
        }

        $tags = $this->tagRepository->findBy(['suggestFormOption' => true]);
        if ($settings['suggest']['fields']['tag']['enable'] && $tags->current()) {
            /** @var GenericFormElement $tagField */
            $tagField = $sessionInformation->createElement('tag', 'SingleSelect');
            $tagField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['tag']['label']));
            $tagField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['tag']['description'])
            );
            $tagField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));
            $tagFieldOptions = [];
            foreach ($tags as $tag) {
                $tagFieldOptions[$tag->getUid()] = $tag->getLabel();
            }
            $prependOptionLabel = ' ';
            if (!empty($settings['suggest']['fields']['tag']['prependOptionLabel'])) {
                $prependOptionLabel = $this->getLocalizedLabel($settings['suggest']['fields']['tag']['prependOptionLabel']);
            }
            $tagField->setProperty('prependOptionLabel', $prependOptionLabel);
            $tagField->setProperty('options', $tagFieldOptions);
        }

        /** @var GenericFormElement $titleField */
        $titleField = $sessionInformation->createElement('title', 'Text');
        $titleField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['title']['label']));
        $titleField->setProperty(
            'elementDescription',
            $this->getLocalizedLabel($settings['suggest']['fields']['title']['description'])
        );
        $titleField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));

        /** @var GenericFormElement $descriptionField */
        $descriptionField = $sessionInformation->createElement('description', 'Textarea');
        $descriptionField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['description']['label']));
        $descriptionField->setProperty(
            'elementDescription',
            $this->getLocalizedLabel($settings['suggest']['fields']['description']['description'])
        );
        $descriptionField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));

        if ((GeneralUtility::makeInstance(Typo3Version::class))->getMajorVersion() < 12) {
            $stringLengthValidator = GeneralUtility::makeInstance(StringLengthValidator::class, ['minimum' => 5]);
        } else {
            $stringLengthValidator = GeneralUtility::makeInstance(StringLengthValidator::class);
            $stringLengthValidator->setOptions(['minimum' => 5]);
        }
        $descriptionField->addValidator($stringLengthValidator);

        if ($settings['suggest']['fields']['length']['enable']) {
            /** @var GenericFormElement $lengthField */
            $lengthField = $sessionInformation->createElement('estimatedlength', 'SingleSelect');
            $lengthField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['length']['label']));
            $lengthField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['length']['description'])
            );
            $lengthField->setProperty('options', [
                '45 Minutes' => '45 Minutes',
                '90 Minutes' => '90 Minutes'
            ]);
        }

        if ($settings['suggest']['fields']['level']['enable']) {
            /** @var GenericFormElement $levelField */
            $levelField = $sessionInformation->createElement('level', 'SingleSelect');
            $levelField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['level']['label']));
            $levelField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['level']['description'])
            );
            $levelField->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));
            $levelFieldOptions = SessionLevelEnum::getOptions();
            foreach ($levelFieldOptions as $levelFieldOptionKey => $levelFieldOptionValue) {
                $levelFieldOptions[$levelFieldOptionKey] = LocalizationUtility::translate($levelFieldOptionValue);
            }
            $prependOptionLabel = ' ';
            if (!empty($settings['suggest']['fields']['level']['prependOptionLabel'])) {
                $prependOptionLabel = $this->getLocalizedLabel($settings['suggest']['fields']['level']['prependOptionLabel']);
            }
            $levelField->setProperty('prependOptionLabel', $prependOptionLabel);
            $levelField->setProperty('options', $levelFieldOptions);
        }

        if ($settings['suggest']['fields']['norecording']['enable']) {
            $noRecordingField = $sessionInformation->createElement('norecording', 'Checkbox');
            $noRecordingField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['norecording']['label']));
            $noRecordingField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['norecording']['description'])
            );
        }

        $explanationText = $page->createElement('headline', 'StaticText');
        $explanationText->setProperty(
            'text',
            $this->getLocalizedLabel($settings['suggest']['form']['requiredField'])
            . ' ' . $this->getLocalizedLabel($settings['suggest']['form']['requiredFieldExplanation'])
        );

        /** @var SuggestFormFinisher $commentFinisher */
        $commentFinisher = GeneralUtility::makeInstance(SuggestFormFinisher::class);
        $form->addFinisher($commentFinisher);

        if (
            $settings['suggest']['notification']['enable'] &&
            !empty($settings['suggest']['notification']['subject']) &&
            !empty($settings['suggest']['notification']['recipientAddress']) &&
            !empty($settings['suggest']['notification']['recipientName']) &&
            !empty($settings['suggest']['notification']['senderAddress']) &&
            !empty($settings['suggest']['notification']['senderName'])
        ) {
            $form->createFinisher('EmailToReceiver', [
                'subject' => $settings['suggest']['notification']['subject'] ?? '',
                'recipients' => $settings['suggest']['notification']['recipientAddress']
                    ? [
                        $settings['suggest']['notification']['recipientAddress'] => $settings['suggest']['notification']['recipientName'],
                    ]
                    : [],
                'senderAddress' => $settings['suggest']['notification']['senderAddress'] ?? '',
                'senderName' => $settings['suggest']['notification']['senderName'] ?? '',
                'carbonCopyAddress' => $settings['suggest']['notification']['carbonCopyAddress'] ?? '',
                'blindCarbonCopyAddress' => $settings['suggest']['notification']['blindCarbonCopyAddress'] ?? '',
                'replyToRecipients' => [
                    '{email}'=> '{fullname}',
                ],
                'format' => 'html'
            ]);
        }

        if ($settings['suggest']['confirmation']['pageUid']) {
            $form->createFinisher('Redirect', [
                'pageUid' => (int)$settings['suggest']['confirmation']['pageUid'],
            ]);
        } else {
            $message = $settings['suggest']['confirmation']['message'] ??
                'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:form.suggest.confirmation';
            $form->createFinisher('Confirmation', [
                'message' => LocalizationUtility::translate($message),
            ]);
        }

        $this->triggerFormBuildingFinished($form);
        return $form;
    }

    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }

    protected function getLocalizedLabel(string $label): string
    {
        if (strncmp($label, 'LLL:', 4) === 0) {
            $label = LocalizationUtility::translate($label);
        }
        return $label;
    }
}
