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
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator;
use TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator;
use TYPO3\CMS\Extbase\Validation\Validator\StringLengthValidator;
use TYPO3\CMS\Extbase\Validation\ValidatorResolver;
use TYPO3\CMS\Form\Domain\Configuration\ConfigurationService;
use TYPO3\CMS\Form\Domain\Factory\AbstractFormFactory;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;
use TYPO3\CMS\Form\Domain\Model\FormElements\GenericFormElement;
use TYPO3\CMS\Form\Domain\Model\FormElements\Section;

#[Autoconfigure(public: true)]
class SuggestFormFactory extends AbstractFormFactory
{
    public function __construct(
        protected ConfigurationManagerInterface $configurationManager,
        protected ConfigurationService $formConfigurationService,
        protected ValidatorResolver $validatorResolver,
        protected TagRepository $tagRepository,
        protected SuggestFormFinisher $suggestFormFinisher,
    ) {}

    public function build(
        array $configuration,
        ?string $prototypeName = null,
        ?ServerRequestInterface $request = null
    ): FormDefinition {
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
        /** @var NotEmptyValidator $fullnameValidator */
        $fullnameValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
        $fullnameField->addValidator($fullnameValidator);

        /** @var GenericFormElement $emailField */
        $emailField = $personalInformation->createElement('email', 'Text');
        $emailField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['email']['label']));
        $emailField->setProperty(
            'elementDescription',
            $this->getLocalizedLabel($settings['suggest']['fields']['email']['description'])
        );
        /** @var NotEmptyValidator $emailValidator */
        $emailValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
        $emailField->addValidator($emailValidator);
        /** @var EmailAddressValidator $emailAddressValidator */
        $emailAddressValidator = $this->validatorResolver->createValidator(EmailAddressValidator::class);
        $emailField->addValidator($emailAddressValidator);

        if ((bool)($settings['suggest']['fields']['twitter']['enable'] ?? false) === true) {
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

        if ((bool)($settings['suggest']['fields']['requesttype']['enable'] ?? false) === true) {
            /** @var GenericFormElement $requestTypeField */
            $requestTypeField = $sessionInformation->createElement('requesttype', 'SingleSelect');
            $requestTypeField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['requesttype']['label']));
            $requestTypeField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['requesttype']['description'])
            );
            /** @var NotEmptyValidator $requestTypeValidator */
            $requestTypeValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
            $requestTypeField->addValidator($requestTypeValidator);
            $requestTypeFieldOptions = SessionRequestTypeEnum::getOptions();
            foreach ($requestTypeFieldOptions as $requestTypeFieldOptionKey => $requestTypeFieldOptionValue) {
                $requestTypeFieldOptions[$requestTypeFieldOptionKey] = LocalizationUtility::translate($requestTypeFieldOptionValue);
            }
            $prependOptionLabel = ' ';
            if (($settings['suggest']['fields']['requesttype']['prependOptionLabel'] ?? '') !== '') {
                $prependOptionLabel = $this->getLocalizedLabel($settings['suggest']['fields']['requesttype']['prependOptionLabel']);
            }
            $requestTypeField->setProperty('prependOptionLabel', $prependOptionLabel);
            $requestTypeField->setProperty('options', $requestTypeFieldOptions);
        }

        if ((bool)($settings['suggest']['fields']['type']['enable'] ?? false) === true) {
            /** @var GenericFormElement $typeField */
            $typeField = $sessionInformation->createElement('type', 'SingleSelect');
            $typeField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['type']['label']));
            $typeField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['type']['description'])
            );
            /** @var NotEmptyValidator $typeValidator */
            $typeValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
            $typeField->addValidator($typeValidator);
            $typeFieldOptions = SessionTypeEnum::getOptions();
            foreach ($typeFieldOptions as $typeFieldOptionKey => $typeFieldOptionValue) {
                $typeFieldOptions[$typeFieldOptionKey] = LocalizationUtility::translate($typeFieldOptionValue);
            }
            $prependOptionLabel = ' ';
            if (($settings['suggest']['fields']['type']['prependOptionLabel'] ?? '') !== '') {
                $prependOptionLabel = $this->getLocalizedLabel($settings['suggest']['fields']['type']['prependOptionLabel']);
            }
            $typeField->setProperty('prependOptionLabel', $prependOptionLabel);
            $typeField->setProperty('options', $typeFieldOptions);
        }

        if ((bool)($settings['suggest']['fields']['tag']['enable'] ?? false) === true) {
            $tags = $this->tagRepository->findBy(['suggestFormOption' => true]);
            if ($tags->current() !== false && $tags->current() !== null) {
                /** @var GenericFormElement $tagField */
                $tagField = $sessionInformation->createElement('tag', 'SingleSelect');
                $tagField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['tag']['label']));
                $tagField->setProperty(
                    'elementDescription',
                    $this->getLocalizedLabel($settings['suggest']['fields']['tag']['description'])
                );
                /** @var NotEmptyValidator $tagValidator */
                $tagValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
                $tagField->addValidator($tagValidator);
                $tagFieldOptions = [];
                foreach ($tags as $tag) {
                    $tagFieldOptions[(int)$tag->getUid()] = $tag->getLabel();
                }
                $prependOptionLabel = ' ';
                if (($settings['suggest']['fields']['tag']['prependOptionLabel'] ?? '') !== '') {
                    $prependOptionLabel = $this->getLocalizedLabel($settings['suggest']['fields']['tag']['prependOptionLabel']);
                }
                $tagField->setProperty('prependOptionLabel', $prependOptionLabel);
                $tagField->setProperty('options', $tagFieldOptions);
            }
        }

        /** @var GenericFormElement $titleField */
        $titleField = $sessionInformation->createElement('title', 'Text');
        $titleField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['title']['label']));
        $titleField->setProperty(
            'elementDescription',
            $this->getLocalizedLabel($settings['suggest']['fields']['title']['description'])
        );
        $titleStringLengthValidatorOptions = ['minimum' => $settings['suggest']['fields']['title']['validation']['min'] ?? 1];
        if ($settings['suggest']['fields']['title']['validation']['max'] ?? false) {
            $titleStringLengthValidatorOptions['maximum'] = (int)$settings['suggest']['fields']['title']['validation']['max'];
        }
        /** @var StringLengthValidator $titleStringLengthValidator */
        $titleStringLengthValidator = $this->validatorResolver->createValidator(StringLengthValidator::class, $titleStringLengthValidatorOptions);
        $titleField->addValidator($titleStringLengthValidator);
        if ($titleStringLengthValidatorOptions['minimum'] > 0) {
            /** @var NotEmptyValidator $titleNotEmptyValidator */
            $titleNotEmptyValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
            $titleField->addValidator($titleNotEmptyValidator);
        }

        if ((bool)($settings['suggest']['fields']['subtitle']['enable'] ?? false) === true) {
            /** @var GenericFormElement $subtitleField */
            $subtitleField = $sessionInformation->createElement('subtitle', 'Text');
            $subtitleField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['subtitle']['label']));
            $subtitleField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['subtitle']['description'])
            );
            $subtitleStringLengthValidatorOptions = ['minimum' => $settings['suggest']['fields']['subtitle']['validation']['min'] ?? 1];
            if ($settings['suggest']['fields']['subtitle']['validation']['max'] ?? false) {
                $subtitleStringLengthValidatorOptions['maximum'] = (int)$settings['suggest']['fields']['subtitle']['validation']['max'];
            }
            /** @var StringLengthValidator $subtitleStringLengthValidator */
            $subtitleStringLengthValidator = $this->validatorResolver->createValidator(
                StringLengthValidator::class,
                $subtitleStringLengthValidatorOptions
            );
            $subtitleField->addValidator($subtitleStringLengthValidator);
            if ($subtitleStringLengthValidatorOptions['minimum'] > 0) {
                /** @var NotEmptyValidator $subtitleNotEmptyValidator */
                $subtitleNotEmptyValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
                $subtitleField->addValidator($subtitleNotEmptyValidator);
            }
        }

        /** @var GenericFormElement $descriptionField */
        $descriptionField = $sessionInformation->createElement('description', 'Textarea');
        $descriptionField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['description']['label']));
        $descriptionField->setProperty(
            'elementDescription',
            $this->getLocalizedLabel($settings['suggest']['fields']['description']['description'])
        );
        /** @var NotEmptyValidator $descriptionValidator */
        $descriptionValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
        $descriptionField->addValidator($descriptionValidator);

        /** @var StringLengthValidator $stringLengthValidator */
        $stringLengthValidator = $this->validatorResolver->createValidator(
            StringLengthValidator::class,
            ['minimum' => 5]
        );
        $descriptionField->addValidator($stringLengthValidator);

        if ((bool)($settings['suggest']['fields']['tag_suggestion']['enable'] ?? false) === true) {
            /** @var GenericFormElement $tagSuggestionField */
            $tagSuggestionField = $sessionInformation->createElement('tag_suggestion', 'Text');
            $tagSuggestionField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['tag_suggestion']['label']));
            $tagSuggestionField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['tag_suggestion']['description'])
            );
            $tagSuggestionStringLengthValidatorOptions = ['minimum' => $settings['suggest']['fields']['tag_suggestion']['validation']['min'] ?? 1];
            if ($settings['suggest']['fields']['tag_suggestion']['validation']['max'] ?? false) {
                $tagSuggestionStringLengthValidatorOptions['maximum'] = (int)$settings['suggest']['fields']['tag_suggestion']['validation']['max'];
            }
            /** @var StringLengthValidator $tagSuggestionStringLengthValidator */
            $tagSuggestionStringLengthValidator = $this->validatorResolver->createValidator(
                StringLengthValidator::class,
                $tagSuggestionStringLengthValidatorOptions
            );
            $tagSuggestionField->addValidator($tagSuggestionStringLengthValidator);
            if ($tagSuggestionStringLengthValidatorOptions['minimum'] > 0) {
                /** @var NotEmptyValidator $tagSuggestionNotEmptyValidator */
                $tagSuggestionNotEmptyValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
                $tagSuggestionField->addValidator($tagSuggestionNotEmptyValidator);
            }
        }

        if ((bool)($settings['suggest']['fields']['length']['enable'] ?? false) === true) {
            /** @var GenericFormElement $lengthField */
            $lengthField = $sessionInformation->createElement('estimatedlength', 'SingleSelect');
            $lengthField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['length']['label']));
            $lengthField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['length']['description'])
            );
            $lengthField->setProperty('options', [
                '45 Minutes' => '45 Minutes',
                '90 Minutes' => '90 Minutes',
            ]);
        }

        if ((bool)($settings['suggest']['fields']['level']['enable'] ?? false) === true) {
            /** @var GenericFormElement $levelField */
            $levelField = $sessionInformation->createElement('level', 'SingleSelect');
            $levelField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['level']['label']));
            $levelField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['level']['description'])
            );
            /** @var NotEmptyValidator $levelValidator */
            $levelValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
            $levelField->addValidator($levelValidator);
            $levelFieldOptions = SessionLevelEnum::getOptions();
            foreach ($levelFieldOptions as $levelFieldOptionKey => $levelFieldOptionValue) {
                $levelFieldOptions[$levelFieldOptionKey] = LocalizationUtility::translate($levelFieldOptionValue);
            }
            $prependOptionLabel = ' ';
            if (($settings['suggest']['fields']['level']['prependOptionLabel'] ?? '') !== '') {
                $prependOptionLabel = $this->getLocalizedLabel($settings['suggest']['fields']['level']['prependOptionLabel']);
            }
            $levelField->setProperty('prependOptionLabel', $prependOptionLabel);
            $levelField->setProperty('options', $levelFieldOptions);
        }

        if ((bool)($settings['suggest']['fields']['norecording']['enable'] ?? false) === true) {
            /** @var GenericFormElement $noRecordingField */
            $noRecordingField = $sessionInformation->createElement('norecording', 'Checkbox');
            $noRecordingField->setLabel($this->getLocalizedLabel($settings['suggest']['fields']['norecording']['label']));
            $noRecordingField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['suggest']['fields']['norecording']['description'])
            );
        }

        $explanationText = $page->createElement('headline', 'StaticText');
        if (!$explanationText instanceof GenericFormElement) {
            throw new \RuntimeException(sprintf(
                'Expected instance of GenericFormElement for headline, got %s',
                get_class($explanationText)
            ));
        }
        $explanationText->setProperty(
            'text',
            $this->getLocalizedLabel($settings['suggest']['form']['requiredField'])
            . ' ' . $this->getLocalizedLabel($settings['suggest']['form']['requiredFieldExplanation'])
        );

        $form->addFinisher($this->suggestFormFinisher);

        if ($this->sendingNotificationAllowed($settings)) {
            $form->createFinisher('EmailToReceiver', [
                'subject' => $settings['suggest']['notification']['subject'],
                'recipients' => [
                    $settings['suggest']['notification']['recipientAddress'] => $settings['suggest']['notification']['recipientName'],
                ],
                'senderAddress' => $settings['suggest']['notification']['senderAddress'],
                'senderName' => $settings['suggest']['notification']['senderName'],
                'carbonCopyAddress' => $settings['suggest']['notification']['carbonCopyAddress'] ?? '',
                'blindCarbonCopyAddress' => $settings['suggest']['notification']['blindCarbonCopyAddress'] ?? '',
                'replyToRecipients' => [
                    '{email}' => '{fullname}',
                ],
                'format' => 'html',
            ]);
        }

        $message = $settings['suggest']['confirmation']['message'] ??
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:form.suggest.confirmation';
        $confirmationMessage = LocalizationUtility::translate($message) ?? '';

        if ($this->sendingSenderNotificationAllowed($settings)) {
            $form->createFinisher('EmailToSender', [
                'subject' => $settings['suggest']['senderNotification']['subject'],
                'recipients' => [
                    '{email}' => '{fullname}',
                ],
                'senderAddress' => $settings['suggest']['senderNotification']['senderAddress'],
                'senderName' => $settings['suggest']['senderNotification']['senderName'],
                'format' => 'html',
                'headline' => $settings['suggest']['senderNotification']['subject'],
                'variables' => [
                    'title' => $settings['suggest']['senderNotification']['subject'],
                    'message' => $confirmationMessage,
                ],
                'templateName' => 'EmailToSender',
                'templateRootPaths' => [
                    100 => 'EXT:sessionplaner/Resources/Private/Templates/Email/'
                ],
            ]);
        }

        if (($settings['suggest']['confirmation']['pageUid'] ?? '') !== '') {
            $form->createFinisher('Redirect', [
                'pageUid' => (int)$settings['suggest']['confirmation']['pageUid'],
            ]);
        } else {
            $form->createFinisher('Confirmation', [
                'message' => $confirmationMessage,
            ]);
        }

        $this->triggerFormBuildingFinished($form);
        return $form;
    }

    protected function sendingNotificationAllowed(array $settings): bool
    {
        return isset(
            $settings['suggest']['notification']['enable'],
            $settings['suggest']['notification']['subject'],
            $settings['suggest']['notification']['recipientAddress'],
            $settings['suggest']['notification']['recipientName'],
            $settings['suggest']['notification']['senderAddress'],
            $settings['suggest']['notification']['senderName']
        )
            && (bool)$settings['suggest']['notification']['enable'] === true
            && $settings['suggest']['notification']['subject'] !== ''
            && $settings['suggest']['notification']['recipientAddress'] !== ''
            && $settings['suggest']['notification']['recipientName'] !== ''
            && $settings['suggest']['notification']['senderAddress'] !== ''
            && $settings['suggest']['notification']['senderName'] !== '';
    }

    protected function sendingSenderNotificationAllowed(array $settings): bool
    {
        return isset(
                $settings['suggest']['senderNotification']['enable'],
                $settings['suggest']['senderNotification']['subject'],
                $settings['suggest']['senderNotification']['senderAddress'],
                $settings['suggest']['senderNotification']['senderName']
            )
            && (bool)$settings['suggest']['senderNotification']['enable'] === true
            && $settings['suggest']['senderNotification']['subject'] !== ''
            && $settings['suggest']['senderNotification']['senderAddress'] !== ''
            && $settings['suggest']['senderNotification']['senderName'] !== '';
    }

    protected function getLocalizedLabel(string $label): string
    {
        if (strncmp($label, 'LLL:', 4) === 0) {
            return LocalizationUtility::translate($label) ?? '';
        }
        return $label;
    }
}
