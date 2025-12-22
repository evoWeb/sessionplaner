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
use TYPO3\CMS\Form\Domain\Exception\TypeDefinitionNotFoundException;
use TYPO3\CMS\Form\Domain\Exception\TypeDefinitionNotValidException;
use TYPO3\CMS\Form\Domain\Factory\AbstractFormFactory;
use TYPO3\CMS\Form\Domain\Model\Exception\FinisherPresetNotFoundException;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;
use TYPO3\CMS\Form\Domain\Model\FormElements\GenericFormElement;
use TYPO3\CMS\Form\Domain\Model\FormElements\Page;
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
        $form = GeneralUtility::makeInstance(
            FormDefinition::class,
            'suggest',
            $prototypeConfiguration
        );
        $form->setRenderingOption('controllerAction', 'form');
        $form->setRenderingOption('submitButtonLabel', $this->getLocalizedLabel($settings['suggest']['form']['submitButtonLabel']));

        $page = $form->createPage('suggestform');

        // Personal Information
        /** @var Section $personalInformation */
        $personalInformation = $page->createElement('personalinformation', 'Fieldset');
        $personalInformation->setLabel($this->getLocalizedLabel($settings['suggest']['form']['personalinformation']));

        $this->addFullnameField($personalInformation, $settings['suggest']['fields']['fullname'] ?? []);
        $this->addEmailField($personalInformation, $settings['suggest']['fields']['email'] ?? []);
        $this->addTwitterField($personalInformation, $settings['suggest']['fields']['twitter'] ?? []);

        // Session Information
        /** @var Section $sessionInformation */
        $sessionInformation = $page->createElement('sessioninformation', 'Fieldset');
        $sessionInformation->setLabel($this->getLocalizedLabel($settings['suggest']['form']['sessioninformation']));

        $this->addRequesttypeField($sessionInformation, $settings['suggest']['fields']['requesttype'] ?? []);
        $this->addTypeField($sessionInformation, $settings['suggest']['fields']['type'] ?? []);
        $this->addTagField($sessionInformation, $settings['suggest']['fields']['tag'] ?? []);
        $this->addTitleField($sessionInformation, $settings['suggest']['fields']['title'] ?? []);
        $this->addDescriptionField($sessionInformation, $settings['suggest']['fields']['description'] ?? []);
        $this->addLengthField($sessionInformation, $settings['suggest']['fields']['length'] ?? []);
        $this->addLevelField($sessionInformation, $settings['suggest']['fields']['level'] ?? []);
        $this->addNorecordingField($sessionInformation, $settings['suggest']['fields']['norecording'] ?? []);

        $this->addExplanationText($page, $settings['suggest']['form'] ?? []);

        $this->addFinishers($form, $settings);

        $this->triggerFormBuildingFinished($form);
        return $form;
    }

    protected function sendingNotificationAllowed(array $settings): bool
    {
        return (bool)($settings['suggest']['notification']['enable'] ?? false) === true
            && ($settings['suggest']['notification']['subject'] ?? '') !== ''
            && ($settings['suggest']['notification']['recipientAddress'] ?? '') !== ''
            && ($settings['suggest']['notification']['recipientName'] ?? '') !== ''
            && ($settings['suggest']['notification']['senderAddress'] ?? '') !== ''
            && ($settings['suggest']['notification']['senderName'] ?? '') !== '';
    }

    protected function getLocalizedLabel(string $label): string
    {
        if (strncmp($label, 'LLL:', 4) === 0) {
            return LocalizationUtility::translate($label) ?? '';
        }
        return $label;
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addFullnameField(Section $section, array $settings): void
    {
        /** @var GenericFormElement $fullnameField */
        $fullnameField = $section->createElement('fullname', 'Text');
        $fullnameField->setLabel($this->getLocalizedLabel($settings['label']));
        $fullnameField->setProperty('elementDescription', $this->getLocalizedLabel($settings['description']));
        /** @var NotEmptyValidator $fullnameValidator */
        $fullnameValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
        $fullnameField->addValidator($fullnameValidator);
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addEmailField(Section $section, array $settings): void
    {
        /** @var GenericFormElement $emailField */
        $emailField = $section->createElement('email', 'Text');
        $emailField->setLabel($this->getLocalizedLabel($settings['label']));
        $emailField->setProperty('elementDescription', $this->getLocalizedLabel($settings['description']));
        /** @var NotEmptyValidator $emailValidator */
        $emailValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
        $emailField->addValidator($emailValidator);
        /** @var EmailAddressValidator $emailAddressValidator */
        $emailAddressValidator = $this->validatorResolver->createValidator(EmailAddressValidator::class);
        $emailField->addValidator($emailAddressValidator);
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addTwitterField(Section $section, array $settings): void
    {
        if ((bool)($settings['enable'] ?? false) === true) {
            /** @var GenericFormElement $twitterField */
            $twitterField = $section->createElement('twitter', 'Text');
            $twitterField->setLabel($this->getLocalizedLabel($settings['label']));
            $twitterField->setProperty('elementDescription', $this->getLocalizedLabel($settings['description']));
        }
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addRequesttypeField(Section $section, array $settings): void
    {
        if ((bool)($settings['enable'] ?? false) === true) {
            /** @var GenericFormElement $requestTypeField */
            $requestTypeField = $section->createElement('requesttype', 'SingleSelect');
            $requestTypeField->setLabel($this->getLocalizedLabel($settings['label']));
            $requestTypeField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['description'])
            );
            /** @var NotEmptyValidator $requestTypeValidator */
            $requestTypeValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
            $requestTypeField->addValidator($requestTypeValidator);
            $requestTypeFieldOptions = SessionRequestTypeEnum::getOptions();
            foreach ($requestTypeFieldOptions as $requestTypeFieldOptionKey => $requestTypeFieldOptionValue) {
                $requestTypeFieldOptions[$requestTypeFieldOptionKey] = LocalizationUtility::translate($requestTypeFieldOptionValue);
            }
            $prependOptionLabel = ' ';
            if (($settings['prependOptionLabel'] ?? '') !== '') {
                $prependOptionLabel = $this->getLocalizedLabel($settings['prependOptionLabel']);
            }
            $requestTypeField->setProperty('prependOptionLabel', $prependOptionLabel);
            $requestTypeField->setProperty('options', $requestTypeFieldOptions);
        }
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addTypeField(Section $section, array $settings): void
    {
        if ((bool)($settings['enable'] ?? false) === true) {
            /** @var GenericFormElement $typeField */
            $typeField = $section->createElement('type', 'SingleSelect');
            $typeField->setLabel($this->getLocalizedLabel($settings['label']));
            $typeField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['description'])
            );
            /** @var NotEmptyValidator $typeValidator */
            $typeValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
            $typeField->addValidator($typeValidator);
            $typeFieldOptions = SessionTypeEnum::getOptions();
            foreach ($typeFieldOptions as $typeFieldOptionKey => $typeFieldOptionValue) {
                $typeFieldOptions[$typeFieldOptionKey] = LocalizationUtility::translate($typeFieldOptionValue);
            }
            $prependOptionLabel = ' ';
            if (($settings['prependOptionLabel'] ?? '') !== '') {
                $prependOptionLabel = $this->getLocalizedLabel($settings['prependOptionLabel']);
            }
            $typeField->setProperty('prependOptionLabel', $prependOptionLabel);
            $typeField->setProperty('options', $typeFieldOptions);
        }
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addTagField(Section $section, array $settings): void
    {
        if ((bool)($settings['enable'] ?? false) === true) {
            $tags = $this->tagRepository->findBy(['suggestFormOption' => true]);
            if ($tags->current() !== false && $tags->current() !== null) {
                /** @var GenericFormElement $tagField */
                $tagField = $section->createElement('tag', 'SingleSelect');
                $tagField->setLabel($this->getLocalizedLabel($settings['label']));
                $tagField->setProperty(
                    'elementDescription',
                    $this->getLocalizedLabel($settings['description'])
                );
                /** @var NotEmptyValidator $tagValidator */
                $tagValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
                $tagField->addValidator($tagValidator);
                $tagFieldOptions = [];
                foreach ($tags as $tag) {
                    $tagFieldOptions[(int)$tag->getUid()] = $tag->getLabel();
                }
                $prependOptionLabel = ' ';
                if (($settings['prependOptionLabel'] ?? '') !== '') {
                    $prependOptionLabel = $this->getLocalizedLabel($settings['prependOptionLabel']);
                }
                $tagField->setProperty('prependOptionLabel', $prependOptionLabel);
                $tagField->setProperty('options', $tagFieldOptions);
            }
        }
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addTitleField(Section $section, array $settings): void
    {
        /** @var GenericFormElement $titleField */
        $titleField = $section->createElement('title', 'Text');
        $titleField->setLabel($this->getLocalizedLabel($settings['label']));
        $titleField->setProperty('elementDescription', $this->getLocalizedLabel($settings['description']));
        /** @var NotEmptyValidator $titleValidator */
        $titleValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
        $titleField->addValidator($titleValidator);
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addDescriptionField(Section $section, array $settings): void
    {
        /** @var GenericFormElement $descriptionField */
        $descriptionField = $section->createElement('description', 'Textarea');
        $descriptionField->setLabel($this->getLocalizedLabel($settings['label']));
        $descriptionField->setProperty('elementDescription', $this->getLocalizedLabel($settings['description']));
        /** @var NotEmptyValidator $descriptionValidator */
        $descriptionValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
        $descriptionField->addValidator($descriptionValidator);

        /** @var StringLengthValidator $stringLengthValidator */
        $stringLengthValidator = $this->validatorResolver->createValidator(
            StringLengthValidator::class,
            ['minimum' => 5]
        );
        $descriptionField->addValidator($stringLengthValidator);
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addLengthField(Section $section, array $settings): void
    {
        if ((bool)($settings['enable'] ?? false) === true) {
            /** @var GenericFormElement $lengthField */
            $lengthField = $section->createElement('length', 'SingleSelect');
            $lengthField->setLabel($this->getLocalizedLabel($settings['label']));
            $lengthField->setProperty('elementDescription', $this->getLocalizedLabel($settings['description']));
            $lengthField->setProperty('options', [
                '45' => '45 Minutes',
                '90' => '90 Minutes',
            ]);
        }
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addLevelField(Section $section, array $settings): void
    {
        if ((bool)($settings['enable'] ?? false) === true) {
            /** @var GenericFormElement $levelField */
            $levelField = $section->createElement('level', 'SingleSelect');
            $levelField->setLabel($this->getLocalizedLabel($settings['label']));
            $levelField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['description'])
            );
            /** @var NotEmptyValidator $levelValidator */
            $levelValidator = $this->validatorResolver->createValidator(NotEmptyValidator::class);
            $levelField->addValidator($levelValidator);
            $levelFieldOptions = SessionLevelEnum::getOptions();
            foreach ($levelFieldOptions as $levelFieldOptionKey => $levelFieldOptionValue) {
                $levelFieldOptions[$levelFieldOptionKey] = LocalizationUtility::translate($levelFieldOptionValue);
            }
            $prependOptionLabel = ' ';
            if (($settings['prependOptionLabel'] ?? '') !== '') {
                $prependOptionLabel = $this->getLocalizedLabel($settings['prependOptionLabel']);
            }
            $levelField->setProperty('prependOptionLabel', $prependOptionLabel);
            $levelField->setProperty('options', $levelFieldOptions);
        }
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addNorecordingField(Section $section, array $settings): void
    {
        if ((bool)($settings['enable'] ?? false) === true) {
            /** @var GenericFormElement $noRecordingField */
            $noRecordingField = $section->createElement('norecording', 'Checkbox');
            $noRecordingField->setLabel($this->getLocalizedLabel($settings['label']));
            $noRecordingField->setProperty(
                'elementDescription',
                $this->getLocalizedLabel($settings['description'])
            );
        }
    }

    /**
     * @throws TypeDefinitionNotFoundException
     * @throws TypeDefinitionNotValidException
     */
    private function addExplanationText(Page $page, array $settings): void
    {
        $explanationText = $page->createElement('headline', 'StaticText');
        if (!$explanationText instanceof GenericFormElement) {
            throw new \RuntimeException(sprintf(
                'Expected instance of GenericFormElement for headline, got %s',
                get_class($explanationText)
            ));
        }
        $explanationText->setProperty(
            'text',
            $this->getLocalizedLabel($settings['requiredField'])
            . ' ' . $this->getLocalizedLabel($settings['requiredFieldExplanation'])
        );
    }

    /**
     * @throws FinisherPresetNotFoundException
     */
    private function addFinishers(FormDefinition $form, array $settings): void
    {
        $form->addFinisher($this->suggestFormFinisher);

        if ($this->sendingNotificationAllowed($settings)) {
            $options = $settings['suggest']['notification'];
            $options['format'] = 'html';
            $options['recipients'] = [
                $options['recipientAddress'] => $options['recipientName'],
            ];
            $options['replyToRecipients'] = [
                '{email}' => '{fullname}',
            ];
            $form->createFinisher('EmailToReceiver', $options);
        }

        if (is_array($settings['suggest']['confirmation'] ?? []) && $settings['suggest']['confirmation'] !== []) {
            $form->createFinisher('Redirect', $settings['suggest']['confirmation']);
        } else {
            $message = $settings['suggest']['confirmation']['message'] ??
                'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:form.suggest.confirmation';
            $form->createFinisher('Confirmation', [
                'message' => LocalizationUtility::translate($message) ?? '',
            ]);
        }
    }
}
