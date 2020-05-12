<?php


namespace App\Strategy\Validation;


use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

abstract class BaseFormValidation
{
    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * BaseFormValidation constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function submit(string $form, array $data)
    {
        $form = $this->formFactory->create($form);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            return $form->getData();
        }

        return $this->getErrorsFromForm($form);
    }

    private function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors[0];
                }
            }
        }
        return $errors;
    }
}