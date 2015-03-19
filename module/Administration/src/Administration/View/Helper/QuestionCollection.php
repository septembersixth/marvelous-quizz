<?php

namespace Administration\View\Helper;

use Administration\Form\Fieldset\QuestionFieldset;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormCollection;
use Zend\Form\Element;
use Zend\Form\Element\Collection as CollectionElement;
use Zend\Form\FieldsetInterface;
use Zend\Form\LabelAwareInterface;

class QuestionCollection extends FormCollection
{
    protected $defaultElementHelper = 'formrow';
    protected $wrapper = '<fieldset%4$s>%2$s%1$s%3$s</fieldset>';
    protected $templateWrapper = '<span data-template="%s%s"></span>';
    protected $deleteTemplate = '<div class="form-group row pull-right" onclick="deleteQuestion(this)">
            <div class="col-lg-8">
                <div class="btn btn-xs btn-default">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    Delete question
                </div>
            </div>
        </div>';


    public function render(ElementInterface $element)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $markup           = '';
        $templateMarkup   = '';
        $elementHelper    = $this->getElementHelper();
        $fieldsetHelper   = $this->getFieldsetHelper();

        if ($element instanceof CollectionElement && $element->shouldCreateTemplate()) {
            $templateMarkup = $this->renderTemplate($element);
        }

        foreach ($element->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof QuestionFieldset) {
                $markup = $this->deleteTemplate.$markup;
            }

            if ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $fieldsetHelper($elementOrFieldset, $this->shouldWrap());
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $elementHelper($elementOrFieldset);
            }
        }

        // Every collection is wrapped by a fieldset if needed
        if ($this->shouldWrap) {
            $attributes = $element->getAttributes();
            unset($attributes['name']);
            $attributesString = count($attributes) ? ' ' . $this->createAttributesString($attributes) : '';

            $label = $element->getLabel();
            $legend = '';

            if (!empty($label)) {
                if (null !== ($translator = $this->getTranslator())) {
                    $label = $translator->translate(
                        $label,
                        $this->getTranslatorTextDomain()
                    );
                }

                if (! $element instanceof LabelAwareInterface || ! $element->getLabelOption('disable_html_escape')) {
                    $escapeHtmlHelper = $this->getEscapeHtmlHelper();
                    $label = $escapeHtmlHelper($label);
                }

                $legend = sprintf(
                    $this->labelWrapper,
                    $label
                );
            }

            $markup = sprintf(
                $this->wrapper,
                $markup,
                $legend,
                $templateMarkup,
                $attributesString
            );
        } else {
            $markup .= $templateMarkup;
        }

        return $markup;
    }

    public function renderTemplate(CollectionElement $collection)
    {
        $elementHelper          = $this->getElementHelper();
        $escapeHtmlAttribHelper = $this->getEscapeHtmlAttrHelper();
        $fieldsetHelper         = $this->getFieldsetHelper();

        $templateMarkup         = '';

        $elementOrFieldset = $collection->getTemplateElement();

        if ($elementOrFieldset instanceof FieldsetInterface) {
            $templateMarkup .= $fieldsetHelper($elementOrFieldset, $this->shouldWrap());
        } elseif ($elementOrFieldset instanceof ElementInterface) {
            $templateMarkup .= $elementHelper($elementOrFieldset);
        }

        return sprintf(
            $this->templateWrapper,
            htmlspecialchars($this->deleteTemplate),
            $escapeHtmlAttribHelper($templateMarkup)
        );
    }
}