<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\MemberStatus;
use App\Entity\Tag;
use App\Repository\MemberStatusRepository;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberExportType extends AbstractType
{
    protected $memberStatusRepository;

    protected $tagRepository;

    public function __construct(MemberStatusRepository $memberStatusRepository, TagRepository $tagRespository)
    {
        $this->memberStatusRepository = $memberStatusRepository;
        $this->tagRepository = $tagRespository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('default_filters', CheckboxType::class, [
                'label' => 'Apply default filters',
                'required' => false,
                'data' => true,
                'help' => 'Excludes: Do Not Contact, Lost, Deceased, Inactive Member Statuses'
            ])
            ->add('mailable', CheckboxType::class, [
                'label' => 'Mailable',
                'required' => false,
                'help' => 'Excludes: Empty Mailing Addresses'
            ])
            ->add('emailable', CheckboxType::class, [
                'label' => 'E-mailable',
                'required' => false,
                'help' => 'Excludes: Empty E-mail Address'
            ])
            ->add('columns', ChoiceType::class, [
                'expanded' => true,
                'multiple' => true,
                'choices' => [
                    'External Identifier' => 'externalIdentifier',
                    'Local Identifier' => 'localIdentifier',
                    'First Name' => 'firstName',
                    'Preferred Name' => 'preferredName',
                    'Middle Name' => 'middleName',
                    'Last Name' => 'lastName',
                    'Display Name' => 'displayName',
                    'Status' => 'status',
                    'Class Year' => 'classYear',
                    'Primary Email' => 'primaryEmail',
                    'Primary Telephone Number' => 'primaryTelephoneNumber',
                    'Mailing Address Line 1' => 'mailingAddressLine1',
                    'Mailing Address Line 2' => 'mailingAddressLine2',
                    'Mailing City' => 'mailingCity',
                    'Mailing State' => 'mailingState',
                    'Mailing Postal Code' => 'mailingPostalCode',
                    'Mailing Country' => 'mailingCountry',
                    'Employer' => 'employer',
                    'Job Title' => 'jobTitle',
                    'Occupation' => 'occupation',
                    'Linkedin URL' => 'linkedinUrl',
                    'Facebook URL' => 'facebookUrl',
                    'Tags' => 'tags',
                    'Is Deceased?' => 'isDeceased',
                    'Is Lost?' => 'isLost',
                    'Is Do Not Contact?' => 'isLocalDoNotContact'
                ],
                'data' => [
                    'displayName',
                    'status',
                    'classYear',
                    'primaryEmail',
                    'primaryTelephoneNumber',
                    'mailingAddressLine1',
                    'mailingAddressLine2',
                    'mailingCity',
                    'mailingState',
                    'mailingPostalCode'
                ]
            ]);
        ;

        if (count($this->memberStatusRepository->findAll())) {
            $builder->add('statuses', EntityType::class, [
                'class' => MemberStatus::class,
                'expanded' => true,
                'multiple' => true,
                'required' => false
            ]);
        }

        if (count($this->tagRepository->findAll())) {
            $builder->add('tags', EntityType::class, [
                'class' => Tag::class,
                'expanded' => true,
                'multiple' => true,
                'required' => false
            ]);
        }
    }
}
