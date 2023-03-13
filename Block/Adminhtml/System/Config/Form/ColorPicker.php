<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magefan\ThemeOptimized\Block\Adminhtml\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ColorPicker extends Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $html = $element->getElementHtml();
        $value = $this->escapeHtml($element->getData('value'));

        $html .= '<script>
            require(["jquery", "jquery/colorpicker/js/colorpicker", "domReady!"], function ($) {
                $("#'. $element->getId() .'").click(function() {
                })
                var el = $("#' . $element->getHtmlId() . '");

                el.css("background-color", "#' . $value . '");
                el.css("color",  invertColor("#' . $value . '"));

                el.click(function (){
                    $(this).ColorPickerSetColor($(this).val());
                })

                el.ColorPicker({
                    layout: "hex",
                    onChange: function (hsb, hex, rgb) {
                        console.log("onChange");
                        el.css("background-color", "#"+hex);
                        el.css("color",  invertColor("#"+hex));
                        el.val(hex);
                    }
                }).keyup(function() {
                    var value = el.val();
                    $(this).ColorPickerSetColor(value);
                    el.css("background-color", "#" + value);
                     el.css("color",  invertColor("#"+value));
                });
            });
            </script>';

        return $html;
    }
}
